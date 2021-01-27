<?php

namespace Miaoxing\Region\Service;

use Miaoxing\Plugin\BaseModel;
use Miaoxing\Plugin\Model\ModelTrait;
use Miaoxing\Plugin\Service\Model;
use Miaoxing\Region\Metadata\RegionTrait;

class RegionModel extends BaseModel
{
    use ModelTrait;
    use RegionTrait;

    /**
     * @var int[]
     */
    protected $virtualRegions = [
        110000 => 110100, // 北京
        120000 => 120100, // 天津
        310000 => 310100, // 上海
        500000 => 500100, // 重庆
        810000 => 810100, // 香港
        820000 => 820100, // 澳门
    ];

    public function getShortNameAttribute()
    {
        return $this->attributes['short_name'] ?: $this->name;
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parentId');
    }

    /**
     * @param string|int $parentId
     * @param bool $skipVirtual
     * @return $this
     */
    public function whereParentId($parentId, bool $skipVirtual = false): self
    {
        $parentId = (int) $parentId;

        if ($skipVirtual) {
            $parentId = $this->virtualRegions[$parentId] ?? $parentId;
        }

        return $this->where('parentId', $parentId);
    }

    /**
     * Coll: 加载下级地区
     *
     * @param bool $skipVirtual 是否跳过虚拟地区
     * @return $this
     */
    public function loadChildren(bool $skipVirtual = false): self
    {
        $this->load('children');
        if (!$skipVirtual) {
            return $this;
        }

        $virtualRegions = $this->filter(function (RegionModel $region) {
            return isset($this->virtualRegions[$region->id]);
        });

        if ($virtualRegions->count()) {
            $virtualRegions->load('children.children');
            foreach ($virtualRegions as $region) {
                $region->setRelationValue('children', $region->children[0]->children);
            }
        }

        return $this;
    }
}

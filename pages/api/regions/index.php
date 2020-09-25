<?php

use Miaoxing\Plugin\BaseController;
use Miaoxing\Region\Service\RegionModel;

return new class extends BaseController {
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

    public function get($req)
    {
        // 支持编号和名称两种参数
        if (!is_numeric($req['parentId'])) {
            $parentId = RegionModel::select('id')->fetchColumn(['name' => $req['parentId']]);
        } else {
            $parentId = $req['parentId'];
        }

        // 直辖市，特别行政区的下属为区级，当查询只到市级时，改为查询出所属的区级
        if ($req['virtual'] === '0') {
            $parentId = $this->virtualRegions[$parentId] ?? $parentId;
        }

        // TODO 忽略台湾，澳门,香港 onlyChinaMainland

        // 构造基本的查询
        $regions = RegionModel::desc('sort')
            ->where('parent_id', (int) $parentId);

        // 排除指定的区域
        if ($req['exceptIds'] && is_array($req['exceptIds'])) {
            $regions->whereNotIn('id', $req['exceptIds']);
        }

        $regions->all();

        return suc(['data' => $regions]);
    }
};

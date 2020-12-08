<?php

namespace Miaoxing\Region\Metadata;

use Miaoxing\Plugin\Model\ModelTrait;

/**
 * RegionTrait
 *
 * @property int $id
 * @property int $parentId
 * @property string $name
 * @property string $shortName
 * @property int $sort 顺序,从大到小排列
 * @property bool $hasChildren
 * @internal will change in the future
 */
trait RegionTrait
{
    use ModelTrait;

    /**
     * @var array
     * @see CastTrait::$casts
     */
    protected $casts = [
        'id' => 'int',
        'parent_id' => 'int',
        'name' => 'string',
        'short_name' => 'string',
        'sort' => 'int',
        'has_children' => 'bool',
    ];
}

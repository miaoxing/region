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

    public function getShortNameAttribute()
    {
        return $this->attributes['short_name'] ?: $this->name;
    }
}

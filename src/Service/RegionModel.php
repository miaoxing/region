<?php

namespace Miaoxing\Region\Service;

use Miaoxing\Plugin\Service\Model;
use Miaoxing\Region\Metadata\RegionTrait;

class RegionModel extends Model
{
    use RegionTrait;

    public function getShortNameAttribute()
    {
        return $this->data['short_name'] ?: $this->name;
    }
}

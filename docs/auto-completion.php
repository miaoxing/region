<?php

/**
 * @property    Miaoxing\Region\Service\Area $area
 */
class AreaMixin {
}

/**
 * @property    Miaoxing\Region\Service\BaiduApi $baiduApi 百度Web服务API
 */
class BaiduApiMixin {
}

/**
 * @property    Miaoxing\Region\Service\Lbs $lbs Location-based service
 */
class LbsMixin {
}

/**
 * @property    Miaoxing\Region\Service\RegionModel $regionModel
 * @method      Miaoxing\Region\Service\RegionModel regionModel() 返回当前对象
 */
class RegionModelMixin {
}

/**
 * @mixin AreaMixin
 * @mixin BaiduApiMixin
 * @mixin LbsMixin
 * @mixin RegionModelMixin
 */
class AutoCompletion {
}

/**
 * @return AutoCompletion
 */
function wei()
{
    return new AutoCompletion;
}

/** @var Miaoxing\Region\Service\Area $area */
$area = wei()->area;

/** @var Miaoxing\Region\Service\BaiduApi $baiduApi */
$baiduApi = wei()->baiduApi;

/** @var Miaoxing\Region\Service\Lbs $lbs */
$lbs = wei()->lbs;

/** @var Miaoxing\Region\Service\RegionModel $region */
$region = wei()->regionModel;

/** @var Miaoxing\Region\Service\RegionModel|Miaoxing\Region\Service\RegionModel[] $regions */
$regions = wei()->regionModel();

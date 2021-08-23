<?php

use Miaoxing\Plugin\BaseController;
use Miaoxing\Region\Service\RegionModel;

return new class extends BaseController {
    public function get($req)
    {
        // 支持编号和名称两种参数
        if (!is_numeric($req['parentId'])) {
            $parentId = RegionModel::select('id')->fetchColumn(['name' => $req['parentId']]);
        } else {
            $parentId = $req['parentId'];
        }

        // 直辖市，特别行政区的下属为区级，当查询只到市级时，改为查询出所属的区级
        $skipVirtual = isset($req['virtual']) && !$req['virtual'];

        // TODO 忽略台湾，澳门,香港 onlyChinaMainland

        // 构造基本的查询
        $regions = RegionModel::desc('sort')
            ->whereParentId($parentId, $skipVirtual);

        // 排除指定的区域
        if ($req['exceptIds'] && is_array($req['exceptIds'])) {
            $regions->whereNotIn('id', $req['exceptIds']);
        }

        $regions->all();

        if (in_array('children', (array) $req['include'])) {
            $regions->loadChildren($skipVirtual);
        }

        return suc(['data' => $regions]);
    }
};

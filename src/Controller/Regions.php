<?php

namespace Miaoxing\Region\Controller;

class Regions extends \Miaoxing\Plugin\BaseController
{
    protected $guestPages = [
        'regions'
    ];

    public function indexAction($req)
    {
        // 支持编号和名称两种参数
        if (!is_numeric($req['parentId'])) {
            $parentId = wei()->appDb('regions')->select('id')->fetchColumn(['name' => $req['parentId']]);
        } else {
            $parentId = (int)$req['parentId'];
        }

        // 构造基本的查询
        $regions = wei()->appDb('regions')
            ->select('id AS value, name AS label')
            ->desc('sort')
            ->andWhere(['parentId' => $parentId]);

        // 排除指定的区域
        if ($req['exceptIds'] && is_array($req['exceptIds'])) {
            $placeholders = array_fill(0, count($req['exceptIds']), '?');
            $regions->andWhere('id NOT IN(' . implode(', ', $placeholders) . ')', $req['exceptIds']);
        }

        $regions = $regions->fetchAll();

        return $this->suc([
            'data' => $regions,
        ]);
    }
}

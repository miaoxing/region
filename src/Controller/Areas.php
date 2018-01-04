<?php

namespace Miaoxing\Region\Controller;

class Areas extends \Miaoxing\Plugin\BaseController
{
    protected $guestPages = [
        'areas'
    ];

    public function indexAction($req)
    {
        // 构造基本的查询
        $areas = wei()->appDb('areas')
            ->select('id AS value, name AS label')
            ->asc('id')
            ->andWhere(['parentId' => (int)$req['parentId']]);

        // 排除指定的区域
        if ($req['exceptIds'] && is_array($req['exceptIds'])) {
            $placeholders = array_fill(0, count($req['exceptIds']), '?');
            $areas->andWhere('id NOT IN(' . implode(', ', $placeholders) . ')', $req['exceptIds']);
        }

        $areas = $areas->fetchAll();

        return $this->suc([
            'data' => $areas,
        ]);
    }
}

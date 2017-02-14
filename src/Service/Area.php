<?php

namespace Miaoxing\Region\Service;

use miaoxing\plugin\BaseModel;

class Area extends BaseModel
{
    protected $table = 'areas';

    protected $providers = [
        'db' => 'app.db',
    ];

    /**
     * 特殊城市与所属"市辖区"ID的对应关系
     *
     * @var array
     */
    protected $cityIds = [
        '北京市' => 110100,
        '天津市' => 120100,
        '上海市' => 310100,
        '重庆市' => 500100,
    ];

    /**
     * Repo: 根据城市名称,获取城市的编号
     *
     * @param int $city 城市名称
     * @return string
     */
    public function getIdByName($city)
    {
        // 如果是特殊城市,如上海市,转换为上海市"市辖区"的ID
        if (isset($this->cityIds[$city])) {
            return $this->cityIds[$city];
        }

        $areaId = wei()->area()->select('id')->fetchColumn(['name' => $city]);
        if ($areaId) {
            return $areaId;
        }

        return false;
    }
}

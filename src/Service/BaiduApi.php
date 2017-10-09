<?php

namespace Miaoxing\Region\Service;

use miaoxing\plugin\BaseService;
use Wei\Http;
use Wei\Logger;

/**
 * 百度Web服务API
 *
 * @property Logger $logger
 * @method Http http($options)
 * @link http://developer.baidu.com/map/webservice.htm
 */
class BaiduApi extends BaseService
{
    /**
     * 在lbs云官网注册的access key，作为访问的依据
     *
     * @var string
     */
    protected $accessKey;

    /**
     * 浏览器端的access key
     *
     * @var string
     */
    protected $browserAccessKey;

    /**
     * 根据IP获取地址信息
     *
     * 参考错误
     * Array (
     *   [status] => 2
     *   [message] => Request Parameter Error:ak required/参数必须
     *   [uid] => [sk] =>
     *   [logformat] =>
     *   [ak] =>
     * )
     *
     * @param string $ip
     * @return array
     * @link http://developer.baidu.com/map/ip-location-api.htm
     */
    public function getIpInfo($ip)
    {
        $response = $this->http([
            'url' => 'http://api.map.baidu.com/location/ip',
            'referer' => true,
            'dataType' => 'json',
            'timeout' => 30000,
            'throwException' => false,
            'data' => [
                'ak' => $this->accessKey,
                'ip' => $ip,
            ],
        ]);

        if ($response['status'] !== 0) {
            $this->logger->warning('获取IP信息失败', [
                'ip' => $ip,
                'res' => $response->getResponse(),
            ]);
        }

        // 重新构造数据结构,和其他接口保持一致
        $detail = $response['content']['address_detail'];
        $parts = explode('|', $response['address']);

        return [
            'code' => $response['status'] === 0 ? 1 : -$response['status'],
            'province' => $detail['province'],
            'city' => $detail['city'],
            'district' => $detail['district'],
            'street' => $detail['street'],
            'address' => $detail['street'] . $detail['street_number'],
            'point' => $response['content']['point'],
            'isp' => $parts[4],
        ];
    }

    public function getAccessKey()
    {
        return $this->accessKey;
    }

    public function getBrowserAccessKey()
    {
        return $this->browserAccessKey;
    }
}

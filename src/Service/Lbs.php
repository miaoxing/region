<?php

namespace Miaoxing\Region\Service;

use miaoxing\plugin\BaseService;

/**
 * Location-based service
 *
 * @property \Wei\Request $request
 * @property \Wei\Cache $cache
 * @property \Wei\Logger $logger
 * @property BaiduApi $ipApi
 */
class Lbs extends BaseService
{
    protected $providers = [
        'ipApi' => 'baiduApi',
    ];

    /**
     * 根据IP获取详细信息
     *
     * @param null|string $ip
     * @return array
     */
    public function getIpInfo($ip = null)
    {
        $ip || $ip = $this->request->getIp();
        try {
            $that = $this;
            $info = $this->cache->get('ip-info:' . $ip, 86400 * 7, function () use ($ip, $that) {
                return $that->ipApi->getIpInfo($ip);
            });
        } catch (\ErrorException $e) {
            $info = [
                'code' => -1,
                'province' => '',
                'city' => '',
                'district' => '',
                'street' => '',
                'address' => ''
            ];
            $this->logger->warning($e, ['ip' => $ip]);
        }

        return $info;
    }

    /**
     * @param string|null $ip
     * @return array
     */
    public function getIpInfoWithShortName($ip = null)
    {
        $info = $this->getIpInfo($ip);
        $info['province'] = $this->removeSuffix($info['province'], ['省', '自治区']);
        $info['city'] = $this->removeSuffix($info['city'], ['市', '区']);

        return $info;
    }

    protected function removeSuffix($name, $suffixes)
    {
        foreach ($suffixes as $suffix) {
            if ($this->wei->isEndsWith($name, $suffix)) {
                return substr($name, 0, -strlen($suffix));
            }
        }

        return $name;
    }
}

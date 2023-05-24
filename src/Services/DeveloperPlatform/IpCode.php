<?php

namespace Joyarkdev\JoyarkServices\Services\DeveloperPlatform;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpCode
{
    private $host;

    const IP_CODE = "/en/merchant/resource/ipCode";


    public function __construct()
    {
        $this->host = config('joyark-services.developer_api_url');
    }

    /**
     * Get Country Code By Single Ip.
     * @param string $ip
     * @return string|null
     */
    public function getCountryCodeByIp(string $ip)
    {
        try {
            $url = $this->host . self::IP_CODE;
            $request = [
                'ip' => $ip
            ];
            $response = Http::post($url, $request);
            if ($response->successful()) {
                return $response->json()[$ip]['code'] ?? null;
            }
            Log::error("查询IP对应的区域代码失败", ['url' => $url, 'request' => $request, 'response' => $response->json(), 'status' => $response->status()]);
        } catch (\Exception $e) {
            Log::error("查询IP对应的区域代码失败", ['message' => $e->getMessage()]);
        }

        return null;
    }
}

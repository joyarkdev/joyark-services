<?php

namespace Joyarkdev\JoyarkServices\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Joyarkdev\JoyarkServices\Enums\RiskLevel;
use Joyarkdev\JoyarkServices\Services\DeveloperPlatform\IpCode;

/**
 * @group App Review
 */
class AppReviewController extends Controller
{
    /**
     * Get App Review Status
     *
     * @authenticated
     * @header App-Key b131213a82f1dd05a5a9f2bd8c5aeb42
     * @header Version 115
     * @response 200
     */
    public function index(Request $request)
    {
        return [
            'risk_level' => $this->getRiskLevel($request),
        ];
    }

    protected function getRiskLevel(Request $request): RiskLevel
    {
        $countryCode = (new IpCode())->getCountryCodeByIp($request->ip());

        if (in_array($countryCode, ["US", "CA", "MX", "CN"])) {
            return RiskLevel::REVIEW;
        }

        return RiskLevel::PASS;
    }
}

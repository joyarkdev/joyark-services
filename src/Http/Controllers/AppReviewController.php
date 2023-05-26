<?php

namespace Joyarkdev\JoyarkServices\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Joyarkdev\JoyarkServices\Enums\AppReviewStatus;
use Joyarkdev\JoyarkServices\Models\AppReview;
use Joyarkdev\JoyarkServices\Services\AppReviewRiskDetector;

/**
 * @group App Review
 */
class AppReviewController extends Controller
{
    /**
     * Get App Review Status
     *
     * @authenticated
     *
     * @header App-Key b131213a82f1dd05a5a9f2bd8c5aeb42
     * @header Version 115
     *
     * @response 200
     */
    public function index(Request $request)
    {
        $appId = $request->header('package-name') ?? $request->header('app-key');
        return [
            'status' => $this->getStatus($appId),
            'risk_level' => (new AppReviewRiskDetector())
                ->checkIp($request->ip())
                ->checkDeviceId($request->header('device-id'))
                ->checkApp($appId)
                ->checkWhiteListCountries()
                ->checkVersion($request->header('version'))
                ->checkBlackListCountries()
                ->done(),

        ];
    }

    protected function getStatus($appId): AppReviewStatus
    {
        return AppReview::whereAppId($appId)->first()->status ?? AppReviewStatus::DEFAULT;
    }
}

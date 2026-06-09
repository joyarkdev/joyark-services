<?php

namespace Joyarkdev\JoyarkServices\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
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
     * @header Device-Id
     *
     * @response 200
     */
    public function index(Request $request)
    {
        $ip = $request->ip();
        $deviceId = $request->header('device-id');
        $appId = $request->header('package-name') ?? $request->header('app-key');
        $version = $request->header('version');

        $riskLevel = (new AppReviewRiskDetector)
            ->setIp($ip)
            ->setDeviceId($deviceId)
            ->setAppId($appId)
            ->setVersion($version)
            ->check();

        if ($request->header('X-Debug')) {
            Log::error("Risk Level: {$riskLevel->value}");
        }

        return [
            'risk_level' => $riskLevel,
            'app_review' => AppReview::whereAppId($appId)->first()?->makeHidden(['operator', 'operation_time'])->toArray(),
        ];
    }
}

<?php

namespace Joyarkdev\JoyarkServices\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Joyarkdev\JoyarkServices\Enums\AppReviewVisitRecordType;
use Joyarkdev\JoyarkServices\Models\AppReviewVisitRecord;

/**
 * @group App Review
 */
class AppReviewVisitRecordController extends Controller
{
    /**
     * Submit Visit Record
     *
     * @authenticated
     *
     * @header App-Key b131213a82f1dd05a5a9f2bd8c5aeb42
     * @header Version 115
     * @header Device-Id
     *
     * @response 204
     */
    public function create(Request $request)
    {
        $appId = $request->header('package-name') ?? $request->header('app-key');
        $version = $request->header('version');

        $ipRecord = AppReviewVisitRecord::updateOrCreate(
            ['app_id' => $appId, 'version' => $version, 'type' => AppReviewVisitRecordType::IP, 'value' => $request->ip()],
            ['visit_time' => now()]
        );
        $ipRecord->increment('visit_count');

        $deviceIdRecord = AppReviewVisitRecord::updateOrCreate(
            ['app_id' => $appId, 'version' => $version, 'type' => AppReviewVisitRecordType::DEVICE_ID, 'value' => $request->header('device-id')],
            ['visit_time' => now()]
        );
        $deviceIdRecord->increment('visit_count');

        return response()->noContent();
    }
}

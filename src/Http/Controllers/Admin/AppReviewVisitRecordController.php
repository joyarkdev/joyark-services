<?php

namespace Joyarkdev\JoyarkServices\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Joyarkdev\JoyarkServices\Enums\AppReviewVisitRecordStatus;
use Joyarkdev\JoyarkServices\Models\AppReviewVisitRecord;

/**
 * @group App Review Management
 */
class AppReviewVisitRecordController extends Controller
{
    /**
     * Get Visit Records / WhiteList / BlackList
     *
     * @authenticated
     * @queryParam status integer required 0 for visit records 1 for whitelist 2 for blacklist. Example: 0
     * @response 200
     */
    public function index(Request $request)
    {
        $status = $request->get('status') ?? AppReviewVisitRecordStatus::DEFAULT;
        $pageSize = $request->get('pageSize') ?? 20;

        return AppReviewVisitRecord::where('status', $status)
            ->orderByDesc('id')
            ->paginate($pageSize);
    }

    /**
     * Create WhitList / BlackList
     *
     * @authenticated
     * @bodyParam type string required. Example: ip
     * @bodyParam value string required. Example: 127.0.0.1
     * @bodyParam status integer required 0 for visit records 1 for whitelist 2 for blacklist. Example: 0
     * @response 201
     */
    public function create(Request $request)
    {
        return AppReviewVisitRecord::create(array_merge($request->post(), [
            'operator' => auth('admin')->user(),
            'operation_time' => now(),
        ]));
    }

    /**
     * Update WhitList / BlackList
     *
     * @authenticated
     * @urlParam id integer required. Example: 1
     * @bodyParam status integer required 0 for visit records 1 for whitelist 2 for blacklist. Example: 0
     * @response 200
     */
    public function update($id, Request $request)
    {
        $records = AppReviewVisitRecord::find($id);
        $records->update(array_merge($request->post(), [
            'operator' => auth('admin')->user(),
            'operation_time' => now(),
        ]));

        return $records;
    }
}

<?php

namespace Joyarkdev\JoyarkServices\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
     *
     * @queryParam start_time string Start Time.
     * @queryParam end_time string End Time.
     * @queryParam app_id string App Id.
     * @queryParam version string Version.
     * @queryParam type string Type.
     * @queryParam status integer required 0 for visit records 1 for whitelist 2 for blacklist. Example: 0
     *
     * @response 200
     */
    public function index(Request $request)
    {
        $pageSize = $request->input('pageSize') ?? 20;

        $query = AppReviewVisitRecord::query();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($startTime = $request->input('start_time')) {
            $query->where('created_at', '>=', $startTime);
        }

        if ($endTime = $request->input('end_time')) {
            $query->where('created_at', '<=', $endTime);
        }

        if ($appId = $request->input('app_id')) {
            $query->where('app_id', $appId);
        }

        if ($version = $request->input('version')) {
            $query->where('version', $version);
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        return $query->orderByDesc('id')->paginate($pageSize);
    }

    /**
     * Create WhitList / BlackList
     *
     * @authenticated
     *
     * @bodyParam type string required. Example: ip
     * @bodyParam value string required. Example: 127.0.0.1
     * @bodyParam status integer required 0 for visit records 1 for whitelist 2 for blacklist. Example: 0
     *
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
     *
     * @urlParam id integer required. Example: 1
     *
     * @bodyParam status integer required 0 for visit records 1 for whitelist 2 for blacklist. Example: 0
     *
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

    /**
     * Batch Update WhitList / BlackList
     *
     * @authenticated
     *
     * @bodyParam id integer required. Example: 1
     * @bodyParam status integer required 0 for visit records 1 for whitelist 2 for blacklist. Example: 0
     *
     * @response 204
     */
    public function batchUpdate(Request $request)
    {
        foreach ($request->post() as $item) {
            $records = AppReviewVisitRecord::find($item['id']);
            $records->update(array_merge($item, [
                'operator' => auth('admin')->user(),
                'operation_time' => now(),
            ]));
        }

        return response()->noContent();
    }
}

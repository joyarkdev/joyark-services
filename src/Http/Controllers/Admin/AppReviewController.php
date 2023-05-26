<?php

namespace Joyarkdev\JoyarkServices\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Joyarkdev\JoyarkServices\Models\AppReview;

/**
 * @group App Review Management
 */
class AppReviewController extends Controller
{
    /**
     * Get Apps
     *
     * @authenticated
     * @response 200
     */
    public function index(Request $request)
    {
        $pageSize = $request->get('pageSize') ?? 20;

        return AppReview::orderBy('rank')->paginate($pageSize);
    }

    /**
     * Create App
     *
     * @authenticated
     * @bodyParam goods_type integer required Goods Type. Example: 2
     * @bodyParam app_id string required App Key / Package Name. Example: b131213a82f1dd05a5a9f2bd8c5aeb42
     * @bodyParam app_name string required App Name.
     * @bodyParam version string required Version.
     * @bodyParam status string required Status. Example: 0
     * @bodyParam charge_text string Charge Text.
     * @bodyParam charge_url string Charge Url.
     * @bodyParam black_list_countries string required Countries in black list.
     * @bodyParam white_list_countries integer required Countries in white list.
     * @bodyParam download_link string Download Link.
     * @bodyParam remark string Remark.
     * @bodyParam rank integer Rank. Example: 1
     * @response 201
     */
    public function create(Request $request)
    {
        return AppReview::create(array_merge($request->post(), [
            'operator' => auth('admin')->user(),
            'operation_time' => now(),
        ]));
    }

    /**
     * Update App
     *
     * @authenticated
     * @urlParam id integer required Goods ID. Example: 1
     * @bodyParam goods_type integer required Goods Type. Example: 2
     * @bodyParam app_id string required App Key / Package Name. Example: b131213a82f1dd05a5a9f2bd8c5aeb42
     * @bodyParam app_name string required App Name.
     * @bodyParam version string required Version.
     * @bodyParam status string required Status. Example: 0
     * @bodyParam charge_text string Charge Text.
     * @bodyParam charge_url string Charge Url.
     * @bodyParam black_list_countries string required Countries in black list.
     * @bodyParam white_list_countries integer required Countries in white list.
     * @bodyParam download_link string Download Link.
     * @bodyParam remark string Remark.
     * @bodyParam rank integer Rank. Example: 1
     * @response 200
     */
    public function update($id, Request $request)
    {
        $goods = AppReview::find($id);
        $goods->update(array_merge($request->post(), [
            'operator' => auth('admin')->user(),
            'operation_time' => now(),
        ]));

        return $goods;
    }
}

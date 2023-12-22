<?php

use Illuminate\Support\Facades\Route;

$prefix = config('joyark-services.api_url', 'api');
$middleware = config('joyark-services.api_middleware', ['api']);

Route::middleware($middleware)
    ->prefix($prefix)
    ->group(function () {
        Route::match(['get', 'post'], '/app-review', [\Joyarkdev\JoyarkServices\Http\Controllers\AppReviewController::class, 'index']);
        Route::post('/app-review-visit-records', [\Joyarkdev\JoyarkServices\Http\Controllers\AppReviewVisitRecordController::class, 'create']);
    });

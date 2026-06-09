<?php

use Illuminate\Support\Facades\Route;
use Joyarkdev\JoyarkServices\Http\Controllers\AppReviewController;
use Joyarkdev\JoyarkServices\Http\Controllers\AppReviewVisitRecordController;

$prefix = config('joyark-services.api_url', 'api');
$middleware = config('joyark-services.api_middleware', ['api']);

Route::middleware($middleware)
    ->prefix($prefix)
    ->group(function () {
        Route::match(['get', 'post'], '/app-review', [AppReviewController::class, 'index']);
        Route::post('/app-review-visit-records', [AppReviewVisitRecordController::class, 'create']);
    });

<?php

use Illuminate\Support\Facades\Route;

$prefix = config('joyark-services.admin_url', 'admin');
$middleware = config('joyark-services.admin_middleware', ['admin']);

Route::middleware($middleware)
    ->prefix($prefix)
    ->group(function () {
        Route::get('/app-review', [\Joyarkdev\JoyarkServices\Http\Controllers\Admin\AppReviewController::class, 'index']);
        Route::post('/app-review', [\Joyarkdev\JoyarkServices\Http\Controllers\Admin\AppReviewController::class, 'create']);
        Route::put('/app-review/{id}', [\Joyarkdev\JoyarkServices\Http\Controllers\Admin\AppReviewController::class, 'update']);
        Route::get('/app-review-records', [\Joyarkdev\JoyarkServices\Http\Controllers\Admin\AppReviewVisitRecordController::class, 'index']);
        Route::post('/app-review-records', [\Joyarkdev\JoyarkServices\Http\Controllers\Admin\AppReviewVisitRecordController::class, 'create']);
        Route::put('/app-review-records/{id}', [\Joyarkdev\JoyarkServices\Http\Controllers\Admin\AppReviewVisitRecordController::class, 'update']);
        Route::put('/app-review-records', [\Joyarkdev\JoyarkServices\Http\Controllers\Admin\AppReviewVisitRecordController::class, 'batchUpdate']);
    });

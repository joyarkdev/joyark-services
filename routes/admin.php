<?php

use Illuminate\Support\Facades\Route;
use Joyarkdev\JoyarkServices\Http\Controllers\Admin\AppReviewController;
use Joyarkdev\JoyarkServices\Http\Controllers\Admin\AppReviewVisitRecordController;

$prefix = config('joyark-services.admin_url', 'admin');
$middleware = config('joyark-services.admin_middleware', ['admin']);

Route::middleware($middleware)
    ->prefix($prefix)
    ->group(function () {
        Route::get('/app-review', [AppReviewController::class, 'index']);
        Route::post('/app-review', [AppReviewController::class, 'create']);
        Route::put('/app-review/{id}', [AppReviewController::class, 'update']);
        Route::get('/app-review-records', [AppReviewVisitRecordController::class, 'index']);
        Route::post('/app-review-records', [AppReviewVisitRecordController::class, 'create']);
        Route::put('/app-review-records/{id}', [AppReviewVisitRecordController::class, 'update']);
        Route::put('/app-review-records', [AppReviewVisitRecordController::class, 'batchUpdate']);
    });

<?php

use Illuminate\Support\Facades\Route;

$prefix = config('joyark-services.api_url', '/api');
$middleware = config('joyark-services.api_middleware', []);

Route::middleware($middleware)
    ->group(function () use ($prefix) {
        Route::get($prefix.'/app-review', [\Joyarkdev\JoyarkServices\Http\Controllers\AppReviewController::class, 'index']);
    });

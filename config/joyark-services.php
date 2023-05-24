<?php

// config for Joyarkdev/JoyarkServices
return [
    'api_prefix' => 'api',

    'admin_prefix' => 'admin',

    'api_middleware' => ['api'],

    'admin_middleware' => ['admin'],

    'developer_api_url' => env('DEVELOPER_API_URL'),
];

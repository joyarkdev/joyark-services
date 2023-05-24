<?php

namespace Joyarkdev\JoyarkServices\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Joyarkdev\JoyarkServices\JoyarkServices
 */
class JoyarkServices extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Joyarkdev\JoyarkServices\JoyarkServices::class;
    }
}

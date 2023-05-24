<?php

namespace Joyarkdev\JoyarkServices;

use Joyarkdev\JoyarkServices\Commands\JoyarkServicesCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class JoyarkServicesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('joyark-services')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_joyark-services_table')
            ->hasCommand(JoyarkServicesCommand::class);
    }
}

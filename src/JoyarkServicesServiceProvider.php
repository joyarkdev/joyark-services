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
            ->hasMigrations('create_app_review_table', 'create_app_review_records_table')
            ->hasRoutes('api')
            ->hasCommand(JoyarkServicesCommand::class);
    }
}

<?php

namespace Joyarkdev\JoyarkServices\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Joyarkdev\JoyarkServices\JoyarkServicesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Joyarkdev\\JoyarkServices\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            JoyarkServicesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_joyark-services_table.php.stub';
        $migration->up();
        */
    }
}

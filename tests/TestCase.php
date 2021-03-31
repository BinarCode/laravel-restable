<?php

namespace BinarCode\LaravelRestable\Tests;

use BinarCode\LaravelRestable\LaravelRestableServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->migrations();
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelRestableServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function migrations(): void
    {
        $this->loadMigrationsFrom([
            '--database' => 'sqlite',
            '--path' => realpath(__DIR__.DIRECTORY_SEPARATOR.'database/migrations'),
        ]);
    }
}

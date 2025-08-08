<?php

namespace Sdkwala\ActivityLogger\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sdkwala\ActivityLogger\ActivityLoggerServiceProvider;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            ActivityLoggerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Create test_models table for testing
        Schema::create('test_models', function ($table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Run the activity_logs migration
        $migrationPath = __DIR__ . '/../database/migrations/create_activity_logs_table.php.stub';
        $migration = require $migrationPath;
        $migration->up();
    }
}

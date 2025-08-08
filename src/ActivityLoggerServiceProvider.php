<?php

namespace Sdkwala\ActivityLogger;

use Illuminate\Support\ServiceProvider;
use Sdkwala\ActivityLogger\Observers\ModelEventObserver;

class ActivityLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/activity-logger.php' => config_path('activity-logger.php'),
        ], 'config');

        // Publish migration
        if (! class_exists('CreateActivityLogsTable')) {
            $timestamp = date('Y_m_d_His', time());
            $this->publishes([
                __DIR__.'/../database/migrations/create_activity_logs_table.php.stub' => database_path("migrations/{$timestamp}_create_activity_logs_table.php"),
            ], 'migrations');
        }

        // Register observer for models in config
        $models = config('activity-logger.models', []);
        foreach ($models as $modelClass) {
            if (class_exists($modelClass)) {
                $modelClass::observe(ModelEventObserver::class);
            }
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/activity-logger.php', 'activity-logger'
        );
    }
}
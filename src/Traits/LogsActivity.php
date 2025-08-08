<?php

namespace Sdkwala\ActivityLogger\Traits;

use Sdkwala\ActivityLogger\Observers\ModelEventObserver;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::observe(ModelEventObserver::class);
    }
}
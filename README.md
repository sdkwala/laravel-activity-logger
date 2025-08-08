# Laravel Activity Logger

A Laravel package to log model events (created, updated, deleted) to a database table, with hybrid model registration.

[![Tests](https://github.com/sdkwala/laravel-activity-logger/workflows/Tests/badge.svg)](https://github.com/sdkwala/laravel-activity-logger/actions)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sdkwala/laravel-activity-logger.svg)](https://packagist.org/packages/sdkwala/laravel-activity-logger)
[![Total Downloads](https://img.shields.io/packagist/dt/sdkwala/laravel-activity-logger.svg)](https://packagist.org/packages/sdkwala/laravel-activity-logger)

## Features

- ✅ **Hybrid Model Registration**: Use trait or config file to register models
- ✅ **Event Logging**: Log created, updated, and deleted events
- ✅ **Flexible Configuration**: Customize events and retention periods
- ✅ **Cleanup Command**: Remove old logs automatically
- ✅ **Laravel 9, 10, 11, 12 Support**: Compatible with multiple Laravel versions
- ✅ **PHP 8.1+ Support**: Modern PHP features

## Installation

```bash
composer require sdkwala/laravel-activity-logger
```

## Publish Config & Migration

```bash
php artisan vendor:publish --provider="Sdkwala\ActivityLogger\ActivityLoggerServiceProvider"
php artisan migrate
```

## Usage

### 1. Using the Trait

Add the trait to any Eloquent model:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sdkwala\ActivityLogger\Traits\LogsActivity;

class Post extends Model
{
    use LogsActivity;
    
    protected $fillable = ['title', 'content'];
}
```

### 2. Using the Config File

List model class names in `config/activity-logger.php`:

```php
<?php

return [
    'models' => [
        App\Models\Post::class,
        App\Models\User::class,
        App\Models\Comment::class,
    ],
    // ... other config
];
```

### 3. Viewing Activity Logs

```php
use Sdkwala\ActivityLogger\Models\ActivityLog;

// Get all activity logs
$logs = ActivityLog::all();

// Get logs for a specific model
$postLogs = ActivityLog::where('model_type', Post::class)
    ->where('model_id', $post->id)
    ->get();

// Get logs by event type
$createdLogs = ActivityLog::where('event', 'created')->get();
```

### Cleanup Old Logs

Delete logs older than 30 days (default):

```bash
php artisan sdkwala:activity-logger:cleanup
```

Or specify days:

```bash
php artisan sdkwala:activity-logger:cleanup --days=60
```

## Configuration

The configuration file `config/activity-logger.php` contains:

```php
<?php

return [
    // List of model class names to observe for activity logging
    'models' => [
        // App\Models\Post::class,
    ],

    // Events to log
    'events' => [
        'created',
        'updated', 
        'deleted',
    ],

    // Default retention for cleanup command (in days)
    'cleanup_retention_days' => 30,
];
```

## Database Schema

The `activity_logs` table contains:

- `id` - Primary key
- `model_type` - Full class name of the model
- `model_id` - ID of the model instance
- `event` - Event type (created, updated, deleted)
- `old_values` - JSON of previous values (for updates)
- `new_values` - JSON of new values
- `user_id` - ID of the authenticated user (if any)
- `created_at` - Timestamp of the activity

## Testing

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

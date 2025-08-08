<?php

return [
    // List of model class names to observe for activity logging (in addition to those using the trait)
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
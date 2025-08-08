<?php

namespace Sdkwala\ActivityLogger\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'model_type',
        'model_id',
        'event',
        'old_values',
        'new_values',
        'user_id',
        'created_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];
}
<?php

namespace Sdkwala\ActivityLogger\Console\Commands;

use Illuminate\Console\Command;
use Sdkwala\ActivityLogger\Models\ActivityLog;
use Carbon\Carbon;

class CleanupActivityLogs extends Command
{
    protected $signature = 'sdkwala:activity-logger:cleanup {--days= : Retain logs for this many days (default from config)}';
    protected $description = 'Delete activity logs older than the specified number of days';

    public function handle()
    {
        $days = $this->option('days') ?? config('activity-logger.cleanup_retention_days', 30);
        $cutoff = Carbon::now()->subDays($days);

        $count = ActivityLog::where('created_at', '<', $cutoff)->delete();

        $this->info("Deleted {$count} activity log(s) older than {$days} days.");
    }
}
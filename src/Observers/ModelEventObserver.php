<?php

namespace Sdkwala\ActivityLogger\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Sdkwala\ActivityLogger\Models\ActivityLog;

class ModelEventObserver
{
    public function created(Model $model)
    {
        $this->logActivity($model, 'created', [], $model->getAttributes());
    }

    public function updated(Model $model)
    {
        $this->logActivity($model, 'updated', $model->getOriginal(), $model->getAttributes());
    }

    public function deleted(Model $model)
    {
        $this->logActivity($model, 'deleted', $model->getOriginal(), []);
    }

    protected function logActivity(Model $model, string $event, array $oldValues, array $newValues)
    {
        $events = config('activity-logger.events', ['created', 'updated', 'deleted']);
        if (!in_array($event, $events)) {
            return;
        }

        ActivityLog::create([
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'event' => $event,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);
    }
}
<?php

namespace Sdkwala\ActivityLogger\Tests;

use Illuminate\Database\Eloquent\Model;
use Sdkwala\ActivityLogger\Models\ActivityLog;
use Sdkwala\ActivityLogger\Traits\LogsActivity;

class ActivityLoggerTest extends TestCase
{
    public function test_activity_log_is_created_when_model_is_created()
    {
        $testModel = new TestModel();
        $testModel->name = 'Test Name';
        $testModel->save();

        $this->assertDatabaseHas('activity_logs', [
            'model_type' => TestModel::class,
            'model_id' => $testModel->id,
            'event' => 'created',
        ]);
    }

    public function test_activity_log_is_created_when_model_is_updated()
    {
        $testModel = new TestModel();
        $testModel->name = 'Original Name';
        $testModel->save();

        $testModel->name = 'Updated Name';
        $testModel->save();

        $this->assertDatabaseHas('activity_logs', [
            'model_type' => TestModel::class,
            'model_id' => $testModel->id,
            'event' => 'updated',
        ]);
    }

    public function test_activity_log_is_created_when_model_is_deleted()
    {
        $testModel = new TestModel();
        $testModel->name = 'Test Name';
        $testModel->save();

        $testModel->delete();

        $this->assertDatabaseHas('activity_logs', [
            'model_type' => TestModel::class,
            'model_id' => $testModel->id,
            'event' => 'deleted',
        ]);
    }
}

// Test model for testing
class TestModel extends Model
{
    use LogsActivity;

    protected $table = 'test_models';
    protected $fillable = ['name'];
}

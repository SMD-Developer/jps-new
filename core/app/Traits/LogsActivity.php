<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Log an activity.
     *
     * @param string $description
     * @param string|null $event
     * @param Model|null $subject
     * @param array|null $properties
     * @return ActivityLog
     */
    public function logActivity(
        string $description,
        string $event = null,
        Model $subject = null,
        array $properties = null
    ): ActivityLog {
        return ActivityLog::create([
            'log_name' => 'application',
            'description' => $description,
            'event' => $event,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'properties' => $properties,
            'causer_type' => Auth::user() ? get_class(Auth::user()) : null,
            'causer_id' => Auth::id(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log changes between old and new data.
     *
     * @param string $description
     * @param string $event
     * @param Model $subject
     * @param array $oldData
     * @param array $newData
     * @return ActivityLog
     */
    public function logChanges(
        string $description,
        string $event,
        Model $subject,
        array $oldData,
        array $newData
    ): ActivityLog {
        $changes = [];
        
       foreach ($newData as $key => $value) {
            if (array_key_exists($key, $oldData)) {  // Added missing closing parenthesis
                if ($oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }
        }

        return $this->logActivity($description, $event, $subject, $changes);
    }
}
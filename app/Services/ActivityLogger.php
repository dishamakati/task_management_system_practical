<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ActivityLogger
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function log(
        string $action,
        string $description,
        ?string $subjectType = null,
        ?int $subjectId = null,
        array $properties = []
    ): void {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'System',
            'action' => $action,
            'description' => $description,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'properties' => $properties ?: null,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tasks extends Model
{
   use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'assigned_by',
        'assigned_to',
        'start_date',
        'due_date',
        'priority',
        'status',
    ];

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $guarded = [];
    protected $casts = [
        'properties' => 'collection',
    ];

    public function subject()
    {
        return $this->morphTo();
    }

    public function causer()
    {
        return $this->morphTo();
    }
    
    
    // public function causer()
    // {
    //     return $this->belongsTo(\App\Models\User::class, 'causer_id', 'uuid'); // or 'id' depending on your setup
    // }
}
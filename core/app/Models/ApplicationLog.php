<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationLog extends Model
{
    protected $table = 'application_logs';

    protected $fillable = [
        'application_id',
        'user_id',
        'user_type',
        'action',
        'status_from',
        'status_to',
        'remarks',
        'additional_data',
        'action_at',
    ];

    protected $casts = [
        'additional_data' => 'array', 
        'action_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'uuid');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PasswordAttempt extends Model
{
    protected $fillable = [
        'client_id',
        'admin_id',
        'attempt_time',
        'successful',
        'locked_until',
        'is_admin_locked'
    ];
    
    protected $casts = [
        'attempt_time' => 'datetime',
        'locked_until' => 'datetime',
        'successful' => 'boolean',
        'is_admin_locked'=>'boolean'
    ];
    
     public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'uuid');
    }
}

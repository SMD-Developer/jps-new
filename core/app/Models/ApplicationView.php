<?php
// App/Models/ApplicationView.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationView extends Model
{
    protected $table = "application_views";

    protected $fillable = [
        'application_id',
        'user_id',
        'user_name',
        'user_type',
        'action_type',
        'viewed_at',
        'ip_address',
        'user_agent'
    ];

    protected $dates = ['viewed_at'];
}

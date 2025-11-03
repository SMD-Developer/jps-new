<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirdPartyPrint extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'name',
        'id_number',
        'address',
        'email'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
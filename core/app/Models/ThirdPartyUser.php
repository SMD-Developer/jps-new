<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ThirdPartyUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'third_party_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_card_number',
        'address',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with payments
    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'third_party_id');
    }

    // If you have a different password column name, override this method
    // public function getAuthPassword()
    // {
    //     return $this->password;
    // }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdPartyUser extends Model
{
    protected $table = 'third_party_users';

    protected $fillable = [
        'name',
        'email',
        'id_card_number',
        'address',
        'password',
        'status'
    ];

    
}

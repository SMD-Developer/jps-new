<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class ClientRegisterModel extends Model
{
    use HasFactory;
    protected $table="client_register"; 
    use Notifiable;
    
     public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'accountType', 'client_id'); 
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id', 'client_id');
    }
    
    public function clientRegister()
    {
        return $this->hasOne(\App\Models\ClientRegister::class, 'client_id');
    }
    
    protected $fillable=[
                        'client_id',
                        'accountType',  //
                        'email',
                        'password',
                        'setPassword',
                        'userName',
                        'idCardNumber',
                        'registeredAddress',
                        'postalCode',
                        'state', 
                        'state_id' , //
                        'district', 
                        'district_id', //
                        'city',
                        'mobileNumber',
                        'landline',
                        'securityQuestion1',//
                        'securityAnswers1',
                        'securityQuestions2',//
                        'securityAnswers2',
                        'terms',
                        'email_verified_at',
                        'is_email_verified'
                                     
    ];
    
}



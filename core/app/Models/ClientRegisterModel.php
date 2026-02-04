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
        return $this->belongsTo(\App\Models\AccountType::class, 'accountType', 'id');
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
                        'accountType',  
                        'id_type',
                        'email',
                        'password',
                        'setPassword',
                        'userName',
                        'idCardNumber',
                        'registeredAddress',
                        'postalCode',
                        'state', 
                        'state_id' , 
                        'district', 
                        'district_id', 
                        'city',
                        'mobileNumber',
                        'landline',
                        'securityQuestion1',
                        'securityAnswers1',
                        'securityQuestions2',
                        'securityAnswers2',
                        'terms',
                        'email_verified_at',
                        'is_email_verified'
                                     
    ];


    public function latestApplication()
    {
        return $this->hasOne(Application::class, 'user_id', 'client_id')
                    ->latest('created_at');
    }
    

    public function passwordAttempts()
    {
        return $this->hasMany(PasswordAttempt::class, 'client_id', 'client_id');
    }


}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClientRegisterModel;

class Application extends Model
{
    protected $table="applications";

    protected $fillable = [
        'refference_no',
        'land_category', 
        'base_amount',
        'rate',
        'hectare',
        'adjustment_percentage',
        'discount_amount',
        'total_amount',
        'cost',
        'payment_status',
        'transaction',
        'print_status_count',
        'deposit_date',
        'receipt_path',
        'note',
        'payment_rejection_reason',
        'land_unit',
        'reciept_number',
        'adjustment_type',
        'appeal',
        'remark',
        'rejected_at',
        'resubmitted_at',
        'resubmission_count',
        'appeal_status'
    ];
    
    // public function state(){
        
    //   return    $this->hasOne(State::class,'idnegeri','state');
        
    // }
    
    public function state()
    {
        return $this->belongsTo(State::class, 'state', 'idnegeri');
    }
    
     public function landDistrict(){
        
         return  $this->hasOne(District::class,'iddaerah','land_district');
        
    }
    
     public function landDivision(){
        
         return    $this->hasOne(Division::class,'idmukim','land_state');
        
    }
    
    public function client()
    {
        return $this->hasOne(ClientRegisterModel::class, 'client_id', 'user_id'); 
    }
    
    public function applicant()
    {
     return $this->belongsTo(ClientRegisterModel::class, 'user_id', 'client_id');
    }


    public function division()
    {
     return $this->belongsTo(\App\Models\Division::class, 'land_state', 'idmukim');
    }
    
    
    public function adminStaff()
    {
      return $this->belongsTo(User::class, 'admin_staff_id', 'uuid');
    }

    public function adminApprover()
    {
      return $this->belongsTo(User::class, 'admin_approver_id', 'uuid');
    }

    public function logs()
    {
         return $this->hasMany(ApplicationLog::class, 'application_id', 'id');
    }
    
    public function views()
    {
      return $this->hasMany(ApplicationView::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class, 'application_id', 'id');
    }
    
    
    public function payments()
    {
        return $this->hasMany(Payment::class, 'application_id');
    }
    
    
    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'application_id')->latest('created_at');
    }
    
    
    public function accountType()
    {
        return $this->hasOneThrough(
            AccountType::class,
            ClientRegisterModel::class,
            'client_id', // Foreign key on ClientRegisterModel table
            'id', // Foreign key on AccountType table  
            'user_id', // Local key on Application table
            'accountType' // Local key on ClientRegisterModel table
        );
    }
    
    
    public function district()
    {
        return $this->belongsTo(District::class, 'district', 'iddaerah');
    }
    
}

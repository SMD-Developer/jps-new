<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimContribution extends Model
{
    protected $table = "claim_contribution";

    protected $fillable = [
        'user_id',
        'applicant',
        'identities',
        'address',
        'postal_code',
        'city',
        'state',
        'district',
        'email',
        'phone',
        'land_lot',
        'land_area',
        'land_unit',
        'land_district',
        'land_state',
        'land_grant',
        'permission_plan',
        'letter_of_support',
        'uploade_date',
        'status',
        'is_viewed'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'uploade_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
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
}
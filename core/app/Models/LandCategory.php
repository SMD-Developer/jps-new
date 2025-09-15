<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandCategory extends Model
{
    use HasFactory;

    protected $table = 'land_category';
     protected $fillable = ['category', 'rate', 'currency', 'status'];


    protected $casts = [
        'rate' => 'decimal:2',
        'status' => 'integer'
    ];


    public $timestamps = false; 


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

 
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }


    public function getFormattedRateAttribute()
    {
        return $this->currency . ' ' . number_format($this->rate, 2);
    }

 
    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? 'Active' : 'Inactive';
    }
}

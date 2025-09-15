<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table="district";

    protected $primaryKey = 'iddaerah';


    public function divisions()
    {
        return $this->hasMany(Division::class, 'daerah_id', 'iddaerah');
    }

}

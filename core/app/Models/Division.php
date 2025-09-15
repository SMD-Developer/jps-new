<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
   protected $table = 'division';

   protected $primaryKey = 'idmukim';

   public function district()
    {
        return $this->belongsTo(District::class, 'daerah_id', 'iddaerah');
    }
}

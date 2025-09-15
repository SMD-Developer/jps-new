<?php

namespace App\Models;

use App\Traits\UuidModel;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
}

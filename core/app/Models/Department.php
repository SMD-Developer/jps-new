<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments'; // Define the table name

    protected $fillable = ['name', 'display_name', 'status']; // Fillable fields

    public function roles()
    {
        return $this->hasMany(Role::class, 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'department_id', 'id'); // id → department_id in users
    }
}

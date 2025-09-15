<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'name',
        'email',
        'image',
        'role_id',
        'department_id',
        'status'
    ];

    // Relationship with Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relationship with Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}


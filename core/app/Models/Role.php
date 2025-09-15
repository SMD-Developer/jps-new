<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use UuidModel;
    public $incrementing = false;
    protected $fillable = ['name',  'display_name', 'description', 'department_id'];
    protected $primaryKey = 'uuid';

    // public function permissions(): BelongsToMany
    // {
    //     return $this->belongsToMany(Permission::class)->select(array('name'));
    // }
    
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_roles', 'role_uuid', 'permission_uuid')
        ->select(array('name'));
    }

       public function users(): HasMany
        {
            return $this->hasMany(User::class, 'role_id', 'uuid');
        }

    public function assign($permissions): array
    {
        return $this->permissions()->sync($permissions);
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

}

<?php namespace App\Services;

// app/Services/RolePermissionService.php
namespace App\Services;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolePermissionService
{
    public function assignRoleToUser(User $user, $roleUuid)
    {
        $user->role_id = $roleUuid;
        $user->save();
        return $user;
    }
    
    public function assignPermissionsToRole(Role $role, array $permissionIds)
    {
        return $role->assign($permissionIds);
    }
    
    public function createRole(array $data)
    {
        return Role::create($data);
    }
    
    public function createPermission(array $data)
    {
        return Permission::create($data);
    }
}
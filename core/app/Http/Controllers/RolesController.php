<?php

namespace App\Http\Controllers;

use App\Datatables\RoleDatatable;
use App\Http\Forms\RoleForm;
use App\Http\Requests\RoleFormRequest;
use App\Invoicer\Repositories\Contracts\PermissionInterface;
use App\Invoicer\Repositories\Contracts\RoleInterface;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\Permission;
use App\Models\PasswordAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; 


class RolesController extends CrudController {
    protected $permissionRepository;
    protected $datatable = RoleDatatable::class;
    protected string $formClass = RoleForm::class;
    protected $formRequest = RoleFormRequest::class;
    protected string $heading =  'app.roles';
    protected string $icon = 'users';
    protected string $btnCreateText = 'app.new_role';
    protected string $iconCreate = 'plus';
    protected bool $settingsMode = true;
    protected array $routes = [
        'index' => 'settings.role.index',
        'create' => 'settings.role.create',
        'store' => 'settings.role.store',
        'update' => 'settings.role.update'
    ];
    public function __construct(RoleInterface $roleInterface, PermissionInterface $permissionInterface){
        parent::__construct();
        $this->entityClass = Role::class;
        $this->repository = $roleInterface;
        $this->permissionRepository = $permissionInterface;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('role.create'));
            return $next($request);
        });
    }

    public function show($id){
        $role = $this->repository->getById($id);
        $permissions = $this->permissionRepository->all()->sortBy('name');
        return view('settings.roles.permissions', compact('role','permissions'));
    }

    public function assignPermission(Request $request){
        $role = $this->repository->getById($request->input('role_id'));
        if($role && $role->assign($request->permissions)){
            flash()->success(trans('app.record_updated'));
            return Response::json(array('success' => true, 'msg' => trans('app.record_updated')), 200);
        }
        return null;
    }




    // public function addRole()
    // {
    //     $title = 'Peranan';
    //     $users = DB::table('users')
    //         ->leftJoin(DB::raw('(
    //             SELECT admin_id, is_admin_locked, created_at 
    //             FROM password_attempts pa1
    //             WHERE created_at = (
    //                 SELECT MAX(created_at) 
    //                 FROM password_attempts pa2 
    //                 WHERE pa2.admin_id = pa1.admin_id
    //             )
    //         ) as password_attempts'), 'users.uuid', '=', 'password_attempts.admin_id')
    //         ->leftJoin('roles', 'users.role_id', '=', 'roles.uuid')
    //         ->select(
    //             'users.*',
    //             'roles.name as role_name',
    //             'roles.uuid as role_uuid',
    //             'password_attempts.is_admin_locked as is_blocked' 
    //         )
    //         ->get()
    //         ->map(function($user) {
    //             $user->is_blocked = !empty($user->is_blocked) && $user->is_blocked == 1;
    //             return $user;
    //         });
        
    //     $roles = Role::with('department')->get()->map(function($role) use ($users) {
    //         $roleUsers = $users->where('role_uuid', $role->uuid);
            
    //         // Group by UUID and ensure we keep the correct status
    //         $uniqueUsers = $roleUsers->groupBy('uuid')->map(function($group) {
    //             // If any record shows blocked, use that one
    //             $blockedUser = $group->firstWhere('is_blocked', true);
    //             return $blockedUser ?: $group->first();
    //         })->values();
            
    //         $role->users = $uniqueUsers;
    //         return $role;
    //     })->filter(fn($role) => !empty($role->users) && $role->users->count() > 0);
    
    //     $departments = Department::where('status', 1)->get();
    //     $permissionGroups = DB::table('permission_group')->where('group_status', 1)->get();
        
    //     $groupedPermissions = [];
    //     foreach ($permissionGroups as $group) {
    //         $permissions = Permission::where('permission_group', $group->id)
    //             ->where('status', 1)
    //             ->get();
            
    //         if ($permissions->count() > 0) {
    //             $groupedPermissions[$group->group_display_name] = $permissions;
    //         }
    //     }
    
    //     return view('roles_and_permissions.add-roles', compact(
    //         'roles', 
    //         'departments', 
    //         'groupedPermissions', 
    //         'title'
    //     ));
    // }
    
    
        public function addRole()
        {
            $title = 'Peranan';
            
            $users = User::with('role')->get();
                 
            $roles = Role::with('department')->get()->map(function($role) use ($users) {
                $roleUsers = $users->where('role_id', $role->uuid);
                $role->users = $roleUsers;
                return $role;
            })->filter(fn($role) => !empty($role->users) && $role->users->count() > 0);
                 
            $departments = Department::where('status', 1)->get();
            $permissionGroups = DB::table('permission_group')->where('group_status', 1)->get();
                 
            $groupedPermissions = [];
            foreach ($permissionGroups as $group) {
                $permissions = Permission::where('permission_group', $group->id)
                    ->where('status', 1)
                    ->get();
                             
                if ($permissions->count() > 0) {
                    $groupedPermissions[$group->group_display_name] = $permissions;
                }
            }
                 
            return view('roles_and_permissions.add-roles', compact(
                'roles', 
                'departments', 
                'groupedPermissions', 
                'title'
            ));
        }
     



        public function storeRole(Request $request) {
            $request->validate([
                'name' => 'required|unique:roles,name',
                'display_name' => 'required',
                'description' => 'nullable|string',
                'department_id' => 'required'
            ]);
            
            try {
                $role = new Role();
                $role->name = $request->name;
                $role->display_name = $request->display_name;
                $role->description = $request->description;
                $role->department_id = $request->department_id;
                
                $role->save();
                
                // Handle permissions - similar to updateStoreRole function
                $permissions = [];
                if ($request->has('permissions')) {
                    $permissions = array_filter($request->permissions);
                }
                
                foreach ($permissions as $permissionUuid) {
                    DB::table('permission_roles')->insert([
                        'role_uuid' => $role->uuid,
                        'permission_uuid' => $permissionUuid
                    ]);
                }
                
                return response()->json(['success' => true, 'message' => __('app.role_added_successfully')]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

public function updateStoreRole(Request $request)
{
     $role = Role::where('uuid', $request->id)->firstOrFail();
    
     $role->update([
         'name' => $request->name,
         'display_name' => $request->display_name,
         'description' => $request->description,
         'department_id' => $request->department_id,
     ]);
     
     $permissions = [];
     if ($request->has('permissions')) {
         $permissions = array_filter($request->permissions);
     }
     $role->permissions()->detach();
     
     foreach ($permissions as $permissionUuid) {
         DB::table('permission_roles')->insert([
             'role_uuid' => $role->uuid,
             'permission_uuid' => $permissionUuid
         ]);
     }
     
     return response()->json([
         'success' => true,
         'message' => 'Role updated successfully',
     ]);
}


    //  public function staff( ){
    //      $title = __('app.staff');
    //      return view('roles_and_permissions.staff',compact('title'));
    //  }


    public function getRolePermissions($id)
    {
        $permissions = DB::table('permission_roles')
            ->where('role_uuid', $id)
            ->pluck('permission_uuid')
            ->toArray();
        
        return response()->json([
            'success' => true,
            'permissions' => $permissions
        ]);
    }


    public function updateGroupStatus(Request $request)
    {
        try {
            $groupId = $request->input('group_id');
            $status = $request->input('status');
            
            // Validate inputs
            if (!$groupId || !is_numeric($groupId)) {
                return response()->json(['success' => false, 'message' => 'Invalid group ID']);
            }
            
            // Update the permission group status
            DB::table('permission_group')
                ->where('id', $groupId)
                ->update(['group_status' => $status]);
            
            // You could also use Eloquent if you have a model for permission groups
            // PermissionGroup::where('id', $groupId)->update(['group_status' => $status]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Permission group status updated successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to update permission group status: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Failed to update status: ' . $e->getMessage()
            ]);
        }
    }

    public function storeStaff(Request $request) 
    {
        \Log::info('=== Staff Creation Started ===');
        \Log::info('Request data:', $request->all());
        
        // Check database connection
        try {
            \DB::connection()->getPdo();
            \Log::info('Database connection: OK');
        } catch (\Exception $e) {
            \Log::error('Database connection failed:', $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Database connection failed'], 500);
        }
        
        // Pre-validation checks
        $roleExists = \DB::table('roles')->where('uuid', $request->role_id)->exists();
        $emailExists = \DB::table('users')->where('email', $request->email)->exists();
        
        \Log::info('Pre-validation checks:', [
            'role_exists' => $roleExists,
            'email_exists' => $emailExists,
            'has_password_confirmation' => $request->has('password_confirmation')
        ]);
        
        // Validation with detailed error handling
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role_id' => 'required|exists:roles,uuid',
                'password' => 'required|string|min:8|confirmed',
                'status' => 'required|in:active,inactive',
            ]);
            
            \Log::info('Validation passed. Validated data:', $validatedData);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
        
        try {
            \Log::info('Finding role with UUID: ' . $validatedData['role_id']);
            
            // More detailed role query with debugging
            $role = Role::where('uuid', $validatedData['role_id'])->first();
            
            if (!$role) {
                \Log::error('Role not found with UUID: ' . $validatedData['role_id']);
                
                // Additional debugging - check what roles exist
                $allRoles = Role::select('uuid', 'name')->get();
                \Log::info('All available roles:', $allRoles->toArray());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Specified role not found',
                ], 404);
            }
            
            // Log the complete role object to debug
            \Log::info('Role found - Full object:', $role->toArray());
            \Log::info('Role details:', [
                'role_uuid' => $role->uuid,
                'role_name' => $role->name ?? 'N/A'
            ]);
            
            // Double-check that role->uuid is not null
            if ($role->uuid === null) {
                \Log::error('Role UUID is null even though role was found!');
                return response()->json([
                    'success' => false,
                    'message' => 'Role UUID is invalid',
                ], 500);
            }
            
            \Log::info('Creating user with role_id: ' . $role->uuid);
            $staff = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'username' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'status' => $validatedData['status'] === 'active' ? 1 : 0,
                'role_id' => $role->uuid, // Use uuid instead of id
                'uuid' => \Illuminate\Support\Str::uuid(),
            ]);
            
            \Log::info('Staff created successfully:', [
                'id' => $staff->id,
                'email' => $staff->email,
                'uuid' => $staff->uuid,
                'role_id' => $staff->role_id
            ]);
            
            \Log::info('=== Staff Creation Completed Successfully ===');
            
            return response()->json([
                'success' => true,
                'message' => 'Staff member created successfully',
                'data' => $staff
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error creating staff: ' . $e->getMessage());
            \Log::error('Stack trace:', $e->getTrace());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create staff member',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    // public function updateStaff(Request $request, $uuid)
    // {
    //     \Log::info('=== Staff Update Started ===');
    //     \Log::info('Staff UUID: ' . $uuid);
    //     \Log::info('Request data:', $request->all());
        
    //     // Check database connection
    //     try {
    //         \DB::connection()->getPdo();
    //         \Log::info('Database connection: OK');
    //     } catch (\Exception $e) {
    //         \Log::error('Database connection failed:', $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Database connection failed'], 500);
    //     }
        
    //     try {
    //         // Find the staff member to update
    //         \Log::info('Finding staff member with UUID: ' . $uuid);
    //         $staff = User::where('uuid', $uuid)->first();
            
    //         if (!$staff) {
    //             \Log::error('Staff member not found with UUID: ' . $uuid);
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Staff member not found',
    //             ], 404);
    //         }
            
    //         \Log::info('Staff member found:', [
    //             'id' => $staff->id,
    //             'email' => $staff->email,
    //             'current_role_id' => $staff->role_id,
    //             'current_username' => $staff->username,
    //             'current_status' => $staff->status
    //         ]);
            
    //         // Validation with detailed error handling
    //         try {
    //             $validationRules = [
    //                 'first_name' => 'sometimes|required|string|max:255',
    //                 'last_name' => 'sometimes|required|string|max:255',
    //                 'email' => 'sometimes|required|email|unique:users,email,' . $staff->uuid . ',uuid',
    //                 'role_id' => 'sometimes|required|exists:roles,uuid',
    //                 'status' => 'sometimes|required|in:active,inactive',
    //             ];
                
    //             // Only validate password if it's being updated
    //             if ($request->has('password')) {
    //                 $validationRules['password'] = 'string|min:8|confirmed';
    //             }
                
    //             $validatedData = $request->validate($validationRules);
                
    //             \Log::info('Validation passed. Validated data:', $validatedData);
                
    //         } catch (\Illuminate\Validation\ValidationException $e) {
    //             \Log::error('Validation failed:', $e->errors());
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Validation failed',
    //                 'errors' => $e->errors()
    //             ], 422);
    //         }
            
    //         // Handle role update if provided
    //         $roleUuid = null;
    //         if (isset($validatedData['role_id'])) {
    //             \Log::info('Finding role with UUID: ' . $validatedData['role_id']);
    //             $role = Role::where('uuid', $validatedData['role_id'])->first();
                
    //             if (!$role) {
    //                 \Log::error('Role not found with UUID: ' . $validatedData['role_id']);
                    
    //                 // Additional debugging - check what roles exist
    //                 $allRoles = Role::select('uuid', 'name')->get();
    //                 \Log::info('All available roles:', $allRoles->toArray());
                    
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Specified role not found',
    //                 ], 404);
    //             }
                
    //             \Log::info('Role found - Full object:', $role->toArray());
    //             $roleUuid = $role->uuid;
    //         }
            
    //         // Prepare update data
    //         $updateData = [];
            
    //         // Handle username creation from first_name and last_name
    //         if (isset($validatedData['first_name']) || isset($validatedData['last_name'])) {
    //             // Get current username parts if first_name or last_name not provided
    //             $currentUsernameParts = explode(' ', $staff->username, 2);
    //             $currentFirstName = $currentUsernameParts[0] ?? '';
    //             $currentLastName = $currentUsernameParts[1] ?? '';
                
    //             $firstName = $validatedData['first_name'] ?? $currentFirstName;
    //             $lastName = $validatedData['last_name'] ?? $currentLastName;
                
    //             // Create username from first_name and last_name
    //             $updateData['username'] = trim($firstName . ' ' . $lastName);
                
    //             \Log::info('Username update:', [
    //                 'current_username' => $staff->username,
    //                 'new_first_name' => $firstName,
    //                 'new_last_name' => $lastName,
    //                 'new_username' => $updateData['username']
    //             ]);
    //         }
            
    //         if (isset($validatedData['email'])) {
    //             $updateData['email'] = $validatedData['email'];
    //         }
            
    //         if (isset($validatedData['password'])) {
    //             $updateData['password'] = bcrypt($validatedData['password']);
    //         }
            
    //         if (isset($validatedData['status'])) {
    //             $statusValue = $validatedData['status'] === 'active' ? 1 : 0;
    //             $updateData['status'] = $statusValue;
                
    //             \Log::info('Status conversion:', [
    //                 'original_status' => $validatedData['status'],
    //                 'converted_status' => $statusValue
    //             ]);
    //         }
            
    //         if ($roleUuid) {
    //             $updateData['role_id'] = $roleUuid;
    //         }
            
    //         \Log::info('Final update data:', $updateData);
            
    //         // Update the staff member
    //         \Log::info('Updating staff member...');
    //         $updated = $staff->update($updateData);
            
    //         \Log::info('Update result:', ['updated' => $updated]);
            
    //         // Refresh the model to get updated data
    //         $staff->refresh();
            
    //         \Log::info('Staff updated successfully:', [
    //             'id' => $staff->id,
    //             'email' => $staff->email,
    //             'uuid' => $staff->uuid,
    //             'username' => $staff->username,
    //             'role_id' => $staff->role_id,
    //             'status' => $staff->status
    //         ]);
            
    //         \Log::info('=== Staff Update Completed Successfully ===');
            
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Staff member updated successfully',
    //             'data' => $staff
    //         ]);
            
    //     } catch (\Exception $e) {
    //         \Log::error('Error updating staff: ' . $e->getMessage());
    //         \Log::error('Stack trace:', $e->getTrace());
            
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to update staff member',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    
    // public function updateStaff(Request $request, $uuid)
    // {
        
    //     // Check database connection
    //     try {
    //         \DB::connection()->getPdo();
    //         \Log::info('Database connection: OK');
    //     } catch (\Exception $e) {
    //         \Log::error('Database connection failed:', $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Database connection failed'], 500);
    //     }
        
    //     try {
    //         // Find the staff member to update
    //         $staff = User::where('uuid', $uuid)->first();
            
    //         if (!$staff) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Staff member not found',
    //             ], 404);
    //         }
            
    //         // Validation with detailed error handling
    //         try {
    //             $validationRules = [
    //                 'first_name' => 'sometimes|required|string|max:255',
    //                 'last_name' => 'sometimes|required|string|max:255',
    //                 'email' => 'sometimes|required|email|unique:users,email,' . $staff->uuid . ',uuid',
    //                 'role_id' => 'sometimes|required|exists:roles,uuid',
    //                 'status' => 'sometimes|required|in:active,inactive,blocked,unblocked', // Added blocked/unblocked
    //             ];
                
    //             // Only validate password if it's being updated
    //             if ($request->has('password')) {
    //                 $validationRules['password'] = 'string|min:8|confirmed';
    //             }
                
    //             $validatedData = $request->validate($validationRules);
                
    //         } catch (\Illuminate\Validation\ValidationException $e) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Validation failed',
    //                 'errors' => $e->errors()
    //             ], 422);
    //         }
            
    //         // Handle role update if provided
    //         $roleUuid = null;
    //         if (isset($validatedData['role_id'])) {
    //             $role = Role::where('uuid', $validatedData['role_id'])->first();
                
    //             if (!$role) {
                    
    //                 // Additional debugging - check what roles exist
    //                 $allRoles = Role::select('uuid', 'name')->get();
                    
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Specified role not found',
    //                 ], 404);
    //             }
    //             $roleUuid = $role->uuid;
    //         }
            
    //         // Prepare update data
    //         $updateData = [];
            
    //         // Handle username creation from first_name and last_name
    //         if (isset($validatedData['first_name']) || isset($validatedData['last_name'])) {
    //             // Get current username parts if first_name or last_name not provided
    //             $currentUsernameParts = explode(' ', $staff->username, 2);
    //             $currentFirstName = $currentUsernameParts[0] ?? '';
    //             $currentLastName = $currentUsernameParts[1] ?? '';
                
    //             $firstName = $validatedData['first_name'] ?? $currentFirstName;
    //             $lastName = $validatedData['last_name'] ?? $currentLastName;
                
    //             // Create username from first_name and last_name
    //             $updateData['username'] = trim($firstName . ' ' . $lastName);
    //         }
            
    //         if (isset($validatedData['email'])) {
    //             $updateData['email'] = $validatedData['email'];
    //         }
            
    //         if (isset($validatedData['password'])) {
    //             $updateData['password'] = bcrypt($validatedData['password']);
    //         }
            
    //         // Handle status - including blocked/unblocked
    //       // In your updateStaff function, modify the status handling:
    //         if (isset($validatedData['status'])) {
    //             $status = $validatedData['status'];
                
    //             if (in_array($status, ['blocked', 'unblocked'])) {
    //                 // Handle blocked/unblocked status through password_attempts table
    //                 if ($status === 'blocked') {
    //                     DB::table('password_attempts')->updateOrInsert(
    //                         ['admin_id' => $uuid],
    //                         [
    //                             'is_admin_locked' => 1,
    //                             'created_at' => now(),
    //                             'updated_at' => now()
    //                         ]
    //                     );
    //                     // Also set user status to inactive when blocking
    //                     $updateData['status'] = 0;
                        
    //                 } elseif ($status === 'unblocked') {
    //                     // Remove password_attempts record to unblock user
    //                     $deleted = DB::table('password_attempts')->where('admin_id', $uuid)->delete();
    //                     // Also set user status to active when unblocking
    //                     $updateData['status'] = 1;
    //                 }
                    
    //             } else {
    //                 // Handle regular active/inactive status
    //                 $statusValue = $status === 'active' ? 1 : 0;
    //                 $updateData['status'] = $statusValue;
                    
    //                 // Also manage password_attempts for consistency
    //                 if ($status === 'inactive') {
    //                     // Optionally add to password_attempts when deactivating
    //                     DB::table('password_attempts')->updateOrInsert(
    //                         ['admin_id' => $uuid],
    //                         ['is_admin_locked' => 1, 'updated_at' => now()]
    //                     );
    //                 } elseif ($status === 'active') {
    //                     // Remove any admin locks when activating
    //                     DB::table('password_attempts')->where('admin_id', $uuid)->delete();
    //                 }
    //             }
    //         }
            
    //         if ($roleUuid) {
    //             $updateData['role_id'] = $roleUuid;
    //         }
            
    //         // Update the staff member (only if there's data to update)
    //         if (!empty($updateData)) {
    //             $updated = $staff->update($updateData);
                
    //             // Refresh the model to get updated data
    //             $staff->refresh();
    //         }
            
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Staff member updated successfully',
    //             'data' => $staff
    //         ]);
            
    //     } catch (\Exception $e) {
            
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to update staff member',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    
    public function updateStaff(Request $request, $uuid)
    {
        // Check database connection
        try {
            \DB::connection()->getPdo();
            \Log::info('Database connection: OK');
        } catch (\Exception $e) {
            \Log::error('Database connection failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Database connection failed'], 500);
        }
    
        try {
            // Find the staff member to update
            $staff = User::where('uuid', $uuid)->first();
    
            if (!$staff) {
                return response()->json([
                    'success' => false,
                    'message' => 'Staff member not found',
                ], 404);
            }
    
            // Validation rules
            try {
                $validationRules = [
                    'first_name' => 'sometimes|required|string|max:255',
                    'last_name'  => 'sometimes|required|string|max:255',
                    'email'      => 'sometimes|required|email|unique:users,email,' . $staff->uuid . ',uuid',
                    'role_id'    => 'sometimes|required|exists:roles,uuid',
                    'status'     => 'sometimes|required|in:active,inactive,blocked,unblocked',
                ];
    
                if ($request->has('password')) {
                    $validationRules['password'] = 'string|min:8|confirmed';
                }
    
                $validatedData = $request->validate($validationRules);
    
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $e->errors()
                ], 422);
            }
    
            // Handle role update
            $roleUuid = null;
            if (isset($validatedData['role_id'])) {
                $role = Role::where('uuid', $validatedData['role_id'])->first();
    
                if (!$role) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Specified role not found',
                    ], 404);
                }
                $roleUuid = $role->uuid;
            }
    
            // Prepare update data
            $updateData = [];
    
            // Handle username update
            if (isset($validatedData['first_name']) || isset($validatedData['last_name'])) {
                $currentUsernameParts = explode(' ', $staff->username, 2);
                $currentFirstName = $currentUsernameParts[0] ?? '';
                $currentLastName  = $currentUsernameParts[1] ?? '';
    
                $firstName = $validatedData['first_name'] ?? $currentFirstName;
                $lastName  = $validatedData['last_name'] ?? $currentLastName;
    
                $updateData['username'] = trim($firstName . ' ' . $lastName);
            }
    
            if (isset($validatedData['email'])) {
                $updateData['email'] = $validatedData['email'];
            }
    
            if (isset($validatedData['password'])) {
                $updateData['password'] = bcrypt($validatedData['password']);
            }
    
            /**
             * 🔑 Fixed status handling
             * - blocked: set lock + inactive
             * - unblocked: remove lock + reset failed attempts + active
             * - inactive: inactive + keep lock
             * - active: active + remove lock + reset failed attempts
             */
            if (isset($validatedData['status'])) {
                $status = $validatedData['status'];
    
                if ($status === 'blocked') {
                    DB::table('password_attempts')->updateOrInsert(
                        ['admin_id' => $uuid],
                        [
                            'is_admin_locked' => 1,
                            'locked_until'    => now()->addMinutes(30),
                            'created_at'      => now(),
                            'updated_at'      => now()
                        ]
                    );
                    $updateData['status'] = 0; // inactive when blocked
    
                } elseif ($status === 'unblocked') {
                   // Clear all failed attempts when unblocking
                    DB::table('password_attempts')->where('admin_id', $uuid)->delete();
                    $updateData['status'] = 1; // active
                    
                    // Generate password reset token
                    $token = Str::random(60);
                    
                    // Store reset token in password_resets table
                    DB::table('password_resets')->updateOrInsert(
                        ['email' => $staff->email],
                        [
                            'token' => Hash::make($token),
                            'created_at' => now()
                        ]
                    );
                    
                    // Send email with reset link using your existing route
                    try {
                        $resetUrl = route('admin.password.reset', $token) . '?email=' . urlencode($staff->email);
                        
                        // Add this right before sending the email for debugging
                        \Log::info('User data for email:', [
                            'username' => $staff->username ?? 'NULL',
                            'first_name' => $staff->first_name ?? 'NULL', 
                            'name' => $staff->name ?? 'NULL',
                            'email' => $staff->email
                        ]);
                        \Log::info('Reset URL: ' . $resetUrl);
                        
                        Mail::send('emails.account_unblocked', [
                            'user' => $staff,
                            'resetUrl' => $resetUrl
                        ], function ($message) use ($staff) {
                            $message->to($staff->email)
                                   ->subject('Your Account Has Been Unblocked - Set New Password');
                        });
                        
                        \Log::info("Unblock notification sent to: " . $staff->email);
                        \Log::info("Reset URL generated: " . $resetUrl);  // Add this for debugging
                        
                    } catch (\Exception $e) {
                        \Log::error("Failed to send unblock email: " . $e->getMessage());
                        // Still proceed with unblock even if email fails
                    }
    
                } elseif ($status === 'inactive') {
                    $updateData['status'] = 0;
                    DB::table('password_attempts')->updateOrInsert(
                        ['admin_id' => $uuid],
                        ['is_admin_locked' => 1, 'updated_at' => now()]
                    );
    
                } elseif ($status === 'active') {
                    $updateData['status'] = 1;
                    // ✅ Fix: reset failed attempts when re-activating
                    DB::table('password_attempts')->where('admin_id', $uuid)->delete();
                }
            }
    
            if ($roleUuid) {
                $updateData['role_id'] = $roleUuid;
            }
    
            // Update staff
            if (!empty($updateData)) {
                $staff->update($updateData);
                $staff->refresh();
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Staff member updated successfully',
                'data'    => $staff
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update staff member',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    

}

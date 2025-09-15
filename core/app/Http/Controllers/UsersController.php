<?php namespace App\Http\Controllers;

use App\Datatables\UserDatatable;
use App\Http\Forms\UserForm;
use App\Http\Requests\UserFormRequest;
use App\Invoicer\Repositories\Contracts\RoleInterface;
use App\Invoicer\Repositories\Contracts\UserInterface;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;

class UsersController extends CrudController {
    protected $roleRepository;
    protected $datatable = UserDatatable::class;
    protected string $formClass = UserForm::class;
    protected $formRequest = UserFormRequest::class;
    protected string $heading =  'app.users';
    protected string $icon = 'user';
    protected string $btnCreateText = 'app.add_user';
    protected string $iconCreate = 'user';
    protected array $routes = [
        'index'     => 'users.index',
        'create'    => 'users.create',
        'show'      => 'users.show',
        'edit'      => 'users.edit',
        'store'     => 'users.store',
        'destroy'   => 'users.destroy',
        'update'    => 'users.update'
    ];
    protected array $jsFiles = [
        'assets/plugins/togglepassword/togglepassword.js'
    ];
    public function __construct(User $model, UserInterface $userInterface, RoleInterface $roleInterface){
        parent::__construct();
        $this->entityClass = $model;
        $this->repository = $userInterface;
        $this->roleRepository = $roleInterface;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('user.create'));
            return $next($request);
        });
    }
    public function beforeCreate($request): void
    {
        $this->heading = 'app.add_user';
    }
    public function beforeEdit(&$entity): void
    {
        $entity->password = null;
        $this->heading = 'app.edit_user';
    }
    public function beforeUpdate($request, &$entity, &$input): void
    {
        if(empty($request->password)){
            unset($input['password']);
        }
    }
    public function afterStore($request, &$entity): void
    {
        if ($request->hasFile('user_photo')){
            $file = $request->file('user_photo');
            $path = config('app.images_path').'uploads/user_photos/';
            $filename = uploadFile($file,$path, true, 245);
            $entity->photo = $filename;
            $entity->save();
        }
    }
    public function afterUpdate($request, &$entity): void
    {
        $this->afterStore($request, $entity);
    }

    // public function staff()
    // {
    //     $title = __('app.staff');
    //     $canAdminStaffEditStaff = auth('admin')->user()->hasPermission('staff.edit');
    //     $canAdminStaffAddStaff = auth('admin')->user()->hasPermission('staff.add');
    //     $roles = Role::all();
    //     $roleIds = Role::pluck('uuid'); 
    //     $staffUsers = User::with(['staffRole', 'staffRole.department'])
    //     ->whereNotNull('role_id') 
    //     ->latest()
    //     ->get();
    //     return view('roles_and_permissions.staff', compact('title', 'staffUsers' , 'roles', 'canAdminStaffEditStaff', 'canAdminStaffAddStaff'));
    // }
    
    public function staff()
    {
        $title = __('app.staff');
        $canAdminStaffEditStaff = auth('admin')->user()->hasPermission('staff.edit');
        $canAdminStaffAddStaff = auth('admin')->user()->hasPermission('staff.add');
        $roles = Role::all();
        $roleIds = Role::pluck('uuid'); 
        
       
        $staffUsers = DB::table('users')
            ->leftJoin(DB::raw('(
                SELECT admin_id, is_admin_locked, created_at 
                FROM password_attempts pa1
                WHERE created_at = (
                    SELECT MAX(created_at) 
                    FROM password_attempts pa2 
                    WHERE pa2.admin_id = pa1.admin_id
                )
            ) as password_attempts'), 'users.uuid', '=', 'password_attempts.admin_id')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.uuid')
            ->select(
                'users.*',
                'roles.display_name as role_name', 
                'roles.uuid as role_uuid',
                'password_attempts.is_admin_locked as is_blocked'
            )
            ->whereNotNull('users.role_id')
            ->orderBy('users.created_at', 'desc')
            ->get()
            ->map(function($user) {
                $user->is_blocked = !empty($user->is_blocked) && $user->is_blocked == 1;
                return $user;
            })
            ->groupBy('uuid')
            ->map(function($group) {
                // If any record shows blocked, use that one, otherwise use the first
                $blockedUser = $group->firstWhere('is_blocked', true);
                return $blockedUser ?: $group->first();
            })
            ->values();
        
        return view('roles_and_permissions.staff', compact(
            'title', 
            'staffUsers', 
            'roles', 
            'canAdminStaffEditStaff', 
            'canAdminStaffAddStaff'
        ));
    }

}

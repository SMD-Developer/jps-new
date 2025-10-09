<?php namespace App\Http\Controllers;

use App\Http\Forms\ProfileForm;
use App\Http\Requests\ProfileFormRequest;
use App\Invoicer\Repositories\Contracts\ProfileInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Laracasts\Flash\Flash;

class ProfileController extends CrudController {
    protected string $formClass = ProfileForm::class;
    protected $formRequest = ProfileFormRequest::class;
    protected string $heading =  'app.users';
    protected string $icon = 'user';
    protected array $routes = [
        'index' => 'users.profile.index',
        'update' => 'users.profile.store'
    ];
    public function __construct(ProfileInterface $profileInterface){
        parent::__construct();
        $this->repository = $profileInterface;
        $this->entityClass = User::class;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', false);
            return $next($request);
        });
    }
    public function index(): mixed
    {
        if (auth()->guard('admin')->user()){
            $user = $this->repository->getById(auth()->guard('admin')->user()->uuid);
            unset($user->password);
            $form = $this->form($this->formClass, [
                'method' => 'POST',
                'url' => route($this->routes['update']),
                'class' => 'needs-validation row ajax-submit',
                'novalidate',
                'model'=> $user
            ]);
            $heading = trans('app.edit_profile');
            return view('crud.form', compact('heading','form'));
        }
        return redirect('profile');
    }
    public function beforeStore($request, &$input): void
    {
        if($request->get('password') !== ''){
            $input['password']= Hash::make($request->password);
        }
    }
    
    public function afterStore($request, &$entity): void
    {
        if ($request->hasFile('photo')){
            $oldPhoto = $entity->photo;
            $file = $request->file('photo');
            $path = config('app.images_path').'uploads/user_photos/';
            $filename = uploadFile($file,$path, true, 200);
            $entity->photo = $filename;
            $entity->save();
            if(file_exists($oldPhoto)){
                File::delete($entity->photo);
            }
        }
    }

    public function store(Request $request)
    {
        $loggedUser = auth()->guard('admin')->user();
        
        if ($loggedUser) {
            $user = $this->repository->getById($loggedUser->uuid);
            
            // ✅ Validate the request
            $validated = $request->validate([
                'photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
                'username' => 'nullable|string|unique:users,username,' . $user->uuid . ',uuid',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->uuid . ',uuid',
                'phone' => 'nullable|string|max:20'
            ]);
            
            // ✅ Prepare data for update
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ];
            
            // Add username only if provided
            if ($request->filled('username')) {
                $data['username'] = $request->username;
            }
            
            // ✅ Handle photo upload with your path configuration
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = strtolower(Str::random(50) . '.' . $file->getClientOriginalExtension());
                $file->move(config('app.uploads_path') . 'admin_images', $filename);

                // Delete old photo if exists
                if ($user->photo) {
                    File::delete(config('app.uploads_path') . 'admin_images/' . $user->photo);
                }

                $data['photo'] = $filename;
            }
            
            // ✅ Update user
            $entity = $this->repository->updateById($user->uuid, $data);
            $this->afterStore($request, $entity);
            
            flash()->success(trans('app.record_updated'));
            
            if (request()->ajax()) {
                return response()->json([
                    'type' => 'success',
                    'message' => trans('app.record_updated'),
                    'action' => 'reload'
                ]);
            }
            
            return redirect('profile');
        }
        
        return redirect()->back()->with('error', 'User not authenticated');
    }



}

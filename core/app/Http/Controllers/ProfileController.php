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
use Illuminate\Support\Facades\Validator;
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
                'class' => 'needs-validation row', 
                'model'=> $user
            ]);
            $heading = trans('app.edit_profile');
            return view('crud.form', compact('heading','form'));
        }
        return redirect('profile');
    }


    public function beforeStore($request, &$input): void
    {
    
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
            
            // ✅ Fixed: Delete old photo, not new one
            if($oldPhoto && file_exists(public_path($oldPhoto))){
                File::delete(public_path($oldPhoto));
            }
        }
    }

    public function store(Request $request)
    {
        $loggedUser = auth()->guard('admin')->user();
        
        if (!$loggedUser) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'User not authenticated',
                    'errors' => []
                ], 401);
            }
            return redirect()->back()->with('error', 'User not authenticated');
        }
        
        $user = $this->repository->getById($loggedUser->uuid);
        

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->uuid . ',uuid',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Sila isikan medan yang diperlukan',
            'email.required' => 'Sila isikan medan yang diperlukan',
            'phone.required' => 'Sila isikan medan yang diperlukan',
            'address.required' => 'Sila isikan medan yang diperlukan',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already taken',
            'photo.mimes' => 'Photo must be a file of type: jpeg, png, jpg, gif',
            'photo.max' => 'Photo size must not exceed 2MB',
        ]);
        
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Validation failed. Please check the form.',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update user
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
        
        $entity = $this->repository->updateById($user->uuid, $data);
        $this->afterStore($request, $entity);
        
        // ✅ Return JSON for AJAX success
        if ($request->ajax()) {
            return response()->json([
                'message' => trans('app.record_updated'),
                'type' => 'success'
            ], 200);
        }
        
        return redirect()->back()->with('success', trans('app.record_updated'));
    }



}

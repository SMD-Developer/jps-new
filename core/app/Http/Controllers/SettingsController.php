<?php namespace App\Http\Controllers;

use App\Http\Forms\SettingForm;
use App\Http\Requests\SettingsFormRequest;
use App\Invoicer\Repositories\Contracts\SettingInterface;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class SettingsController extends CrudController {
    protected $formClass = SettingForm::class;
    protected string $heading =  'app.system_settings';
    protected string $icon = 'cogs';
    protected array $routes = [
        'index' => 'settings.company.index',
        'store' => 'settings.company.store',
        'update' => 'settings.company.update'
    ];

    public function __construct(SettingInterface $settingInterface){
        parent::__construct();
        $this->entityClass = Setting::class;
        $this->repository = $settingInterface;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', false);
            return $next($request);
        });
    }

	public function index(): mixed
    {
        $setting = $this->repository->first();
        $route = $setting ? route($this->routes['update'],$setting->uuid) : route($this->routes['store']);
        $method = $setting ? 'PATCH' : 'POST';
        $form = $this->form($this->formClass, [
            'method' => $method,
            'url' => $route,
            'class' => 'needs-validation row',
            'novalidate',
            'model'=>$setting
        ]);
		return view('settings.index', compact('form'));
	}
    public function afterStore($request, &$entity)
    {
        if ($request->hasFile('logo')){
            $file = $request->file('logo');
            $path = config('app.images_path').'uploads/settings/';
            $filename = uploadFile($file,$path, true, 245);
            $entity->logo = $filename;
        }
        if ($request->hasFile('favicon')){
            $file = $request->file('favicon');
            $path = config('app.images_path').'uploads/settings/';
            $filename = uploadFile($file,$path, true, 16);
            $entity->favicon = $filename;
        }
        if ($request->hasFile('login_bg')){
            $file = $request->file('login_bg');
            $path = config('app.images_path').'uploads/settings/';
            $filename = uploadFile($file,$path);
            $entity->login_bg = $filename;
        }
        $entity->save();
        saveConfiguration(['APP_NAME'=>$request->name,'APP_URL'=>url('/')]);
    }
    public function afterUpdate($request, &$entity): void
    {
        $this->afterStore($request, $entity);
    }


    public function logoPage()
    {
        $setting = $this->repository->first();
        return view('settings.logo', compact('setting'));
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:1024',
            'login_bg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $setting = $this->repository->first();
        
        if (!$setting) {
            $setting = new Setting();
        }

        $path = config('app.images_path').'uploads/settings/';
        
        // Create directory if it doesn't exist
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        if ($request->hasFile('logo') && $request->file('logo')->isValid()){
            // Delete old logo if exists
            if ($setting->logo && file_exists($path . $setting->logo)) {
                unlink($path . $setting->logo);
            }
            $file = $request->file('logo');
            $filename = uploadFile($file, $path, true, 245);
            $setting->logo = $filename;
        }

        if ($request->hasFile('favicon') && $request->file('favicon')->isValid()){
            // Delete old favicon if exists
            if ($setting->favicon && file_exists($path . $setting->favicon)) {
                unlink($path . $setting->favicon);
            }
            $file = $request->file('favicon');
            $filename = uploadFile($file, $path, true, 16);
            $setting->favicon = $filename;
        }

        if ($request->hasFile('login_bg') && $request->file('login_bg')->isValid()){
            // Delete old login_bg if exists
            if ($setting->login_bg && file_exists($path . $setting->login_bg)) {
                unlink($path . $setting->login_bg);
            }
            $file = $request->file('login_bg');
            $filename = uploadFile($file, $path);
            $setting->login_bg = $filename;
        }

        $setting->save();

        return redirect()->back()->with('success', 'Images updated successfully!');
    }
}

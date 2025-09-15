<?php namespace App\Http\Controllers;

use App\Http\Forms\SettingForm;
use App\Http\Requests\SettingsFormRequest;
use App\Invoicer\Repositories\Contracts\SettingInterface;
use App\Models\Setting;
use Illuminate\Support\Str;
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
}

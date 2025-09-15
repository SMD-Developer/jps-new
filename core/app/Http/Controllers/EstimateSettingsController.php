<?php namespace App\Http\Controllers;

use App\Http\Forms\EstimateSettingForm;
use App\Http\Requests\EstimateSettingsFormRequest;
use App\Invoicer\Repositories\Contracts\EstimateSettingInterface;
use App\Models\EstimateSetting;

class EstimateSettingsController extends CrudController {
    protected string $formClass = EstimateSettingForm::class;
    protected $formRequest = EstimateSettingsFormRequest::class;
    protected string $heading =  'app.estimate_settings';
    protected string $icon = 'file-pdf-o';
    protected bool $showBtnCreate = false;
    protected bool $settingsMode = true;
    protected array $routes = [
        'index' => 'settings.estimate.index',
        'store' => 'settings.estimate.store',
        'update' => 'settings.estimate.update'
    ];
    public function __construct(EstimateSettingInterface $estimateSettingInterface){
        parent::__construct();
        $this->repository = $estimateSettingInterface;
        $this->entityClass = EstimateSetting::class;
    }
    public function index(): mixed
    {
        $estimateSetting = $this->repository->first();
        $route = $estimateSetting ? route($this->routes['update'],$estimateSetting->uuid) : route($this->routes['store']);
        $method = $estimateSetting ? 'PATCH' : 'POST';
        $form = $this->form($this->formClass, [
            'method' => $method,
            'url' => $route,
            'class' => 'needs-validation',
            'novalidate',
            'model'=>$estimateSetting
        ]);
        return view('settings.index', compact('form'));
    }

    public function afterStore($request, &$entity): void
    {
        if ($request->hasFile('logo')){
            $file = $request->file('logo');
            $path = config('app.images_path').'uploads/settings/';
            $filename = uploadFile($file,$path, true, 245);
            $entity->logo = $filename;
            $entity->save();
        }
    }

    public function afterUpdate($request, &$entity): void
    {
        $this->afterStore($request, $entity);
    }
}

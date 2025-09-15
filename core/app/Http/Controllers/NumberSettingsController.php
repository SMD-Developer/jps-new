<?php namespace App\Http\Controllers;

use App\Http\Forms\NumberSettingForm;
use App\Http\Requests\NumberSettingFrmRequest;
use App\Invoicer\Repositories\Contracts\NumberSettingInterface;
use App\Models\NumberSetting;

class NumberSettingsController extends CrudController {
    protected string $formClass = NumberSettingForm::class;
    protected $formRequest = NumberSettingFrmRequest::class;
    protected string $heading =  'app.invoice_settings';
    protected string $icon = 'file-pdf-o';
    protected bool $showBtnCreate = false;
    protected bool $settingsMode = true;
    public function __construct(NumberSettingInterface $numberSettingInterface){
        parent::__construct();
        $this->repository = $numberSettingInterface;
        $this->entityClass = NumberSetting::class;
    }
    protected array $routes = [
        'index' => 'settings.number.index',
        'store' => 'settings.number.store',
        'update' => 'settings.number.update'
    ];
    public function index(): mixed
    {
        $numberSetting = $this->repository->first();
        $route = $numberSetting ? route($this->routes['update'],$numberSetting->uuid) : route($this->routes['store']);
        $method = $numberSetting ? 'PATCH' : 'POST';
        $form = $this->form($this->formClass, [
            'method' => $method,
            'url' => $route,
            'class' => 'needs-validation',
            'novalidate',
            'model'=>$numberSetting
        ]);
        return view('settings.index', compact('form'));
    }
}

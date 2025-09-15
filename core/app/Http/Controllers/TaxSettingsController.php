<?php namespace App\Http\Controllers;

use App\Datatables\TaxDatatable;
use App\Http\Forms\TaxForm;
use App\Http\Requests\TaxSettingFormRequest;
use App\Invoicer\Repositories\Contracts\TaxSettingInterface;
use App\Models\TaxSetting;
use Illuminate\Support\Facades\View;
class TaxSettingsController extends CrudController {
    protected string $formClass = TaxForm::class;
    protected $datatable = TaxDatatable::class;
    protected $formRequest = TaxSettingFormRequest::class;
    protected string $heading =  'app.taxes';
    protected string $icon = 'th-large';
    protected string $btnCreateText = 'app.new_tax';
    protected string $iconCreate = 'plus';
    protected bool $settingsMode = true;
    protected array $routes = [
        'index' => 'settings.tax.index',
        'create' => 'settings.tax.create',
        'store' => 'settings.tax.store',
        'update' => 'settings.tax.update'
    ];
    public function __construct(TaxSettingInterface $taxSettingInterface){
        parent::__construct();
        $this->repository = $taxSettingInterface;
        $this->entityClass = TaxSetting::class;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('tax-setting.create'));
            return $next($request);
        });
    }
    public function beforeStore($request, &$input): void
    {
        if($request->selected) {
            $this->repository->resetDefault();
        }
    }
    public function beforeUpdate($request, &$entity, &$input): void
    {
        $this->beforeStore($request,$input);
    }
}

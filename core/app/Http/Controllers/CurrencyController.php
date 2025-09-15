<?php namespace App\Http\Controllers;

use App\Datatables\CurrencyDatatable;
use App\Http\Forms\CurrencyForm;
use App\Http\Requests\CurrencyFormRequest;
use App\Invoicer\Repositories\Contracts\CurrencyInterface;
use App\Models\Currency;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class CurrencyController extends CrudController {
    protected $datatable = CurrencyDatatable::class;
    protected string $formClass = CurrencyForm::class;
    protected $formRequest = CurrencyFormRequest::class;
    protected string $heading =  'app.currencies';
    protected string $icon = 'money';
    protected string $btnCreateText = 'app.new_currency';
    protected string $iconCreate = 'plus';
    protected bool $settingsMode = true;
	protected array $routes = [
        'index' => 'settings.currency.index',
        'create' => 'settings.currency.create',
        'store' => 'settings.currency.store',
        'update' => 'settings.currency.update'
    ];
    public function __construct(CurrencyInterface $currencyInterface){
        parent::__construct();
        $this->repository = $currencyInterface;
        $this->entityClass = Currency::class;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('currency.create'));
            return $next($request);
        });
    }
    public function beforeStore($request, &$input): void
    {
        if($request->default_currency){
            $this->repository->resetDefault();
            $input['active'] = 1;
        }
    }
    public function beforeEdit(&$entity): void
    {
        $this->heading = 'app.edit_currency';
    }
    public function beforeUpdate($request, &$entity, &$input): void
    {
        $this->beforeStore($request,$input);
    }
	public function save_api_key(){
	    $key = request('key');
	    if($key){
	        saveConfiguration(['OPENEXCHANGE_RATES_KEY'=>$key]);
	        return Response::json(['success'=>true,'message'=>trans('app.record_created')]);
        }
    }
}

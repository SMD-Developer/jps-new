<?php namespace App\Http\Controllers;

use App;
use App\Datatables\ClientDatatable;
use App\Http\Forms\ClientForm;
use App\Http\Requests\ClientFormRequest;
use App\Invoicer\Repositories\Contracts\ClientInterface;
use App\Invoicer\Repositories\Contracts\EstimateInterface;
use App\Invoicer\Repositories\Contracts\InvoiceInterface;
use App\Invoicer\Repositories\Contracts\NumberSettingInterface;
use App\Models\Client;
use Illuminate\Support\Facades\View;
class ClientsController extends CrudController {
    private $invoiceInterface, $estimateInterface, $numberInterface;
    protected $datatable = ClientDatatable::class;
    protected string $formClass = ClientForm::class;
    protected $formRequest = ClientFormRequest::class;
    protected string $heading =  'app.clients';
    protected string $icon = 'users';
    protected string $btnCreateText = 'app.new_client';
    protected string $iconCreate = 'user-plus';
    protected string $showDisplayMode = 'normal';
    protected array $routes = [
        'index' => 'clients.index',
        'create' => 'clients.create',
        'show' => 'clients.show',
        'edit' => 'clients.edit',
        'store' => 'clients.store',
        'destroy' => 'clients.destroy',
        'update' => 'clients.update'
    ];
    protected array $jsFiles = [
        'assets/plugins/togglepassword/togglepassword.js'
    ];
    public function __construct(
        NumberSettingInterface $numberInterface,
        ClientInterface $clientInterface,
        InvoiceInterface $invoiceInterface,
        EstimateInterface $estimateInterface
    )
    {
        parent::__construct();
        $this->numberInterface = $numberInterface;
        $this->invoiceInterface = $invoiceInterface;
        $this->estimateInterface = $estimateInterface;
        $this->repository = $clientInterface;
        $this->entityClass = Client::class;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('client.create'));
            return $next($request);
        });
    }
    public function beforeCreate($request): void
    {
        $this->heading = 'app.add_client';
        $this->modelData['client_no'] = $this->numberInterface->prefix('client_number', $this->repository->generateClientNum());
    }
    public function beforeEdit(&$entity): void
    {
        $entity->password = null;
        $this->heading = 'app.edit_client';
    }
    public function beforeUpdate($request, &$entity, &$input): void
    {
        if(empty($request->password)){
            unset($input['password']);
        }
    }
    public function afterStore($request, &$entity): void
    {
        if ($request->hasFile('client_photo')){
            $file = $request->file('client_photo');
            $path = config('app.images_path').'uploads/client_photos/';
            $filename = uploadFile($file,$path, true, 245);
            $entity->photo = $filename;
            $entity->save();
        }
    }

    public function afterUpdate($request, &$entity): void
    {
        $this->afterStore($request, $entity);
    }

    public function show($id)
    {
        $client = $this->repository->getById($id);
        if($client){
            foreach($client->invoices as $count => $invoice){
                $client->invoices[$count]['totals'] = $this->invoiceInterface->invoiceTotals($invoice->uuid);
            }
            foreach($client->estimates as $count => $estimate){
                $client->estimates[$count]['totals'] = $this->estimateInterface->estimateTotals($estimate->uuid);
            }
            return view('clients.show', compact('client'));
        }
        flash(trans('app.record_not_found'))->error();
        return redirect(route($this->routes['index']));
    }
}

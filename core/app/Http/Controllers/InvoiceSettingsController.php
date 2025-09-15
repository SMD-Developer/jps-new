<?php namespace App\Http\Controllers;

use App\Http\Forms\InvoiceSettingForm;
use App\Http\Requests\InvoiceSettingsFormRequest;
use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface;
use App\Models\InvoiceSetting;

class InvoiceSettingsController extends CrudController {
    protected string $formClass = InvoiceSettingForm::class;
    protected $formRequest = InvoiceSettingsFormRequest::class;
    protected string $heading =  'app.invoice_settings';
    protected string $icon = 'file-pdf-o';
    protected bool $showBtnCreate = false;
    protected bool $settingsMode = true;
    public function __construct(InvoiceSettingInterface $invoiceSettingInterface){
        parent::__construct();
        $this->repository = $invoiceSettingInterface;
        $this->entityClass = InvoiceSetting::class;
    }
    protected array $routes = [
        'index' => 'settings.invoice.index',
        'store' => 'settings.invoice.store',
        'update' => 'settings.invoice.update'
    ];
    public function index(): mixed
    {
        $invoiceSetting = $this->repository->first();
        //dd($invoiceSetting);
        $route = $invoiceSetting ? route($this->routes['update'],$invoiceSetting->uuid) : route($this->routes['store']);
        $method = $invoiceSetting ? 'PATCH' : 'POST';
        $form = $this->form($this->formClass, [
            'method' => $method,
            'url' => $route,
            'class' => 'needs-validation',
            'novalidate',
            'model'=>$invoiceSetting
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

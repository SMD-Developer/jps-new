<?php namespace App\Http\Controllers;

use App\Datatables\InvoiceDatatable;
use App\Http\Forms\InvoiceForm;
use App\Http\Requests\InvoiceFromRequest;
use App\Http\Requests\SendEmailFrmRequest;
use App\Invoicer\Repositories\Contracts\InvoiceInterface;
use App\Invoicer\Repositories\Contracts\InvoiceItemInterface;
use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface;
use App\Invoicer\Repositories\Contracts\NumberSettingInterface;
use App\Invoicer\Repositories\Contracts\ProductInterface;
use App\Invoicer\Repositories\Contracts\SettingInterface;
use App\Invoicer\Repositories\Contracts\TemplateInterface;
use App\Invoicer\Repositories\Contracts\SubscriptionInterface;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

class InvoicesController extends CrudController {
    protected $numberRepository;
    protected $invoiceSettingRepository;
    protected $invoiceItemRepository;
    protected $settingRepository;
    protected $templateRepository;
    protected $subscriptionRepository;
    protected $productRepository;
    protected $datatable = InvoiceDatatable::class;
    protected string $formClass = InvoiceForm::class;
    protected $formRequest = InvoiceFromRequest::class;
    protected string $heading =  'app.invoices';
    protected string $icon = 'file-pdf-o';
    protected string $btnCreateText = 'app.new_invoice';
    protected string $createDisplayMode = 'normal';
    protected string $editDisplayMode = 'normal';
    protected string $iconCreate = 'plus';
    protected string $showDisplayMode = 'normal';
    protected array $jsFiles = [
        'assets/plugins/accounting-js/accounting.min.js'
    ];
    protected array $jsIncludes = [
        'invoices.partials._invoices_js'
    ];
    protected array $routes = [
        'index' => 'invoices.index',
        'create' => 'invoices.create',
        'show' => 'invoices.show',
        'edit' => 'invoices.edit',
        'store' => 'invoices.store',
        'destroy' => 'invoices.destroy',
        'update' => 'invoices.update'
    ];
    public function __construct(
        InvoiceInterface $invoiceInterface,
        NumberSettingInterface $numberInterface,
        InvoiceSettingInterface $invoiceSettingInterface,
        InvoiceItemInterface $invoiceItemInterface,
        SettingInterface $settingInterface,
        TemplateInterface $templateInterface,
        SubscriptionInterface $subscriptionInterface,
        ProductInterface $productInterface,
    ){
        parent::__construct();
        $this->entityClass = Invoice::class;
        $this->repository = $invoiceInterface;
        $this->invoiceSettingRepository = $invoiceSettingInterface;
        $this->numberRepository = $numberInterface;
        $this->invoiceItemRepository = $invoiceItemInterface;
        $this->settingRepository = $settingInterface;
        $this->templateRepository = $templateInterface;
        $this->subscriptionRepository = $subscriptionInterface;
        $this->productRepository = $productInterface;
        $this->formClasses .= 'ajax-submit';
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('invoice.create'));
            return $next($request);
        });
    }
    public function beforeCreate($request): void
    {
        $settings     = $this->invoiceSettingRepository->first();
        $start        = $settings ? $settings->start_number : 0;
        $this->heading = 'app.new_invoice';
        $this->modelData['invoice_no'] = $this->numberRepository->prefix('invoice_number', $this->repository->generateInvoiceNum($start));
        $this->modelData['invoice_date'] = date('Y-m-d');
        $this->modelData['due_date'] = $settings ? date('Y-m-d',strtotime("+".$settings->due_days." days")) : date('Y-m-d');
        $this->modelData['terms'] = $settings ? $settings->terms : '';
    }
    public function beforeStore($request, &$input): void
    {
        $input['invoice_date'] = date('Y-m-d', strtotime($request->get('invoice_date')));
        $input['discount'] = $request->get('discount') !== '' ? $request->get('discount') : 0;
        if($request->get('due_date') !== ''){
            $input['due_date'] = date('Y-m-d', strtotime($request->get('due_date')));
        }
    }
    public function afterStore($request, &$entity): void
    {
        $this->saveItems($entity, $request->items);
        $this->saveSubscription($request,$entity);
        $setting = $this->invoiceSettingRepository->first();
        if($setting){
            $start = $setting->start_number+1;
            $this->invoiceSettingRepository->updateById($setting->uuid, ['start_number'=>$start]);
        }
    }
    public function afterUpdate($request, &$entity): void
    {
        $this->saveItems($entity, $request->items);
        $this->repository->changeStatus($entity->uuid);
        $subscription = $this->subscriptionRepository->where('invoice_id',$entity->uuid)->first();
        if($subscription){
            $this->saveSubscription($request,$entity, $subscription->uuid);
        }else{
            $this->saveSubscription($request,$entity);
        }
    }
    public function saveItems($entity, $rows): void
    {
        $ids = [];
        foreach ($rows as $order=>$row) {
            $row['item_order'] = $order;
            if($row['item_id'] > 0){
                $product = $this->productRepository->getById($row['item_id']);
                $row['item_description'] = $product->description;
                $row['product_id'] = $product->uuid;
            }
            $row['invoice_id'] = $entity->uuid;
            $row['tax_id'] = $row['tax_id'] !== '' ? $row['tax_id'] : null;
            if ($row['uuid'] > 0) {
                $record = $entity->items()->find($row['uuid']);
                $record->fill($row);
                $record->save();
            } else {
                $record = $this->invoiceItemRepository->create($row);
            }
            $ids[] = $record->uuid;
        }
        foreach ($entity->items as $row) {
            if (!in_array($row->uuid, $ids)) {
                $row->delete();
            }
        }
    }
    public function show($id){
        $invoice = $this->repository->getById($id);
        if($invoice){
            $settings = $this->settingRepository->first();
            $invoiceSettings = $this->invoiceSettingRepository->first();
            return view('invoices.show',compact('invoice','settings','invoiceSettings'));
        }
        return redirect($this->routes['index']);
    }

    public function saveSubscription($request, $entity, $id=null): void
    {
        if($request->get('recurring') === '1'){
            $cycle = $request->get('recurring_cycle');
            $invoice_date = strtotime($entity->invoice_date);
            $next_due_date = match ($cycle) {
                '1' => date("Y-m-d", strtotime("+1 month", $invoice_date)),
                '2' => date("Y-m-d", strtotime("+3 month", $invoice_date)),
                '3' => date("Y-m-d", strtotime("+6 month", $invoice_date)),
                default => date("Y-m-d", strtotime("+12 month", $invoice_date)),
            };
            $subscriptionData = array(
                'invoice_id' => $entity->uuid,
                'billingcycle' => $cycle,
                'nextduedate' => $next_due_date,
                'status' => '1'
            );
            if(!is_null($id)){
                $this->subscriptionRepository->updateById($id,$subscriptionData);
            }else{
                $this->subscriptionRepository->create($subscriptionData);
            }
        }
    }
    public function ajaxSearch(){
        return $this->repository->ajaxSearch();
    }
   public function deleteItem(): JsonResponse
   {
        $id = request('id');
        if($this->invoiceItemRepository->deleteById($id)) {
            return Response::json(array('success' => true, 'msg' => trans('app.record_deleted')), 201);
        }
        return Response::json(array('success' => false, 'msg' => trans('app.record_deletion_failed')), 400);
    }
    public function invoicePdf($uuid){
        $invoice = $this->repository->getById($uuid);
        if($invoice){
            $settings = $this->settingRepository->first();
            $invoiceSettings = $this->invoiceSettingRepository->first();
            $invoice->pdf_logo = $invoiceSettings && $invoiceSettings->logo ? base64_img($invoiceSettings->logo) : '';
            $pdf = PDF::loadView('invoices.pdf', compact('settings', 'invoice', 'invoiceSettings'));
            return $pdf->download(trans('app.invoice').'_'.$invoice->number.'_'.date('Y-m-d').'.pdf');
        }
        return Redirect::route('invoices');
    }
    public function send_modal($uuid){
        $invoice = $this->repository->getById($uuid);
        $template = $this->templateRepository->where('name', 'invoice')->first();
        return view('invoices.send_modal',compact('invoice','template'));
    }
   public function send(SendEmailFrmRequest $request): JsonResponse
   {
        $uuid = $request->get('invoice_id');
        $invoice = $this->repository->getById($uuid);
        $settings = $this->settingRepository->first();
        $invoiceSettings = $this->invoiceSettingRepository->first();
        $data_object = new \stdClass();
        $data_object->invoice = $invoice;
        $data_object->settings = $settings;
        $data_object->client = $invoice->client;
        $data_object->user = $invoice->client;
        $invoice->pdf_logo = $invoiceSettings && $invoiceSettings->logo ? base64_img($invoiceSettings->logo) : '';
        $pdf_name = trans('app.invoice').'_'. $invoice->invoice_no . '_' . date('Y-m-d') . '.pdf';
        PDF::loadView('invoices.pdf', compact('settings', 'invoice', 'invoiceSettings'))->save(config('app.assets_path').'attachments/'.$pdf_name);
        $params = [
            'data' => [
                'emailBody'=>parse_template($data_object, $request->get('message')),
                'emailTitle'=>parse_template($data_object,$request->get('subject')),
            ],
            'to' => $request->get('email'),
            'template_type' => 'markdown',
            'template' => 'emails.invoicer-mailer',
            'subject' => parse_template($data_object,$request->get('subject')),
            'attachment' => config('app.assets_absolute_path').'attachments/'.$pdf_name
        ];
        try {
            sendmail($params);
            flash()->success(trans('app.email_sent'));
            return response()->json(['type' => 'success', 'message' => trans('app.email_sent')]);
        }catch (\Exception $exception){
            $error = $exception->getMessage();
            flash()->error($error);
            return response()->json(['type' => 'fail','message' => $error],422);
        }
    }
}

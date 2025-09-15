<?php namespace App\Http\Controllers;

use App\Datatables\EstimateDatatable;
use App\Http\Forms\EstimateForm;
use App\Http\Requests\EstimateFormRequest;
use App\Http\Requests\SendEmailFrmRequest;
use App\Invoicer\Repositories\Contracts\EstimateInterface;
use App\Invoicer\Repositories\Contracts\EstimateSettingInterface;
use App\Invoicer\Repositories\Contracts\InvoiceInterface;
use App\Invoicer\Repositories\Contracts\InvoiceItemInterface;
use App\Invoicer\Repositories\Contracts\InvoiceSettingInterface;
use App\Invoicer\Repositories\Contracts\NumberSettingInterface;
use App\Invoicer\Repositories\Contracts\EstimateItemInterface;
use App\Invoicer\Repositories\Contracts\ProductInterface;
use App\Invoicer\Repositories\Contracts\SettingInterface;
use App\Invoicer\Repositories\Contracts\TemplateInterface;
use App\Models\Estimate;
use App\Models\InvoiceSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class EstimatesController extends CrudController {
    protected $numberRepository;
    protected $estimateSettingRepository;
    protected $estimateItemRepository;
    protected $invoiceRepository;
    protected $invoiceItemRepository;
    protected $invoiceSettingRepository;
    protected $settingRepository;
    protected $productRepository;
    protected $templateRepository;
    protected $datatable = EstimateDatatable::class;
    protected string $formClass = EstimateForm::class;
    protected $formRequest = EstimateFormRequest::class;
    protected string $heading =  'app.estimates';
    protected string $icon = 'list-alt';
    protected string $btnCreateText = 'app.new_estimate';
    protected string $createDisplayMode = 'normal';
    protected string $editDisplayMode = 'normal';
    protected string $iconCreate = 'plus';
    protected string $showDisplayMode = 'normal';
    protected array $jsFiles = [
        'assets/plugins/accounting-js/accounting.min.js'
    ];
    protected array $jsIncludes = [
        'estimates.partials._estimatesjs'
    ];
   protected array $routes = [
        'index' => 'estimates.index',
        'create' => 'estimates.create',
        'show' => 'estimates.show',
        'edit' => 'estimates.edit',
        'store' => 'estimates.store',
        'destroy' => 'estimates.destroy',
        'update' => 'estimates.update'
    ];
    public function __construct(
        EstimateInterface $estimateInterface,
        NumberSettingInterface $numberInterface,
        EstimateSettingInterface $estimateSettingInterface,
        EstimateItemInterface $estimateItemInterface,
        SettingInterface $settingInterface,
        TemplateInterface $templateRepository,
        InvoiceInterface $invoiceRepository,
        InvoiceItemInterface $invoiceItemRepository,
        InvoiceSettingInterface $invoiceSettingRepository,
        ProductInterface $productRepository
    ){
        parent::__construct();
        $this->entityClass = Estimate::class;
        $this->repository = $estimateInterface;
        $this->estimateSettingRepository = $estimateSettingInterface;
        $this->numberRepository = $numberInterface;
        $this->estimateItemRepository = $estimateItemInterface;
        $this->settingRepository = $settingInterface;
        $this->templateRepository = $templateRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceItemRepository = $invoiceItemRepository;
        $this->invoiceSettingRepository = $invoiceSettingRepository;
        $this->productRepository = $productRepository;
        $this->formClasses .= 'ajax-submit';
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('estimate.create'));
            return $next($request);
        });
    }
    public function beforeCreate($request): void
    {
        $settings     = $this->estimateSettingRepository->first();
        $this->heading = 'app.add_estimate';
        $this->modelData['estimate_no'] = $this->numberRepository->prefix('estimate_number', $this->repository->generateEstimateNum());
        $this->modelData['terms'] = $settings ? $settings->terms : '';
    }
    public function beforeStore($request, &$input): void
    {
        $input['estimate_date'] = date('Y-m-d', strtotime($request->get('estimate_date')));
    }
    public function afterStore($request, &$entity): void
    {
        $this->saveItems($entity, $request->items);
        $setting = $this->estimateSettingRepository->first();
        if($setting){
            $start = $setting->start_number+1;
            $this->estimateSettingRepository->updateById($setting->uuid, ['start_number'=>$start]);
        }
    }
    public function afterUpdate($request, &$entity)
    {
        $this->saveItems($entity, $request->items);
    }

    public function deleteItem(): JsonResponse
    {
        $uuid = request('id');
        if($this->estimateItemRepository->deleteById($uuid)) {
            return Response::json(array('success' => true, 'msg' => trans('app.record_deleted')));
        }
        return Response::json(array('success' => false, 'msg' => trans('app.record_deletion_failed')), 400);
    }
    public function show($id){
        $estimate = $this->repository->getById($id);
        if($estimate){
            $settings = $this->settingRepository->first();
            $estimate_settings = $this->estimateSettingRepository->first();
            return view('estimates.show',compact('estimate','settings','estimate_settings'));
        }
        return redirect($this->routes['index']);
    }
    public function estimatePdf($uuid){
        $estimate = $this->repository->getById($uuid);
        if($estimate){
            $settings = $this->settingRepository->first();
            $estimate_settings = $this->estimateSettingRepository->first();
            $estimate->estimate_logo = $estimate_settings && $estimate_settings->logo ? base64_img($estimate_settings->logo) : '';
            $pdf = PDF::loadView('estimates.pdf', compact('settings', 'estimate','estimate_settings'));
            return $pdf->download(trans('app.estimate').'_'.$estimate->estimate_no.'_'.date('Y-m-d').'.pdf');
        }
        return Redirect::route('estimates.index');
    }
    public function send_modal($uuid){
        $estimate = $this->repository->getById($uuid);
        $template = $this->templateRepository->where('name', 'estimate')->first();
        return view('estimates.send_modal',compact('estimate','template'));
    }
    public function send(SendEmailFrmRequest $request){
        try {
        $uuid = $request->get('estimate_id');
        $estimate = $this->repository->getById($uuid);
        $settings = $this->settingRepository->first();
        $estimate_settings = $this->estimateSettingRepository->first();
        $data_object = new \stdClass();
        $data_object->settings  = $settings;
        $data_object->client    = $estimate->client;
        $data_object->user = $estimate->client;
        $estimate->estimate_logo = $estimate_settings && $estimate_settings->logo ? base64_img($estimate_settings->logo) : '';
        $pdf_name = trans('app.estimate').'_'. $estimate->estimate_no . '_' . date('Y-m-d') . '.pdf';
        PDF::loadView('estimates.pdf', compact('settings', 'estimate', 'estimate_settings'))->save(config('app.assets_path').'attachments/'.$pdf_name);
        $params = [
            'data' => [
                'emailBody'=>parse_template($data_object, $request->get('message')),
                'emailTitle'=>parse_template($data_object,$request->get('subject'))
            ],
            'to' => $request->get('email'),
            'template_type' => 'markdown',
            'template' => 'emails.invoicer-mailer',
            'subject' => parse_template($data_object,$request->get('subject')),
            'attachment' => config('app.assets_absolute_path').'attachments/'.$pdf_name
        ];
            sendmail($params);
            flash()->success(trans('app.email_sent'));
            return response()->json(['type' => 'success','message' => trans('app.email_sent')]);
        }catch (\Exception $exception){
            $error = $exception->getMessage();
            flash()->error($error);
            return response()->json(['type' => 'fail', 'message' => $error],422);
        }
    }
    public function makeInvoice(){
        $uuid = request()->get('id');
        $estimate = $this->repository->getById($uuid);
        $settings     = $this->invoiceSettingRepository->first();
        $start        = $settings ? $settings->start_number : 0;
        $startNum     = $this->invoiceRepository->generateInvoiceNum($start);
        $invoice_num  = $this->numberRepository->prefix('invoice_number', $startNum);
        $invoiceData = array(
            'client_id'     => $estimate->client_id,
            'invoice_no'    => $invoice_num,
            'invoice_date'  => date('Y-m-d'),
            'notes'         => $estimate->notes,
            'terms'         => $estimate->terms,
            'currency'      => $estimate->currency,
            'status'        => '0',
            'discount'      => 0,
            'recurring'     => 0,
            'recurring_cycle' => 1,
            'due_date' => date('Y-m-d')
        );
        $invoice = $this->invoiceRepository->create($invoiceData);
        if($invoice) {
            $items = $estimate->items;
            foreach ($items as $item) {
                $itemsData = array(
                    'invoice_id' => $invoice->uuid,
                    'item_name' => $item->item_name,
                    'item_description' => $item->item_description,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'tax_id' => $item->tax !== '' ? $item->tax->uuid : null,
                );
                $this->invoiceItemRepository->create($itemsData);
            }
            $settings = $this->invoiceSettingRepository->first();
            if ($settings) {
                $start = $startNum + 1;
                $this->invoiceSettingRepository->updateById($settings->uuid, ['start_number' => $start]);
            }
            return Response::json(array('success' => true, 'redirectTo'=>route('invoices.show',$invoice->uuid), 'msg' => trans('app.record_created')), 200);
        }
        return Response::json(array('success' => false, 'msg' => trans('app.record_creation_failed')), 400);
    }
    public function saveItems($entity, $rows){
        $ids = [];
        foreach ($rows as $order=>$row) {
            $row['item_order'] = $order;
            if($row['item_id'] > 0){
                $product = $this->productRepository->getById($row['item_id']);
                $row['item_description'] = $product->description;
                $row['product_id'] = $product->uuid;
            }
            $row['estimate_id'] = $entity->uuid;
            $row['tax_id'] = $row['tax_id'] != '' ? $row['tax_id'] : null;
            if ($row['uuid'] > 0) {
                $record = $entity->items()->find($row['uuid']);
                $record->fill($row);
                $record->save();
            } else {
                $record = $this->estimateItemRepository->create($row);
            }
            $ids[] = $record->uuid;
        }
        foreach ($entity->items as $row) {
            if (!in_array($row->uuid, $ids)) {
                $row->delete();
            }
        }
    }
}

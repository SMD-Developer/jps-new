<?php namespace App\Http\Controllers;

use App\Datatables\PaymentDatatable;
use App\Http\Forms\PaymentForm;
use App\Http\Requests\PaymentFormRequest;
use App\Invoicer\Repositories\Contracts\InvoiceInterface;
use App\Invoicer\Repositories\Contracts\PaymentInterface;
use App\Invoicer\Repositories\Contracts\PaymentMethodInterface as PaymentMethod;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Laracasts\Flash\Flash;

class PaymentsController extends CrudController {
    protected $invoiceRepository;
    protected $datatable = PaymentDatatable::class;
    protected string $formClass = PaymentForm::class;
    protected $formRequest = PaymentFormRequest::class;
    protected string $heading =  'app.payments';
    protected string $icon = 'money';
    protected string $btnCreateText = 'app.new_payment';
    protected string $iconCreate = 'plus';
    protected array $routes = [
        'index' => 'payments.index',
        'create' => 'payments.create',
        'show' => 'payments.show',
        'edit' => 'payments.edit',
        'store' => 'payments.store',
        'destroy' => 'payments.destroy',
        'update' => 'payments.update'
    ];
    public function __construct(
        PaymentInterface $paymentInterface,
        InvoiceInterface $invoiceRepository
    ){
        parent::__construct();
        $this->repository = $paymentInterface;
        $this->invoiceRepository = $invoiceRepository;
        $this->entityClass = Payment::class;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('payment.create'));
            return $next($request);
        });
    }
    public function beforeStore($request, &$input): void
    {
        $input['payment_date'] = date('Y-m-d', strtotime($request->get('payment_date')));
    }
    public function beforeUpdate($request, &$entity, &$input)
    {
        $this->beforeStore($request, $input);
    }
    public function create(Request $request)
	{
        $this->authorize('create', $this->entityClass);
        $invoice_id = request('invoice_id');
        if($invoice_id){
            $invoice = $this->invoiceRepository->getById($invoice_id);
            $invoice->totals = $this->invoiceRepository->invoiceTotals($invoice_id);
        }
        else{
            $invoice = null;
        }
        $form = $this->form($this->formClass, [
            'method' => 'POST',
            'url' => route($this->routes['store']),
            'id' => 'payment_form',
            'class' => 'needs-validation row ajax-submit',
            'novalidate',
            'model'=> [
                'invoice'=>$invoice
            ]
        ]);
        $heading = trans('app.add_payment');
        return view('crud.modal', compact('heading','form','invoice'));
	}
}

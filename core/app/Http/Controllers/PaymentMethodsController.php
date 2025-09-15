<?php

namespace App\Http\Controllers;

use App\Datatables\PaymentMethodDatatable;
use App\Http\Forms\PaymentMethodForm;
use App\Http\Requests\PaymentMethodFromRequest;
use App\Invoicer\Repositories\Contracts\PaymentMethodInterface;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\View;

class PaymentMethodsController extends CrudController {
    protected string $formClass = PaymentMethodForm::class;
    protected $datatable = PaymentMethodDatatable::class;
    protected $formRequest = PaymentMethodFromRequest::class;
    protected string $heading =  'app.payment_methods';
    protected string $icon = 'money';
    protected string $btnCreateText = 'app.new_payment_method';
    protected string $iconCreate = 'plus';
    protected bool $settingsMode = true;
    protected array $routes = [
        'index' => 'settings.payment.index',
        'create' => 'settings.payment.create',
        'store' => 'settings.payment.store',
        'update' => 'settings.payment.update'
    ];
    public function __construct(PaymentMethodInterface $paymentInterface){
        parent::__construct();
        $this->entityClass = PaymentMethod::class;
        $this->repository = $paymentInterface;
        $this->middleware(function ($request, $next) {
            View::share('showBtnCreate', hasPermission('payment-method.create'));
            return $next($request);
        });
    }
}

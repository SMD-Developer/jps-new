<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Invoicer\Repositories\Contracts\PaymentMethodInterface as PaymentMethod;
class PaymentForm extends Form
{
    public function __construct(PaymentMethod $paymentmethod){
        $this->paymentmethod = $paymentmethod;
    }
    public function buildForm()
    {
        if(isset($this->model['invoice'])){
            $invoice = $this->model['invoice'];
            $this->add('invoice_id', 'hidden', [
                'label_show' => false,
                'value' => $invoice->uuid,
            ]);
            $this->add('invoice', 'text', [
                'label' => trans('app.invoice'),
                'attr'=>['form-control form-control-sm','disabled'],
                'value'=> '#'.$invoice->invoice_no.' (Bal '.$invoice->totals['amountDue'].') | '. ($invoice->client->name ?? null),
                'wrapper' => ['class' => 'form-group col-sm-12'],
            ]);
        }else{
            $this->add('invoice_id', 'select', [
                'label' => trans('app.invoice'),
                'choices' => [],
                'attr'=>['required','class'=>'form-control form-control-sm ajaxChosen','data-placeholder' => 'Type atleast 1 characters of the invoice number'],
                'wrapper' => ['class' => 'form-group col-sm-12'],
            ]);
        }
        $this->add('payment_date', 'text', [
            'label' => trans('app.received_on'),
            'attr'=>['class'=>'datepicker form-control form-control-sm','required'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('method', 'select', [
            'label' => trans('app.payment_method'),
            'choices' => $this->paymentmethod->paymentMethodSelect(),
            'attr'=>['class'=>'form-control form-control-sm chosen','required'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('amount', 'number', [
            'label' => trans('app.amount'),
            'attr'=>['class'=>'form-control form-control-sm', 'required'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('notes', 'textarea', [
            'label' => trans('app.notes'),
            'attr'=>['class'=>'form-control form-control-sm','rows'=>5],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('buttons', 'static', [
            'template' => 'crud.modal_form_buttons'
        ]);
    }
}

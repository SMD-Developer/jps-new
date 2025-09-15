<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class PaymentMethodForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('app.name'),
            'attr'=>['class'=>'form-control form-control-sm','required'],
            'wrapper' => ['class' => 'form-group col-sm-12']
        ]);
        $this->add('selected', 'select', [
            'label' => trans('app.default_payment_method'),
            'attr'=>['class'=>'form-control chosen form-control-sm'],
            'choices'=> yes_no_select(),
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('buttons', 'static', [
            'template' => 'crud.modal_form_buttons'
        ]);
    }
}

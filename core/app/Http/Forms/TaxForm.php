<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class TaxForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('app.tax_name'),
            'attr'=>['class'=>'form-control','required'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('value', 'text', [
            'label' => trans('app.due_after'),
            'template' => 'settings.partials.tax_value'
        ]);
        $this->add('selected', 'select', [
            'label' => trans('app.default_tax'),
            'attr'=>['class'=>'form-control chosen form-control-sm'],
            'choices'=> yes_no_select(),
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('buttons', 'static', [
            'template' => 'crud.modal_form_buttons'
        ]);
    }
}

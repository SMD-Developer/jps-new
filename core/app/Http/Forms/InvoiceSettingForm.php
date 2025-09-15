<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class InvoiceSettingForm extends Form
{
    public function buildForm()
    {
        $this->add('start_number', 'text', [
            'label' => trans('app.number_invoice_starting'),
            'attr'=>['class'=>'form-control form-control-sm','required'],
            'wrapper' => ['class' => 'form-group col-sm-12']
        ]);
        $this->add('terms', 'textarea', [
            'label' => trans('app.invoice_terms'),
            'attr'=>['class'=>'form-control form-control-sm text_editor','rows'=>7, 'id'=>'invoice_terms'],
            'wrapper' => ['class' => 'form-group col-sm-12']
        ]);
        $this->add('logo_label', 'static', [
            'label_show' => false,
            'tag' => 'label',
            'value' => trans('app.logo'),
            'wrapper' => ['class' => 'form-group col-sm-12 mb-1'],
        ]);
        if($this->model && $this->model->logo != ''){
            $this->add(
                'logo_preview',
                'static', [
                    'tag' => 'img',
                    'attr' => ['class' => 'form-control-static thumbnail', 'src' => asset(image_url($this->model->logo))],
                    'label_show' => false,
                ]
            );
        }
        $this->add('logo', 'file', [
            'label' => 'No file added',
            'label_attr'=>['class'=>'custom-file-label'],
            'attr'=>['class'=>'custom-file-input','accept'=>"image/*",'onchange'=>"$(this).parents('.custom-file').find('.custom-file-label').html($(this).val());"],
            'wrapper' => ['class' => 'custom-file col-sm-12 mb-3'],
        ]);
        $this->add('due_days', 'text', [
            'label' => trans('app.due_after'),
            'template' => 'settings.partials.due_days'
        ]);
        $this->add('show_status', 'select', [
            'label' => trans('app.show_status'),
            'attr'=>['class'=>'form-control chosen form-control-sm'],
            'choices'=> yes_no_select(),
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('show_pay_button', 'select', [
            'label' => trans('app.show_pay_button'),
            'attr'=>['class'=>'form-control chosen form-control-sm'],
            'choices'=> yes_no_select(),
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('show_product_images', 'select', [
            'label' => trans('app.show_product_images'),
            'attr'=>['class'=>'form-control chosen form-control-sm'],
            'choices'=> yes_no_select(),
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('buttons', 'static', [
            'template' => 'crud.form_button'
        ]);
    }
}

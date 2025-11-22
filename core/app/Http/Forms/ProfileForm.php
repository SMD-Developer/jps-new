<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class ProfileForm extends Form
{
    public function buildForm()
    {
        $this->add('name', 'text', [
            'label' => trans('app.name'),
            'attr'=>['required', 'placeholder' => 'Enter your name'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
            'error_messages' => [
                'name.required' => 'Name is required'
            ]
        ]);
        
        $this->add('email', 'text', [
            'label' => trans('app.email'),
            'attr'=>['required', 'placeholder' => 'Enter your email'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
            'error_messages' => [
                'email.required' => 'Email is required',
                'email.email' => 'Please enter a valid email'
            ]
        ]);
        
        $this->add('address', 'textarea', [
            'label' => trans('app.address'),
            'attr'=>['rows' => 3, 'placeholder' => trans('app.enter_address')],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        
        $this->add('phone', 'text', [
            'label' => trans('app.phone'),
            'attr'=>['placeholder' => 'Enter your phone number'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        
        $this->add('image_label', 'static', [
            'label_show' => false,
            'tag' => 'label',
            'value' => trans('app.photo'),
            'wrapper' => ['class' => 'form-group col-sm-12 mb-1'],
        ]);
        
        $this->add(
            'photo_preview',
            'static', [
                'tag' => 'img',
                'attr' => ['class' => 'form-control-static thumbnail', 'src' => $this->model->photo !== '' ? image_url($this->model->photo) : image_url('uploads/no-image.jpg')],
                'label_show' => false,
            ]
        );
        
        $this->add('photo', 'file', [
            'label' => 'No file added',
            'label_attr'=>['class'=>'custom-file-label'],
            'attr'=>['class'=>'custom-file-input','accept'=>"image/*",'onchange'=>"$(this).parents('.custom-file').find('.custom-file-label').html($(this).val());"],
            'wrapper' => ['class' => 'custom-file col-sm-12 mb-3'],
        ]);
        
        $this->add('buttons', 'static', [
            'template' => 'crud.form_button'
        ]);
    }
}
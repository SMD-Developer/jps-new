<?php

namespace App\Http\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Invoicer\Repositories\Contracts\RoleInterface as Role;
class UserForm extends Form
{
    public function __construct(Role $role){
        $this->role = $role;
    }
    public function buildForm()
    {
        $this->add('username', 'text', [
            'label' => trans('app.username'),
            'attr'=>['class'=>'form-control form-control-sm','required'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('name', 'text', [
            'label' => trans('app.name'),
            'attr'=>['class'=>'form-control form-control-sm','required'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('email', 'text', [
            'label' => trans('app.email'),
            'attr'=>['class'=>'form-control form-control-sm','required'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('phone', 'text', [
            'label' => trans('app.phone'),
            'attr'=>['class'=>'form-control form-control-sm'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('role_id', 'select', [
            'label' => trans('app.role'),
            'choices' => $this->role->all()->pluck('name','uuid')->toArray(),
            'attr'=>['class'=>'form-control form-control-sm chosen','required'],
            'wrapper' => ['class' => 'form-group col-sm-12'],
        ]);
        $this->add('image_label', 'static', [
            'label_show' => false,
            'tag' => 'label',
            'value' => trans('app.photo'),
            'wrapper' => ['class' => 'form-group col-sm-12 mb-1'],
        ]);
        if($this->model && isset($this->model['photo']) && !empty($this->model['photo'])){
            $this->add(
                'photo_preview',
                'static', [
                    'tag' => 'img',
                    'attr' => ['class' => 'form-control-static', 'src' => image_url($this->model->photo),'width'=>'100px'],
                    'label_show' => false,
                ]
            );
        }
        $this->add('user_photo', 'file', [
            'label' => 'No file added',
            'label_attr'=>['class'=>'custom-file-label'],
            'attr'=>['class'=>'custom-file-input','accept'=>"image/*",'onchange'=>"$(this).parents('.custom-file').find('.custom-file-label').html($(this).val());"],
            'wrapper' => ['class' => 'custom-file col-sm-12 mb-3'],
        ]);
        $this->add('password', 'repeated', [
            'type' => 'password',
            'first_name' => 'password',
            'second_name' => 'password_confirmation',
            'attr'=>['autocomplete'=>'new-password','class'=>'form-control form-control-sm'],
            'first_options'=>['value'=>null,'label'=>trans('app.password')],
            'second_options'=>['value'=>null,'label'=>trans('app.confirm_password')],
            'wrapper' => ['class' => 'form-group col-sm-12']
        ]);
        $this->add('buttons', 'static', [
            'template' => 'crud.modal_form_buttons'
        ]);
    }
}

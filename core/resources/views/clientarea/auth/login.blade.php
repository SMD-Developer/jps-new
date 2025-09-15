<!--@extends('clientarea.default')-->
<!--@section('content')-->
<!--    @if (isset($errors) && count($errors) > 0)-->
<!--        {!! display_form_errors($errors) !!}-->
<!--    @endif-->
<!--    <section class="login-form">-->
<!--        {!! Form::open(['url' => '/clientarea/login','class'=>'loginFrm needs-validation','novalidate']) !!}-->
<!--        <div class="form-group">-->
            
<!--            {!! Form::label('email', trans('app.email')) !!}-->
<!--            {!! Form::input('email','login', null, ['class'  =>"form-control", 'required'=>'required', 'placeholder'=>"Email"]) !!}-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            {!! Form::label('password', trans('app.password')) !!}-->
<!--            {!! Form::password('password', ['class'=>"form-control", 'placeholder'=>"Password", 'required']) !!}-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            {!! Form::Submit('Login', ['class'=>"btn btn-primary login-button btn-sm form-control"]) !!}-->
<!--        </div>-->
<!--        {!! Form::close() !!}-->
<!--    </section>-->
<!--@endsection-->

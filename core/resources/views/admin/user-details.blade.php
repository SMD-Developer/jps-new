@extends('app')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    section.content {
        font-size: 13px;
    }
</style>
<title>{{$title}} | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-user" aria-hidden="true"></i> {{$title}}</h5>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <div class="section">
                        <div class="container mb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="border rounded p-4">
                                        <h5>@lang('app.account_information')</h5>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.account_type')</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->account_type_name  }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.email_address')</label>
                                            <input type="email" class="form-control" value="{{ $ClientRegister->email }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.password')</label>
                                            <input type="password" class="form-control" value="********" readonly>
                                        </div>
                                        
                                        <h5 class="mt-4">@lang('app.user_information')</h5>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.username')</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->userName }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.identification_card_number')</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->idCardNumber }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.registered_address')</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->registeredAddress }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.postal_code')</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->postalCode }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.state')</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->state }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.district')</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->district }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.city')</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->city }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.mobile_number')</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->mobileNumber }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.telephone_no') (P)</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->landline }}" readonly>
                                        </div>
                                        
                                        <h5 class="mt-4">@lang('app.security_questions')</h5>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.security_questions') 1</label>
                                            <input type="text" class="form-control" value="{{ $securityQuestion1 ?? 'Error: Question not found' }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.security_answers') 1</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->securityAnswers1 }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.security_questions') 2</label>
                                            <input type="text" class="form-control" value="{{ $securityQuestion2 }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.security_answers') 2</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->securityAnswers2 }}" readonly>
                                        </div>
                                        <div class="mt-4 text-right">
                                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">@lang('app.back')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

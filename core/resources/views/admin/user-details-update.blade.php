
@extends('app')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
    /* Your styles here */
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
                                    <form id="updateUserForm" action="{{ route('update_user_details', $ClientRegister->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')                                    
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
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.confirm_password')</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                                        </div>
                                        
                                        <h5 class="mt-4">@lang('app.user_information')</h5>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.username')</label>
                                            <input type="text" class="form-control" name="userName" value="{{ $ClientRegister->userName }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.identification_card_number')</label>
                                            <input type="text" class="form-control" name="idCardNumber" value="{{ $ClientRegister->idCardNumber }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.registered_address')</label>
                                            <input type="text" class="form-control" name="registeredAddress" value="{{ $ClientRegister->registeredAddress }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.postal_code')</label>
                                            <input type="text" class="form-control" name="postalCode" value="{{ $ClientRegister->postalCode }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.state')</label>
                                            <select class="form-control" id="negeri" name="state">
                                                <option value="">Sila Pilih Negeri</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->idnegeri }}" {{ $ClientRegister->state_id == $state->idnegeri ? 'selected' : '' }}>
                                                        {{ $state->negeri }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.district')</label>
                                            <select class="form-control" id="daerah" name="district">
                                                <option value="">Sila Pilih Daerah</option>
                                                @foreach($districts as $district)
                                                    <option value="{{ $district->iddaerah }}" {{ $ClientRegister->district_id == $district->iddaerah ? 'selected' : '' }}>
                                                        {{ $district->daerah_code . ' - ' . $district->daerah }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.city')</label>
                                            <input type="text" class="form-control" name="city" value="{{ $ClientRegister->city }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.mobile_number')</label>
                                            <input type="text" class="form-control" name="mobileNumber" value="{{ $ClientRegister->mobileNumber }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.telephone_no') (P)</label>
                                            <input type="text" class="form-control" name="landline" value="{{ $ClientRegister->landline }}">
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
                                            <input type="text" class="form-control" value="{{ $securityQuestion2 ?? 'Error: Question not found' }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">@lang('app.security_answers') 2</label>
                                            <input type="text" class="form-control" value="{{ $ClientRegister->securityAnswers2 }}" readonly>
                                        </div>
                                        <div class="mt-4 text-right">
                                            <button type="button" class="btn btn-primary" onclick="updateUser()">@lang('app.update')</button>
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
    <script>
        $(document).ready(function () {
            $('#negeri').on('change', function () {
                const stateId = $(this).val();
                $('#daerah').html('<option value="">Loading...</option>');
    
                if (stateId) {
                    $.ajax({
                        url: `/clientarea/register-districts/${stateId}`,
                        type: 'GET',
                        success: function (data) {
                            let options = '<option value="">Sila Pilih Daerah</option>';
                            data.forEach(district => {
                                options += `<option value="${district.iddaerah}">${district.daerah_code} - ${district.daerah}</option>`;
                            });
                            $('#daerah').html(options);
                        },
                        error: function () {
                            $('#daerah').html('<option value="">Error loading districts</option>');
                        }
                    });
                } else {
                    $('#daerah').html('<option value="">Sila Pilih</option>');
                }
            });
        });
    </script>
    <script>
        function updateUser() {
            Swal.fire({
                title: '@lang("app.are_you_sure")',
                text: '@lang("app.confirm_update")',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang("app.yes")',
                cancelButtonText: '@lang("app.cancel")',
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $('#updateUserForm');
                    let formData = form.serialize(); // Serialize form data
    
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            Swal.fire({
                                title: '@lang("app.success")',
                                text: '@lang("app.user_updated_successfully")',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = "{{ route('developer_list') }}"; // Redirect after success
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                title: '@lang("app.error")',
                                text: '@lang("app.something_went_wrong")',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }
    </script>
    
@endsection
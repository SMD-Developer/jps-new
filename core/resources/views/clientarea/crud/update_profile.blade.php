@extends('clientarea.app')

<title>@lang('app.update_profile') | JPS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
    .custom-file{
        display: flex !important;
        align-items: baseline !important;
    }
.custom-file-input{
        display: none !important;
        /* Hide the default file input */
    }

    .submit-button {
        padding: 10px 40px !important;
        border: 2px solid #ccc !important;
        border-radius: 5px !important;
        background-color: #f0f0f0 !important;
        cursor: pointer !important;
    }

    .submit-button:hover {
        background-color: #e0e0e0 !important;
    }

    .file-name {
        margin-top: 10px !important;
        font-size: 14px !important;
        color: #555 !important;
    }
</style>    
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-edit nav-icon"></i> {{ trans('app.personal_details') }}</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form" method="POST" action="{{ route('update_profile', $client->id) }}" enctype="multipart/form-data" id="registrationForm">
                            @csrf
                            @method('PUT')  <!-- Add this line to specify the PUT method -->
                            <div class="row mb-lg-0 mb-5">
                                <div class="col-md-6">
                                    <!-- Account Type -->
                                    
                                    <div class="form-group">
                                        <label for="accountType">@lang('app.account_type')</label>
                                        <select class="form-select form-group" name="accountType" disabled>
                                            @foreach($accountTypes as $account_type)
                                                @if($account_type->id == $client->accountType)
                                                    <option value="{{ $account_type->id }}" selected>{{ $account_type->name }}</option>
                                                    @break {{-- Exit loop after finding the match --}}
                                                @endif
                                            @endforeach
                                        </select>
                                        <!-- Hidden field to still submit the value if needed -->
                                        <input type="hidden" name="accountType" value="{{ $client->accountType }}">
                                    </div>

                                    <!-- User Name -->
                                    <div class="form-group">
                                        <label for="userName">@lang('app.username')</label>
                                        <input type="text" name="userName" id="userName" class="form-control" value="{{ old('userName', $client->userName) }}" required>
                                        @error('userName') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Registered Address -->
                                    <div class="form-group">
                                        <label for="registeredAddress">@lang('app.registered_address')</label>
                                        <input type="text" name="registeredAddress" id="registeredAddress" class="form-control" value="{{ old('registeredAddress', $client->registeredAddress) }}" required>
                                        @error('registeredAddress') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- State -->
                                    <div class="form-group">
                                        <label for="state">@lang('app.state')</label>
                                        <select class="form-select form-group" name="state" required>
                                            <option value="{{ $client->state_id }}|{{ $client->state }}" selected>{{ $client->state }}</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->idnegeri }}|{{ $state->negeri }}" {{ $state->idnegeri == $client->state_id ? 'selected' : '' }}>{{ $state->negeri }}</option>
                                            @endforeach
                                        </select>
                                        @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- City -->
                                    <div class="form-group">
                                        <label for="city">@lang('app.city')</label>
                                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $client->city) }}" required>
                                        @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Mobile Number -->
                                    <div class="form-group">
                                        <label for="mobileNumber">@lang('app.mobile_number')</label>
                                        <input type="text" name="mobileNumber" id="mobileNumber" class="form-control" value="{{ old('mobileNumber', $client->mobileNumber) }}" required>
                                        @error('mobileNumber') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                </div>
                                
                                <div class="col-md-6">
                                    <!-- Email -->
                                    <div class="form-group">
                                        <label for="email">@lang('app.email_address')</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}" required readonly>
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- ID Card Number -->
                                    <div class="form-group">
                                        <label for="idCardNumber">@lang('app.identification_card_number')</label>
                                        <input type="text" name="idCardNumber" id="idCardNumber" class="form-control" value="{{ old('idCardNumber', $client->idCardNumber) }}" required>
                                        @error('idCardNumber') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Postal Code -->
                                    <div class="form-group">
                                        <label for="postalCode">@lang('app.postal_code')</label>
                                        <input type="text" name="postalCode" id="postalCode" class="form-control" value="{{ old('postalCode', $client->postalCode) }}" required>
                                        @error('postalCode') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- District -->
                                    <div class="form-group">
                                        <label for="district">@lang('app.district')</label>
                                        <select class="form-select form-group" name="district" required>
                                            <option value="{{ $client->district_id }}|{{ $client->district }}" selected>{{ $client->district }}</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->iddaerah }}|{{ $district->daerah }}" {{ $district->iddaerah == $client->district_id ? 'selected' : '' }}>{{ $district->daerah }}</option>
                                            @endforeach
                                        </select>
                                        @error('district') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <!-- Landline -->
                                    <div class="form-group">
                                        <label for="landline">@lang('app.telephone_no')(P)</label>
                                        <input type="text" name="landline" id="landline" class="form-control" value="{{ old('landline', $client->landline) }}">
                                        @error('landline') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>  
                                </div>
                                <!-- Profile Image Upload -->
                                <div class="form-group">
                                    <label for="profileImage">@lang('app.profile_image')</label><br>
                                    
                                    <!-- Preview -->
                                    <div class="mb-4">
                                        <img id="profileImagePreview" 
                                             src="{{ Auth::guard('user')->user()->photo ? asset('assets/images/uploads/client_images/' . Auth::guard('user')->user()->photo) : asset('assets/images/uploads/defaultavatar.png') }}" 
                                             alt="Profile Image" 
                                             style="width: 150px; height: 150px; object-fit: cover; border-radius: 90px;">
                                    </div>
                                
                                    <!-- File input -->
                                    <div class="input-group" style="width:50%;">
                                        <div class="custom-file">
                                            {{-- <input type="file" name="photo" id="profileImage" class="custom-file-input" accept="image/*"> --}}
                                            {{-- <label class="custom-file-label" for="profileImage">
                                                @lang('app.choose_file')
                                            </label> --}}
                                            <label for="profileImage" class="submit-button is-invalid">@lang('app.choose_file')</label>
                                            <input type="file" id="profileImage" name="photo" class="custom-file-input" accept="image/*" >
                                            <div id="profileImage" class="file-name"></div>
                                        </div>
                                    </div>
                                    @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">@lang('app.edit_profile')</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            // Enable/Disable Reset Button based on form input
            $('#registrationForm input, #registrationForm select').on('input change', function () {
                let isFormFilled = $('#registrationForm')[0].checkValidity();
                if (isFormFilled) {
                    $('#resetButton').prop('disabled', false);
                } else {
                    $('#resetButton').prop('disabled', true);
                }
            });
            // Handle form submission with AJAX
            $('#registrationForm').on('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: "@lang('app.are_you_sure')",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "@lang('app.yes')",
                    cancelButtonText: "@lang('app.cancel')"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData(this); // Correct for files and _method spoofing

                        $.ajax({
                            url: "{{ route('update_profile', $client->id) }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,

                            success: function (response) {
                                if (response.success) {
                                    updateFormFields(response.data);
                                    Swal.fire({
                                        title: "@lang('app.updated_successfully')",
                                        text: response.message || "{{ __('app.your_profile_updated') }}",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                }
                            },

                            error: function (xhr) {
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    $('.error-message').text('');
                                    $.each(errors, function (key, value) {
                                        $("#" + key + "-error").text(value[0]);
                                    });

                                    Swal.fire({
                                        title: "@lang('app.validation_error')",
                                        text: "@lang('app.please_fill_up')",
                                        icon: "error",
                                        confirmButtonText: "OK"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "An unexpected error occurred. Please try again.",
                                        icon: "error",
                                        confirmButtonText: "OK"
                                    });
                                }
                            },
                        });
                    }
                });
            });

    
            function updateFormFields(data) {
                if (!data) {
                    console.error("Data is undefined:", data);
                    return;
                }
                $('#accountType').val(data.accountType || '');
                $('#email').val(data.email || '');
                $('#userName').val(data.userName || '');
                $('#idCardNumber').val(data.idCardNumber || '');
                $('#registeredAddress').val(data.registeredAddress || '');
                $('#state').val(data.state_id + '|' + data.state || '');
                $('#district').val(data.district_id + '|' + data.district || '');
                $('#city').val(data.city || '');
                $('#mobileNumber').val(data.mobileNumber || '');
                $('#landline').val(data.landline || '');
            }
        });
    </script>
    <script>
        // Live preview for profile image
    $('#profileImage').on('change', function (e) {
        const [file] = this.files;
        if (file) {
            $('#profileImagePreview').attr('src', URL.createObjectURL(file));
        }
    });
    </script>
    <script>
        document.getElementById('profileImage').addEventListener('change', function(e) {
            const file = this.files[0];
            const label = this.nextElementSibling;
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    
            if (file) {
                // Check file type
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        title: "@lang('app.invalid_format')",
                        text: "@lang('app.allowed_formats') jpeg, jpg, png, webp.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
    
                    // Reset input and preview
                    this.value = "";
                    label.innerText = "@lang('app.choose_file')";
                    document.getElementById('profileImagePreview').src = "{{ Auth::guard('user')->user()->photo ? asset('assets/images/uploads/client_images/' . Auth::guard('user')->user()->photo) : asset('assets/images/uploads/defaultavatar.png') }}";
                    return;
                }
    
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        title: "@lang('app.file_too_large')",
                        text: "@lang('app.image_less_than_2mb')",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
    
                    // Reset input and preview
                    this.value = "";
                    label.innerText = "@lang('app.choose_file')";
                    document.getElementById('profileImagePreview').src = "{{ Auth::guard('user')->user()->photo ? asset('assets/images/uploads/client_images/' . Auth::guard('user')->user()->photo) : asset('assets/images/uploads/defaultavatar.png') }}";
                    return;
                }
    
                // Valid file — update label and preview
                label.innerText = file.name;
    
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profileImagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>   
    <script>
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : '@lang('app.no_file_chosen')';
                document.getElementById(this.id + 'fileName').textContent = fileName;
            });
        });
    </script> 
@endsection
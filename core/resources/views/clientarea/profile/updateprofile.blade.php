@extends('clientarea.app')

<title>@lang('app.update_profile') | JPS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-edit nav-icon"></i>{{ trans('app.personal_details') }}</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                       <form class="form"  method="post" action="{{ route('update_profile', $client->id) }}"  enctype="multipart/form-data" id="registrationForm">
                           @csrf
                           <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="accountType">Account Type</label>
                                        <select class="form-select form-group" name="accountType" aria-label="Default select example">
                                            <option value="{{ $client->accountType }}" selected>
                                                {{ $client->accountType }}
                                            </option>
                                            @foreach($accountTypes as $account_type)
                                                <option 
                                                    value="{{ $account_type->id }}" 
                                                    {{ ($account_type->id == $client->accountType) ? 'selected' : '' }}>
                                                    {{ $account_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="userName">User Name</label>
                                        <input type="text" name="userName" id="userName" class="form-control" 
                                            value="{{ old('userName', $client->userName) }}" required>
                                        @if ($errors->has('userName'))
                                            <span class="text-danger">{{ $errors->first('userName') }}</span>
                                        @endif
                                    </div>

                                     <div class="form-group">
                                        <label for="registeredAddress">Registered Address</label>
                                        <input type="text" name="registeredAddress" id="registeredAddress" class="form-control" 
                                            value="{{ old('registeredAddress', $client->registeredAddress) }}" required>
                                        @if ($errors->has('registeredAddress'))
                                            <span class="text-danger">{{ $errors->first('registeredAddress') }}</span>
                                        @endif
                                    </div>                                   

                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select class="form-select form-group" name="state" aria-label="Default select example">
                                            <option value="{{ $client->state_id }}|{{ $client->state }}" selected>
                                                {{ $client->state }}
                                            </option>
                                            @foreach($states as $state)
                                                <option 
                                                    value="{{ $state->idnegeri }}|{{ $state->negeri }}" 
                                                    {{ ($state->idnegeri == $client->state_id) ? 'selected' : '' }}>
                                                    {{ $state->negeri }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    

                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city" id="city" class="form-control" 
                                            value="{{ old('city', $client->city) }}" required>
                                        @if ($errors->has('city'))
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="landline">Telephone No.(P)</label>
                                        <input type="text" name="landline" id="landline" class="form-control" 
                                            value="{{ old('landline', $client->landline) }}" required>
                                        @if ($errors->has('landline'))
                                            <span class="text-danger">{{ $errors->first('landline') }}</span>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" name="email" id="email" class="form-control" 
                                            value="{{ old('email', $client->email) }}" required>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="idCardNumber">Identification Card Number</label>
                                        <input type="text" name="idCardNumber" id="idCardNumber" class="form-control" 
                                            value="{{ old('idCardNumber', $client->idCardNumber) }}" required>
                                        @if ($errors->has('idCardNumber'))
                                            <span class="text-danger">{{ $errors->first('idCardNumber') }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <select class="form-select form-group" name="district" aria-label="Default select example">
                                            <option value="{{ $client->district_id }}|{{ $client->district }}" selected>
                                                {{ $client->district }}
                                            </option>
                                            @foreach($districts as $district)
                                                <option 
                                                    value="{{ $district->iddaerah }}|{{ $district->daerah }}" 
                                                    {{ ($district->iddaerah == $client->district_id) ? 'selected' : '' }}>
                                                    {{ $district->daerah }}
                                                </option>
                                            @endforeach                                            
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="mobileNumber">Email address</label>
                                        <input type="text" name="mobileNumber" id="mobileNumber" class="form-control" 
                                            value="{{ old('mobileNumber', $client->mobileNumber) }}" required>
                                        @if ($errors->has('mobileNumber'))
                                            <span class="text-danger">{{ $errors->first('mobileNumber') }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="mobileNumber">Mobile Number</label>
                                        <input type="text" name="mobileNumber" id="mobileNumber" class="form-control" 
                                            value="{{ old('mobileNumber', $client->mobileNumber) }}" required>
                                        @if ($errors->has('mobileNumber'))
                                            <span class="text-danger">{{ $errors->first('mobileNumber') }}</span>
                                        @endif
                                    </div>


                                    <button type="submit" class="btn btn-primary">
                                        Update Profile
                                    </button>
                                </div>
                           </div>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



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

    // Reset the form when the reset button is clicked
    $('#resetButton').on('click', function () {
        $('#registrationForm')[0].reset(); // Reset form fields
        $('#responseMessage').hide(); // Hide the success/error message
        $('#resetButton').prop('disabled', true); // Disable the reset button after reset
    });

    // Handle form submission with AJAX
    $('#registrationForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "{{ route('client_register') }}", // Replace with your route
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Show SweetAlert Success
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        $('#registrationForm')[0].reset(); // Reset form after submission
                        $('#resetButton').prop('disabled', true); // Disable reset button
                        window.location.href = "{{ route('client_login') }}"; // Replace 'your_route_name' with your desired route
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $("#" + key).text(value[0]); // Display validation errors
                    });

                    // Show SweetAlert Error
                    Swal.fire({
                        title: "Validation Error",
                        text: "Please fillup the required fields.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                } else {
                    // Show SweetAlert for unexpected error
                    Swal.fire({
                        title: "Error!",
                        text: "An unexpected error occurred. Please try again.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
        });
    });
});

</script>


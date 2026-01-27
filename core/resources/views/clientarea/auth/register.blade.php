<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{get_company_name()}} | {{trans('app.register')}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{image_url('favicon.png')}}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('assets/js/jquery-3.6.4.min.js') }}"></script>
   
    <script>
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    </script>
    
    <style>
    body{
        overflow-x:hidden;
        font-family: 'Poppins', serif;
        font-size: 16px;
    }
     

    h1, h2, h3, h4, h5, h6 {
    font-family: 'Poppins' , sans-serif;
    font-weight: 400;
    margin: 5px 0;
}
        .header{
    background-color: #81C3F6;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
        }
        .logo{
             height: 100px;
        }
        .star{
            color: red;
        }
        .inlin{
            display: flex;
            flex-direction: row;
            justify-content: normal;
        }
        .form-control{
            /*background-color: #BADEFA;*/
            border-radius: 5px;
            border: none;
            padding: 3px
        }
        .accordion-button{
    color: white;
    background: blue;
}


   .header-1,
    .header-2,
     .header-3,
     .header-4,
     .header-5,
     .header-6,
     .header-7,
     .header-8
    {    color: black;
        border-radius: 15px;
        padding: 10px 15px;
}
.header-1 {
    background-color: #FEFDC2; /* Light red */
   
}

.header-2 {
    background-color: #C4DDC7; /* Light green */
   
}

.header-3 {
    background-color: #F2DBF9; /* Light blue */
   
}
.header-4 {
    background-color: #FFE4D3; /* Light blue */
    
}
.header-5 {
    background-color: #e7bcf4; /* Light blue */
    
}
.header-6 {
    background-color: #FFE4D3; /* Light blue */
   
}


/* Optional: Ensure text is properly visible */
.accordion-button {
    border: none;
    font-weight: bold;
}

.g-recaptcha {
    min-height: 78px; /* Minimum height for reCAPTCHA */
    overflow: hidden; /* Prevent layout issues */
}

/* Ensure iframe is visible */
.g-recaptcha iframe {
    width: 100% !important;
    height: 78px !important;
}

/* Fix for potential parent element issues */
.form.p-4.rounded-3 {
    overflow: visible;
}

label {
    font-weight: 500;
}
.ckBox{
    font-weight: 400;
}
.btn1, .btn2, .btn3{
border-radius: 20px;
border: none;
padding: 4px 25px;
}
/* .btn1{
background-color: #C4DDC7;
} */
.btn2{
background-color: #BADEFA;
}
.btn3{
background-color: red;
}
.lists{
        background-color: #BADEFA;
        border-radius: 15px;
}
.dropdown-menu, .dropdown-toggle{
     background-color: #BADEFA;
        border-radius: 15px;
        border: none;
}
/* .dropdown-toggle{
    width: 270px;
    padding: 3px 15px;
    text-align: left;
       
} */
@media screen and (min-width: 678px) {
  .dropdown-toggle{
    width: 235px;
    padding: 3px 15px;
    text-align: left;
       
}
}

.dott {
    font-weight: 900;
}

/*.accordion-body{background: aliceblue;}*/
.form-control {
    width: 305px !important;
    -webkit-appearance: listbox !important; /* WebKit browsers (Chrome, Safari) */
    appearance: listbox !important;         /* Standard property for other browsers */
    border: 1px solid #1991EE;
}

.header {
    background-color: #81C3F6;
    display: flex; /* Flexbox for horizontal layout */
    align-items: center; /* Vertical alignment */
    padding: 10px 20px;
}

.logo {
    max-height: 80px; /* Restrict logo height */
    width: auto; /* Maintain aspect ratio */
    margin-right: 15px; /* Space between image and text */
}

.text-container {
    color: white; /* Ensure text color contrasts with the background */
    text-align: left; /* Align text to the left */
    padding: 15px 0px;
}

.text-container h4 {
    margin: 0; /* Remove default margin */
    line-height: 1.2; /* Adjust line spacing */
}

/* Adjust logo size and alignment */
/* Logo size */
.logo {
    max-height: 100px;
    width: 80%;
    margin: 0;
}

/* Center the text */
.navbar .text-container h3 {
    margin: 0;
    line-height: 1.2;
    font-size: 1.5rem; /* Adjust size as needed */
}

/* Responsive adjustments for smaller screens */
@media (max-width: 768px) {
    .navbar .text-container h3 {
        font-size: 1.2rem;
    }
}
.important-font{
    font-size: 13px;
}
.text-dangerr{
    display: flex;
    justify-content: end;
    font-size: 13px;
    color: #ff0010;
}
.password-errors{
     display: flex;
    justify-content: end;
    font-size: 13px;
    color: #ff0010 !important;
}

.password-match-errors{
    display: flex;
    justify-content: end;
    font-size: 13px;
    color: #ff0010 !important;
}
.password-validation {
    display: none;
    position: absolute;
    background: white;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 250px;
    z-index: 1000;
    font-size: 14px;
    left: 90px;
}

.password-validation ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.password-validation li {
    padding: 3px 0;
}

.valid {
    color: green;
}

.invalid {
    color: red;
}
/* Style the eye icon properly */
.toggle-password {
    position: absolute !important;
    top: 16px !important;
    right: 1rem !important;
    transform: translateY(-50%) !important;
    color: #6c757d !important;
    font-size: 1.1rem !important;
    cursor: pointer !important;
}

    .form-group {
        display: flex;
        align-items: flex-start;
    }

@media screen and (max-width: 488px) {
        .btn1, .btn2, .btn3{
        padding: 4px 12px;
        }
  
  .large-screen{
      visibility: hidden;
  }
}


@media screen and (min-width: 489px) {
  .mobile-only {
          visibility: hidden;
    }
}

    </style>
</head>
<body>

<!-- Header -->
<!-- Navbar Header -->
<nav class="navbar navbar-expand-lg" style="background-color: #1991EE !important;">
    <div class="container-fluid">
        <div class="row w-100 align-items-center">
            <!-- Logo -->
            <div class="col-md-2 col-4 pe-0 icon-text text-center ">
                <a href="{{url('/')}}">
                    @if(get_setting_value('logo') != '')
                    <img src="{{ image_url(get_setting_value('logo')) }}" 
                        alt="Logo" 
                        style="max-height: 93px; width: auto; object-fit: contain;">
                    @else
                        <img src="{{ asset('assets/images/selangor.png') }}" 
                            alt="Logo" 
                            style="max-height: 60px; width: auto; object-fit: contain;">
                    @endif
                </a>
            </div>
            <!-- Text Container style="padding: 0px 175px;" -->
            <div class="col-md-9 col-9 text-left text-light" >
                <div>
                    <h2 class="mb-0">Portal e-CP (Caruman Parit)</h2>
                    <h3 class="mb-0">JPS Negeri Selangor</h3>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Body -->
<div class="container mb-5">
    <div class="row">
        <div class="col-md-12">
            <!-- <h4 class="mt-2">User Registration</h4> -->
            <h4 class="mt-2">@lang('app.user_registration')</h4>
            <div class="border rounded ps-2 pe-5 mb-3">
                <span class="d-inline">
                   <i class="bi bi-exclamation-triangle" style="color: red; font-size: x-large;"> </i> @lang('app.instructions') : 
                   <p class="d-inline float-end mt-2">  <span class="star"> * </span>@lang('app.mandatory_fields')</p>
                </span>         
                <p class="mb-0">1) @lang('Sila isi dan lengkapkan borang pendaftaran pengguna yang berikut.')</p>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-12">
        <form class="form p-4 rounded-3" method="post" enctype="multipart/form-data" id="registrationForm">
            @csrf
            <div class="accordion" id="accordionExample">

                <!-- Account Information Section -->
                <div class="accordion-item border-0">
                    <h2 class="accordion-header rounded">
                        <button class="accordion-button header-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            @lang('app.account_information')
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                        <div class="accordion-body">
                            <!-- Account Type -->
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="state">@lang('app.account_type')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>             
                                        <select class="form-control" name="accountType">
                                            <option value="" selected disabled>@lang('--Sila Pilih--')</option>
                                            @foreach($accountTypes as $type)
                                            <option value="{{ $type->id }}">
                                                {{ $type->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-dangerr" id="accountType"></span>
                                </div>
                            </div>
                            <!-- Email Address -->
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="emailAddress">@lang('app.email_address')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <input type="text" class="form-control rounded-3" id="emailAddress" type="email" name="email">
                                    </div>
                                    <span id="email-error" class="text-dangerr"></span>
                                </div>
                                <div class="col-md-5 d-inline">
                                    <span class="star d-inline"><b>*</b></span>
                                    <span class="star d-inline important-font" style="color: grey;"><i>@lang('Alamat emel akan digunakan sebagai ID Pengguna')</i></span>
                                </div>
                            </div>
                            <!-- Password -->
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="password">@lang('app.password')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6 position-relative">
                                            <div class="form-group inlin">
                                                <span class="pe-3"><b> : </b></span>
                                                <input type="password" id="password" class="form-control rounded-3 pe-5" name="password" value="{{ old('password') }}" onkeyup="validatePassword()">
                                                <i class="bi bi-eye-slash toggle-password position-absolute end-0 top-50 translate-middle-y me-3 text-muted cursor-pointer" data-target="password"></i>
                                            </div>
                                            <span class="text-danger password-errors" id="password-error"></span>
                                    
                                            <!-- Password Validation Box -->
                                            <div id="password-validation" class="password-validation">
                                                <p>@lang('app.must_contain')</p>
                                                <ul>
                                                    <li id="length" style="color: red;">❌ {{ trans('app.password_minimum') }} 8 {{ trans('app.too') }} 20 {{ trans('app.characters') }}</li>
                                                    <li id="uppercase" style="color: red;">❌ {{ trans('app.uppercase_letter') }} (A-Z)</li>
                                                    <li id="lowercase" style="color: red;">❌ {{ trans('app.lowercase_letter') }} (a-z)</li>
                                                    <li id="number" style="color: red;">❌ {{ trans('app.number') }} (0-9)</li>
                                                    <li id="noSpaces" style="color: red;">❌ {{ trans('app.no_spaces') }}</li>
                                                    <li id="special" style="color: red;">❌ {{ trans('app.special_character') }} (!@#$%_)</li>
                                                    <li id="noSequential" style="color: red;">❌ {{ trans('app.no_sequential_characters') }} (abc, 123)</li>
                                                </ul>
                                            </div>
                                        </div>
                                <div class="col-md-5"></div>
                            </div>
                                <div class="row mt-4">
                                        <div class="col-md-3 col-6">
                                            <div class="form-group">
                                                <label for="confirmPassword">@lang('app.set_password')</label>
                                                <span class="star">*</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6 position-relative">
                                            <div class="form-group inlin">
                                                <span class="pe-3"><b> : </b></span>
                                                <input type="password" 
                                                    id="setPassword" 
                                                    class="form-control rounded-3 pe-5" 
                                                    name="setPassword" 
                                                    value="{{ old('setPassword') }}" 
                                                    onblur="matchPasswords()"
                                                    oninput="clearMatchError()">
                                                <i class="bi bi-eye-slash toggle-password position-absolute end-0 top-50 translate-middle-y me-3 text-muted cursor-pointer" data-target="setPassword"></i>
                                            </div>
                                            <span class="text-danger password-match-errors" id="password-match-error" style="padding: 0px;"></span>
                                        </div>
                                        <div class="col-md-5">
                                            <span class="star d-inline"><b></b></span>
                                            <!-- <span class="star d-inline important-font"><i>@lang('Sila masukkan kata laluan sekali lagi untuk tujuan pengesahan')</i></span> -->
                                        </div>
                                </div>
                        </div>
                    </div>
                </div>

                <!-- User Information Section -->
                <div class="accordion-item border-0 mt-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button header-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            @lang('app.user_information')
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo">
                        <div class="accordion-body">
                            <!-- Username -->
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="userName">@lang('app.username')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <input type="text" class="form-control" name="userName" value="{{old('userName')}}">
                                    </div>
                                    <span id="userName-error" class="text-dangerr"></span>
                                </div>
                                <div class="col-md-5">
                                    <span class="star d-inline"><b>*</b></span>
                                    <span class="star d-inline important-font" style="color: grey;"><i>@lang('Masukkan nama seperti di dalam Kad Pengenalan')</i></span>
                                </div>
                            </div>
                
                            <div class="row mt-4">
                                        <div class="col-md-3 col-6">
                                            <div class="form-group">
                                                <label for="idTypeNumber">Jenis/Nombor Pengenalan</label>
                                                <span class="star">*</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-group">
                                                <span class="pe-3"><b> : </b></span>
                                                <div class="d-flex flex-column gap-2">
                                                    <select class="form-control" name="idType" id="idTypes">
                                                        <option value="">@lang('--Sila Pilih--')</option>
                                                        <option value="1">Kad Pengenalan Baru</option>
                                                        <option value="2">Kad Pengenalan Lama</option>
                                                        <option value="3">No. Polis</option>
                                                        <option value="4">No. Tentera</option>
                                                    </select>

                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        name="idCardNumber" 
                                                        id="idCardNumber"
                                                        value="{{ old('idCardNumber') }}" 
                                                        maxlength="14"
                                                        placeholder="">
                                                </div>
                                            </div>
                                             <span class="text-dangerr" id="idCardNumberError"></span>
                                        </div>
                                    </div>

                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="registeredAddress">@lang('app.registered_address')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <textarea class="form-control" name="registeredAddress" rows="3">{{old('registeredAddress')}}</textarea>
                                    </div>
                                    <span class="text-dangerr" id="registeredAddress"></span>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="postalCode">@lang('app.postal_code')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <input type="text" class="form-control" name="postalCode" value="{{old('postalCode')}}">
                                    </div>
                                    <div class="text-dangerr" id="postalCode"></div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="state">@lang('app.state')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <select class="form-control" id="negeri" name="state">
                                            <option value="" selected disabled>@lang('--Sila Pilih--')</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->idnegeri}}">{{ $state->negeri_code }} - {{ $state->negeri }}</option>
                                            @endforeach
                                        </select>                                         
                                    </div>
                                    <div class="text-dangerr" id="state"></div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="state">@lang('app.district')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        
                                        <select class="form-control" id="daerah" name="district">
                                            <option value="" selected disabled>@lang('--Sila Pilih--')</option>
                                        </select>
                                    </div>
                                    <div class="text-dangerr" id="district"></div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="city">@lang('app.city')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <input type="text" class="form-control" name="city" value="{{old('city')}}">
                                    </div>
                                    <div class="text-dangerr" id="city"></div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="mobileNumber">@lang('app.mobile_number')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <input type="tel" class="form-control" name="mobileNumber" value="{{old('mobileNumber')}}" maxlength="12">                                               
                                    </div>
                                    <span id="mobileNumber-error" class="text-dangerr text-end"></span>
                                </div>
                                <div class="col-md-5">
                                    <span class="star d-inline"><b></b></span>
                                    <span class="star d-inline important-font" style="color: grey;"><i>@lang('Cth: 012345678')</i></span>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="landline">@lang('app.telephone_no') (P)</label>
                                        <span class="star"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <input type="tel" class="form-control" name="landline" value="{{old('landline')}}">
                                    </div>
                                    <span id="landline-error" class="text-dangerr"></span>
                                </div>
                                <div class="col-md-5">
                                    <span class="star d-inline important-font" style="color: grey;"><i>@lang('Cth: 035678901')</i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>             
                
                <!-- Confirmation Section -->
                <div class="accordion-item border-0 mt-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button header-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                            @lang('app.confirmation')
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <label for="terms">
                                            <input type="checkbox" id="terms" name="terms" value="1">
                                             @lang('app.terms_and_conditions')
                                        </label>
                                    </div>
                                </div>
                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <span class="text-dangerr">{{ $errors->first('terms') }}</span> --}}
                                </div>
                                <div class="col-md-12 d-inline text-end large-screen">
                                    <button type="submit" class="btn btn-success btn1 " id="submitButton">@lang('app.register')</button>
                                    <button type="button" id="resetButton" class="btn btn-primary btn2 ms-4" disabled>@lang('app.reset')</button>
                                    <button type="button" class="btn btn-secondary btn3 ms-4" onclick="window.location='{{ route('client_login') }}'">@lang('app.get_out')</button>
                                </div>
                                <div class="col-md-12 d-inline text-end mobile-only px-0">
                                    <button type="submit" class="btn btn-success btn1 btn-sm" id="submitButton">@lang('app.register')</button>
                                    <button type="button" id="resetButton" class="btn btn-primary btn2 btn-sm" disabled>@lang('app.reset')</button>
                                    <button type="button" class="btn btn-secondary btn3 btn-sm" onclick="window.location='{{ route('client_login') }}'">@lang('app.get_out')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 
              <br/>
              <!--<input type="submit" value="Submit">-->
                
            </div>
        </form>    
    </div>
    <div id="responseMessage" style="display: none;"></div>
</div>
<!-- At the end of your body -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
// ============================================
// WINDOW ROUTES CONFIGURATION
// ============================================
window.appRoutes = {
    otpVerification: "{{ route('otp.verification') }}",
    clientLogin: "{{ route('client_login') }}"
};

// ============================================
// AJAX SETUP - CSRF TOKEN
// ============================================
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// Global flag to prevent multiple submissions
let isSubmitting = false;

// ============================================
// PASSWORD VALIDATION (Vanilla JavaScript)
// ============================================
document.addEventListener("DOMContentLoaded", function() {
    let passwordInput = document.getElementById("password");
    let confirmPasswordInput = document.getElementById("setPassword");
    let validationBox = document.getElementById("password-validation");

    if (!passwordInput || !confirmPasswordInput || !validationBox) return;

    passwordInput.addEventListener("focus", function() {
        validationBox.style.display = "block";
    });

    document.addEventListener("click", function(event) {
        if (!passwordInput.contains(event.target) && !validationBox.contains(event.target)) {
            validationBox.style.display = "none";
        }
    });

    passwordInput.addEventListener("input", function() {
        validationBox.style.display = "block";
        validatePassword();
    });

    passwordInput.addEventListener("input", matchPasswords);
    confirmPasswordInput.addEventListener("input", matchPasswords);
});

function validatePassword() {
    let password = document.getElementById("password").value;
    let validationBox = document.getElementById("password-validation");
    
    if (password) {
        document.getElementById("password-error").textContent = "";
    }
    
    let checks = {
        length: password.length >= 8 && password.length <= 20,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /[0-9]/.test(password),
        noSpaces: !/\s/.test(password),
        specialChar: /[!@#$%_]/.test(password),
        noSequential: !/(?:012|123|234|345|456|567|678|789|abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz)/i.test(password),
    };

    // Update UI with colors
    document.getElementById("length").innerHTML = (checks.length ? "✅" : "❌") + " {{ trans('app.password_minimum') }} 8 {{ trans('app.too') }} 20 {{ trans('app.characters') }}";
    document.getElementById("length").style.color = checks.length ? "green" : "red";
    
    document.getElementById("uppercase").innerHTML = (checks.uppercase ? "✅" : "❌") + " {{ trans('app.uppercase_letter') }} (A-Z)";
    document.getElementById("uppercase").style.color = checks.uppercase ? "green" : "red";
    
    document.getElementById("lowercase").innerHTML = (checks.lowercase ? "✅" : "❌") + " {{ trans('app.lowercase_letter') }} (a-z)";
    document.getElementById("lowercase").style.color = checks.lowercase ? "green" : "red";
    
    document.getElementById("number").innerHTML = (checks.number ? "✅" : "❌") + " {{ trans('app.number') }} (0-9)";
    document.getElementById("number").style.color = checks.number ? "green" : "red";
    
    document.getElementById("noSpaces").innerHTML = (checks.noSpaces ? "✅" : "❌") + " {{ trans('app.no_spaces') }}";
    document.getElementById("noSpaces").style.color = checks.noSpaces ? "green" : "red";
    
    document.getElementById("special").innerHTML = (checks.specialChar ? "✅" : "❌") + " {{ trans('app.special_character') }} (!@#$%_)";
    document.getElementById("special").style.color = checks.specialChar ? "green" : "red";
    
    document.getElementById("noSequential").innerHTML = (checks.noSequential ? "✅" : "❌") + " {{ trans('app.no_sequential_characters') }} (abc, 123)";
    document.getElementById("noSequential").style.color = checks.noSequential ? "green" : "red";

    // Keep validation box visible if password has value and not all checks pass
    let allValid = Object.values(checks).every(check => check === true);
    if (password && !allValid && validationBox) {
        validationBox.style.display = "block";
    }

    // Return true if all checks pass
    return allValid;
}

function clearMatchError() {
    let matchError = document.getElementById("password-match-error");
    matchError.innerHTML = "";
}

function matchPasswords() {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("setPassword").value;
    let matchError = document.getElementById("password-match-error");

    // If confirm password is empty, clear any messages
    if (confirmPassword === "") {
        matchError.innerHTML = "";
        return false;
    }
    
    // Validate passwords
    if (password !== confirmPassword) {
        matchError.innerHTML = "❌ {{ trans('Kata Laluan Tidak Sepadan') }}";
        matchError.style.color = "red";
        return false;
    } else if (password === confirmPassword && password !== "") {
        matchError.innerHTML = "✅ {{ trans('app.passwords_match') }}";
        matchError.style.color = "green";
        
        // Show warning if passwords match but requirements aren't met
        let allValid = validatePassword();
        if (!allValid) {
            let passwordError = document.getElementById("password-error");
            if (passwordError) {
                passwordError.textContent = "⚠️ Kata laluan tidak memenuhi semua keperluan.";
                passwordError.style.color = "orange";
                passwordError.style.display = "block";
            }
        }
        return true;
    }
    
    return false;
}

// ============================================
// ACCOUNT TYPE & ID CARD FORMATTING
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const accountTypeSelect = document.querySelector('select[name="accountType"]');
    const userInfoButton = document.querySelector('button[data-bs-target="#collapseTwo"]');
    const userNameLabel = document.querySelector('label[for="userName"]');
    const idCardLabel = document.querySelector('label[for="idTypeNumber"]');
    const userNameHintDiv = document.querySelector('label[for="userName"]')?.closest('.row')?.querySelector('.col-md-5');
    const idTypeSelect = document.getElementById('idTypes');
    const idCardInput = document.getElementById('idCardNumber');
    const idCardStar = idCardLabel?.nextElementSibling;

    if (!accountTypeSelect || !userInfoButton || !idTypeSelect) {
        console.error('Required elements not found');
        return;
    }

    // Store original ID type options to restore later
    const originalIdTypeOptions = idTypeSelect.innerHTML;

    const originalTexts = {
        sectionHeader: userInfoButton.innerText.trim(),
        userName: userNameLabel?.innerText.trim() || '',
        idCard: idCardLabel?.innerText.trim() || ''
    };

    function formatIdCard(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 0) {
            if (value.length <= 6) {
                input.value = value;
            } else if (value.length <= 8) {
                input.value = value.slice(0, 6) + '-' + value.slice(6);
            } else {
                input.value = value.slice(0, 6) + '-' + value.slice(6, 8) + '-' + value.slice(8, 12);
            }
        }
    }

    function handleInput(e) {
        formatIdCard(e.target);
    }

    // Handle ID Type Selection (define once, outside)
    function handleIdTypeChange() {
        if (!idCardInput) return;
        
        const idType = idTypeSelect.value;
        
        if (idType === '1') {
            // Kad Pengenalan Baru
            idCardInput.placeholder = "______-__-____";
            idCardInput.maxLength = 14;
            idCardInput.value = '';
            idCardInput.removeEventListener('input', handleInput);
            idCardInput.addEventListener('input', handleInput);
        } else if (idType === '2') {
            // Kad Pengenalan Lama
            idCardInput.placeholder = "";
            idCardInput.maxLength = 20;
            idCardInput.value = '';
            idCardInput.removeEventListener('input', handleInput);
        } else if (idType === '3') {
            // No. Polis
            idCardInput.placeholder = "";
            idCardInput.maxLength = 20;
            idCardInput.value = '';
            idCardInput.removeEventListener('input', handleInput);
        } else if (idType === '4') {
            // No. Tentera
            idCardInput.placeholder = "";
            idCardInput.maxLength = 20;
            idCardInput.value = '';
            idCardInput.removeEventListener('input', handleInput);
        } else {
            idCardInput.placeholder = "";
            idCardInput.value = '';
            idCardInput.removeEventListener('input', handleInput);
        }
    }

    // Attach ID type change listener once
    idTypeSelect.addEventListener('change', handleIdTypeChange);

    // Handle Account Type Change
    accountTypeSelect.addEventListener('change', function() {
        const selectedAccountTypeId = parseInt(this.value);
        
        // Get the parent row of the ID card field
        const idCardRow = document.querySelector('#idCardNumber').closest('.row');

        if (selectedAccountTypeId === 2 || selectedAccountTypeId === 3 || selectedAccountTypeId === 4) {
            // Set button text based on account type
            if (selectedAccountTypeId === 3) {
                userInfoButton.innerText = "Maklumat Syarikat / Agensi Kerajaan";
            } else {
                userInfoButton.innerText = "Maklumat Syarikat";
            }
            
            // Set userName label based on account type
            if (userNameLabel) {
                if (selectedAccountTypeId === 3) {
                    userNameLabel.innerText = "Nama Syarikat / Agensi Kerajaan";
                } else {
                    userNameLabel.innerText = "Nama Syarikat";
                }
            }
            
            if (idCardLabel) idCardLabel.innerText = "No Pendaftaran Syarikat";
            if (userNameHintDiv) userNameHintDiv.style.display = 'none';
            
            // Hide the dropdown completely for company
            idTypeSelect.style.display = 'none';
            idTypeSelect.value = '';
            
            // Handle ID card field visibility
            if (selectedAccountTypeId === 3) {
                // Hide the entire row for account type 3
                if (idCardRow) idCardRow.style.display = 'none';
            } else {
                // Show the row but configure for account types 2 and 4
                if (idCardRow) idCardRow.style.display = 'flex';
                if (idCardStar) idCardStar.style.display = 'inline';
                if (idCardInput) {
                    idCardInput.style.display = 'block';
                    idCardInput.placeholder = "";
                    idCardInput.removeEventListener('input', handleInput);
                    idCardInput.value = '';
                    idCardInput.maxLength = 50;
                    idCardInput.style.setProperty('width', '300px', 'important');
                }
                if (idCardLabel) idCardLabel.style.display = 'block';
            }
            
        } else if (selectedAccountTypeId === 1) {
            // Account Type 1 - Show "Jenis/Nombor Pengenaian"
            userInfoButton.innerText = originalTexts.sectionHeader;
            if (userNameLabel) userNameLabel.innerText = originalTexts.userName;
            if (idCardLabel) {
                idCardLabel.innerText = "Jenis/Nombor Pengenalan";
                idCardLabel.style.display = 'block';
            }
            if (userNameHintDiv) userNameHintDiv.style.display = '';
            
            // Show the entire row
            if (idCardRow) idCardRow.style.display = 'flex';
            
            // Restore ID Type dropdown with original options
            idTypeSelect.innerHTML = originalIdTypeOptions;
            idTypeSelect.style.display = 'block';
            idTypeSelect.style.visibility = 'visible';
            idTypeSelect.value = '';
            
            // Show asterisk and input for account type 1
            if (idCardStar) idCardStar.style.display = 'inline';
            
            if (idCardInput) {
                idCardInput.style.display = 'block';
                idCardInput.placeholder = "";
                idCardInput.value = '';
                idCardInput.maxLength = 14;
                idCardInput.removeEventListener('input', handleInput);
            }
        } else {
            // Individual Type - Restore everything (for other account types)
            userInfoButton.innerText = originalTexts.sectionHeader;
            if (userNameLabel) userNameLabel.innerText = originalTexts.userName;
            if (idCardLabel) {
                idCardLabel.innerText = originalTexts.idCard;
                idCardLabel.style.display = 'block';
            }
            if (userNameHintDiv) userNameHintDiv.style.display = '';
            
            // Show the entire row
            if (idCardRow) idCardRow.style.display = 'flex';
            
            // Restore ID Type dropdown with original options
            idTypeSelect.innerHTML = originalIdTypeOptions;
            idTypeSelect.style.display = 'block';
            idTypeSelect.style.visibility = 'visible';
            idTypeSelect.value = '';
            
            if (idCardStar) idCardStar.style.display = 'inline';
            
            if (idCardInput) {
                idCardInput.style.display = 'block';
                idCardInput.placeholder = "";
                idCardInput.value = '';
                idCardInput.maxLength = 14;
                idCardInput.removeEventListener('input', handleInput);
            }
        }
    });
});

// ============================================
// MAIN JQUERY READY - ALL FORM LOGIC
// ============================================
$(document).ready(function () {
    
    // Password Toggle Visibility
    $('.toggle-password').on('click', function() {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        $(this).toggleClass('bi-eye bi-eye-slash');
    });
    
    // District Loading (State Dropdown)
    $('#negeri').on('change', function () {
        const stateId = $(this).val();
        const selectedOption = $(this).find('option:selected');
        const stateCode = selectedOption.text().split(' - ')[0].trim();
        
        if (['14', '15', '16'].includes(stateCode)) {
            $('#daerah').closest('.row').hide();
            $('#daerah').val('').prop('required', false);
        } else {
            $('#daerah').closest('.row').show();
            $('#daerah').prop('required', true);
            $('#daerah').html('<option value="">Loading...</option>');

            if (stateId) {
                $.ajax({
                    url: `/clientarea/register-districts/${stateId}`,
                    type: 'GET',
                    success: function (data) {
                        let options = '<option value="">Sila Pilih Daerah</option>';
                        data.forEach(district => {
                            options += `<option value="${district.iddaerah}">${district.daerah_code + ' - ' + district.daerah}</option>`;
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
        }
    });

    // Mobile Number Validation (Real-time)
    $('input[name="mobileNumber"]').on('input', function(e) {
        let value = $(this).val().replace(/[^0-9]/g, '');
        if (value.length > 12) value = value.substring(0, 12);
        $(this).val(value);
        
        $('#mobileNumber-error').removeClass('text-info text-success').addClass('text-dangerr');
        $(this).removeClass('border-danger border-success');
        
        if (value.length > 0 && value.length < 10) {
            $('#mobileNumber-error').text(`${value.length}/10 digits minimum`).removeClass('text-dangerr').addClass('text-info').show();
        } else if (value.length >= 10 && value.length <= 12) {
            $('#mobileNumber-error').text('✓ Valid mobile number').removeClass('text-dangerr text-info').addClass('text-success').show();
            $(this).addClass('border-success');
        } else if (value.length === 0) {
            $('#mobileNumber-error').text('').hide();
            $(this).removeClass('border-success border-danger');
        }
    });

    $('input[name="mobileNumber"]').on('blur', function() {
        const mobileValue = $(this).val().trim();
        const errorElement = $('#mobileNumber-error');
        
        $(this).removeClass('border-success');
        errorElement.removeClass('text-info text-success').addClass('text-dangerr');
        
        if (!mobileValue) {
            errorElement.text('Nombor Telefon Bimbit diperlukan').show();
            $(this).addClass('border-danger');
        } else if (!/^[0-9]{10,12}$/.test(mobileValue)) {
            errorElement.text('Nombor telefon bimbit mesti antara 10 hingga 12 digit').show();
            $(this).addClass('border-danger');
        } else {
            errorElement.text('').hide();
            $(this).removeClass('border-danger').addClass('border-success');
        }
    });

    $('input[name="mobileNumber"]').on('focus', function() {
        $(this).removeClass('border-danger');
        const errorElement = $('#mobileNumber-error');
        if (errorElement.hasClass('text-dangerr') && errorElement.is(':visible')) {
            errorElement.text('').hide();
        }
    });

    $('input[name="mobileNumber"]').on('keypress', function(e) {
        // Allow: backspace, delete, tab, escape, enter
        if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
            // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && e.ctrlKey === true) ||
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true)) {
            return;
        }
        
        // Ensure that it is a number and stop the keypress if not
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
        
        // Stop input if length is already 12
        if ($(this).val().length >= 12) {
            e.preventDefault();
        }
    });

    // Real-time Field Validation (AJAX)
    function validateField(fieldName, fieldValue) {
        $.ajax({
            url: "{{ route('validate.field') }}",
            type: "POST",
            data: {
                field: fieldName,
                value: fieldValue,
                _token: "{{ csrf_token() }}",
            },
            success: function (response) {
                let errorSpan = $("#" + fieldName + "-error");
                if (!response.valid) {
                    errorSpan.text(response.message).show();
                } else {
                    errorSpan.text("").hide();
                }
            },
            error: function () {
                console.error("Validation error occurred.");
            },
        });
    }

    $("input[name='email'], input[name='mobileNumber'], input[name='landline']").on('blur', function () {
        let fieldName = $(this).attr("name");
        let fieldValue = $(this).val();
        if (fieldValue) {
            validateField(fieldName, fieldValue);
        }
    });

    // Client-side Form Validation
    function validateForm() {
        let isValid = true;
        $('.text-dangerr').text('');
        $('.form-control, .form-select').removeClass('border-danger');
        
        if (!$('select[name="accountType"]').val()) {
            $('#accountType').text('Jenis akaun diperlukan');
            isValid = false;
        }
        
        if (!$('input[name="email"]').val()) {
            $('#email-error').text('E-mel diperlukan');
            isValid = false;
        }
        
        let password = $('#password').val();
        if (!password) {
            $('#password-error').text('Kata laluan diperlukan');
            isValid = false;
        } else {
            // Check all password requirements
            let checks = {
                length: password.length >= 8 && password.length <= 20,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                noSpaces: !/\s/.test(password),
                specialChar: /[!@#$%_]/.test(password),
                noSequential: !/(?:012|123|234|345|456|567|678|789|abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz)/i.test(password),
            };
            
            let allValid = Object.values(checks).every(check => check === true);
            
            if (!allValid) {
                $('#password-error').text('⚠️ Sila penuhi semua keperluan kata laluan').css('color', 'orange');
                isValid = false;
            }
        }
        
        if (!$('#setPassword').val()) {
            $('#password-match-error').text('Sahkan kata laluan diperlukan');
            isValid = false;
        } else if ($('#password').val() !== $('#setPassword').val()) {
            $('#password-match-error').text('Kata laluan tidak sepadan');
            isValid = false;
        }
        
        if (!$('input[name="userName"]').val()) {
            const selectedAccountType = parseInt($('select[name="accountType"]').val());
            if (selectedAccountType === 2 || selectedAccountType === 3 || selectedAccountType === 4) {
                $('#userName-error').text('Nama Syarikat diperlukan');
            } else {
                $('#userName-error').text('Nama pengguna diperlukan');
            }
            isValid = false;
        }
        
        const selectedAccountType = parseInt($('select[name="accountType"]').val());

        if (selectedAccountType !== 3) { 
            if (!$('input[name="idCardNumber"]').val()) {
                if (selectedAccountType === 2 || selectedAccountType === 4) {
                    $('#idCardNumberError').text('No Pendaftaran Syarikat diperlukan');
                } else if(selectedAccountType === 1){
                    $('#idCardNumberError').text('Jenis/Nombor Pengenalan diperlukan');
                }
                else {
                    $('#idCardNumberError').text('Jenis/Nombor Pengenalan diperlukan');
                }
                isValid = false;
            } else {
                $('#idCardNumberError').text(''); 
            }
        } else {
            $('#idCardNumberError').text(''); 
        }

        
        if (!$('textarea[name="registeredAddress"]').val()) {
            $('#registeredAddress').text('Alamat Berdaftar diperlukan');
            isValid = false;
        }
        
        if (!$('input[name="postalCode"]').val()) {
            $('#postalCode').text('Poskod diperlukan');
            isValid = false;
        }
        
        if (!$('select[name="state"]').val()) {
            $('#state').text('Negeri diperlukan');
            isValid = false;
        }
        
        const selectedOption = $('#negeri').find('option:selected');
        const stateCode = selectedOption.text().split(' - ')[0].trim();
        const isDistrictRequired = !['14', '15', '16'].includes(stateCode);
    
        if (isDistrictRequired && !$('select[name="district"]').val()) {
            $('#district').text('Daerah diperlukan');
            isValid = false;
        }
        
        if (!$('input[name="city"]').val()) {
            $('#city').text('Bandar diperlukan');
            isValid = false;
        }
        
        const mobileNumber = $('input[name="mobileNumber"]').val().trim();
        if (!mobileNumber) {
            $('#mobileNumber-error').text('Nombor Telefon Bimbit diperlukan').removeClass('text-info text-success').addClass('text-dangerr').show();
            $('input[name="mobileNumber"]').addClass('border-danger');
            isValid = false;
        } else if (!/^[0-9]{10,12}$/.test(mobileNumber)) {
            $('#mobileNumber-error').text('Nombor telefon bimbit mesti antara 10 hingga 12 digit').removeClass('text-info text-success').addClass('text-dangerr').show();
            $('input[name="mobileNumber"]').addClass('border-danger');
            isValid = false;
        } else {
            // Clear error if valid
            $('#mobileNumber-error').text('').hide();
            $('input[name="mobileNumber"]').removeClass('border-danger');
        }
        
        if (!$('#terms').is(':checked')) {
            if ($('#terms-error').length === 0) {
                $('label[for="terms"]').after('<span id="terms-error" class="text-dangerr d-block mt-1"></span>');
            }
            $('#terms-error').text('Anda mesti menerima terma dan syarat');
            isValid = false;
        }
        
        if (!isValid) {
            setTimeout(scrollToFirstError, 100);
        }
        
        return isValid;
    }

    // Scroll to First Error
    function scrollToFirstError() {
        const errorElements = $('.text-dangerr:visible').filter(function() {
            return $(this).text().trim() !== '';
        });
        
        if (errorElements.length > 0) {
            const firstError = errorElements.first();
            const fieldId = firstError.attr('id');
            let targetField = null;
            
            if (fieldId.endsWith('-error')) {
                const baseId = fieldId.replace('-error', '');
                targetField = $('#' + baseId);
            } else {
                targetField = $(`[name="${fieldId}"]`);
            }
            
            if (targetField && targetField.length > 0) {
                const accordionCollapse = targetField.closest('.accordion-collapse');
                if (accordionCollapse.length > 0 && !accordionCollapse.hasClass('show')) {
                    accordionCollapse.collapse('show');
                }
                
                $('html, body').animate({
                    scrollTop: targetField.offset().top - 100
                }, 500);
                
                targetField.focus();
                targetField.addClass('border-danger');
                setTimeout(() => {
                    targetField.removeClass('border-danger');
                }, 3000);
            } else {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
        }
    }

    // Form Submission (AJAX)
    $('#registrationForm').on('submit', function (e) {
        e.preventDefault();
        
        if (isSubmitting) return false;
        if (!validateForm()) return false;

        isSubmitting = true;
        const submitButton = $('#submitButton');
        const originalText = submitButton.text();
        submitButton.prop('disabled', true).text('Daftar...');

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('client_register') }}",
            type: "POST",
            data: formData,
            timeout: 30000,
            success: function (response) {
                if (response.success) {
                    let userEmail = $('#emailAddress').val() || $('input[name="email"]').val();
                    
                    if (!userEmail || userEmail === 'undefined' || userEmail === '') {
                        Swal.fire({
                            title: "Error",
                            text: "Unable to retrieve email address. Please try again.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        isSubmitting = false;
                        submitButton.prop('disabled', false).text(originalText);
                        return;
                    }
                    
                    Swal.fire({
                        title: "@lang('app.success')",
                        text: "Pendaftaran berjaya. Sila semak e-mel anda untuk kod pengesahan OTP.",
                        icon: "success",
                        confirmButtonText: "Teruskan ke pengesahan",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        $('#registrationForm')[0].reset();
                        $('#resetButton').prop('disabled', true);
                        let redirectUrl = "{{ route('otp.verification') }}" + "?email=" + encodeURIComponent(userEmail);
                        window.location.href = redirectUrl;
                    });
                } else {
                    isSubmitting = false;
                    submitButton.prop('disabled', false).text(originalText);
                    Swal.fire({
                        title: "Error",
                        text: response.message || "Registration failed",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function (xhr, status, error) {
                isSubmitting = false;
                submitButton.prop('disabled', false).text(originalText);
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $('.text-dangerr').text('');
                    
                    $.each(errors, function (key, value) {
                        if ($("#" + key).length) {
                            $("#" + key).text(value[0]);
                        } else if ($("#" + key + "-error").length) {
                            $("#" + key + "-error").text(value[0]);
                        }
                    });
                    
                    setTimeout(scrollToFirstError, 100);
                } else if (status === 'timeout') {
                    Swal.fire({
                        title: "Timeout",
                        text: "Request timed out. Please try again.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                } else {
                    $('#responseMessage').html('<div class="alert alert-danger">An unexpected error occurred. Please try again.</div>').show();
                }
            }
        });
    });

    // Reset Button Functionality
    $('#registrationForm input, #registrationForm select, #registrationForm textarea').on('input change', function () {
        let hasInput = false;
        $('#registrationForm input, #registrationForm select, #registrationForm textarea').each(function() {
            if ($(this).val()) {
                hasInput = true;
                return false;
            }
        });
        $('#resetButton').prop('disabled', !hasInput);
    });

    $('#resetButton').on('click', function () {
        $('#registrationForm')[0].reset();
        $('#responseMessage').hide();
        $('#resetButton').prop('disabled', true);
        $('.text-dangerr').text('');
        $('.form-control, .form-select').removeClass('border-danger border-success');
        isSubmitting = false;
        $('#submitButton').prop('disabled', false).text('@lang('app.register')');
    });

    // Clear Errors on Input/Focus
    $('input.form-control, textarea.form-control').on('input', function() {
        let name = $(this).attr('name');
        if ($("#" + name).length) {
            $("#" + name).text('');
        } else if ($("#" + name + "-error").length) {
            $("#" + name + "-error").text('');
        }
        $(this).removeClass('border-danger');
    });

    $('select.form-control').on('change', function() {
        let name = $(this).attr('name');
        if ($("#" + name).length) {
            $("#" + name).text('');
        } else if ($("#" + name + "-error").length) {
            $("#" + name + "-error").text('');
        }
    });

    $(document).on('focus', '.form-control, .form-select', function() {
        $(this).removeClass('border-danger');
        const fieldName = $(this).attr('name') || $(this).attr('id');
        if (fieldName) {
            $(`#${fieldName}, #${fieldName}-error`).text('');
        }
    });

    $('#password').on('input', function() {
        $('#password-error').text('');
    });
    
    $('#password, #setPassword').on('input', function() {
        $('#password-match-error').text('');
    });

    // Prevent Navigation During Submission
    window.addEventListener('beforeunload', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            e.returnValue = '';
            return 'Registration is in progress. Are you sure you want to leave?';
        }
    });
});
</script>
</body>
</html>



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
    width: 95% !important;
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
            <div class="col-md-3 col-3 " style="text-align: end;">
                <a href="{{url('/')}}">
                    <img src="{{ asset('assets/images/selangor.png') }}" class="img-fluid logo" alt="Logo">
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
                                    <span class="star d-inline important-font"><i>@lang('Alamat emel akan digunakan sebagai ID Pengguna')</i></span>
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
                                                    <li id="special" style="color: red;">❌ {{ trans('app.special_character') }} (!@#$%)</li>
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
                                                <input type="password" id="setPassword" class="form-control rounded-3 pe-5" name="setPassword" value="{{ old('setPassword') }}" onkeyup="matchPasswords()">
                                                <i class="bi bi-eye-slash toggle-password position-absolute end-0 top-50 translate-middle-y me-3 text-muted cursor-pointer" data-target="setPassword"></i>
                                            </div>
                                            <span class="text-danger password-match-errors" id="password-match-error" style="padding: 0px;"></span>
                                        </div>
                                        <div class="col-md-5">
                                            <span class="star d-inline"><b>*</b></span>
                                            <span class="star d-inline important-font"><i>@lang('Sila masukkan kata laluan sekali lagi untuk tujuan pengesahan')</i></span>
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
                                    <span class="star d-inline important-font"><i>@lang('Masukkan nama seperti di dalam Kad Pengenalan')</i></span>
                                </div>
                            </div>
                
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="idTypeNumber">@lang('app.identification_card_number')</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <input type="text" class="form-control"  name="idCardNumber" value="{{old('idCardNumber')}}">
                                    </div>
                                    <span class="text-dangerr" id="idCardNumber"></span>
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
                                        <input type="text" class="form-control" name="registeredAddress" value="{{old('registeredAddress')}}">
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
                                        <input type="tel" class="form-control" name="mobileNumber" value="{{old('mobileNumber')}}">                                            
                                    </div>
                                    <span id="mobileNumber-error" class="text-dangerr"></span>
                                </div>
                                <div class="col-md-5">
                                    <span class="star d-inline"><b></b></span>
                                    <span class="star d-inline important-font"><i>@lang('Cth: 012345678')</i></span>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="landline">@lang('app.telephone_no')(P)</label>
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
                                    <span class="star d-inline important-font"><i>@lang('Cth: 035678901')</i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>             
                
                <!-- Security Questions Section -->
                <div class="accordion-item border-0 mt-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button header-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            @lang('app.security_questions')
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree">
                        <div class="accordion-body">
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="state">@lang('app.security_questions') 1</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        
                                        <select class="form-control" name="securityQuestion1">
                                            <option value="" selected disabled>@lang('--Sila Pilih--')</option>
                                            @foreach($primaryQuestions as $question)
                                                <option value="{{ $question->question_key }}">{{ __($question->question) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="text-dangerr" id="securityQuestion1"></div>
                                </div>
                            </div>
                        
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="securityAnswers1">@lang('app.security_answers') 1</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b> </span>
                                        <input type="text" class="form-control" name="securityAnswers1" value="{{old('securityAnswers1')}}">
                                    </div>
                                    <div class="text-dangerr" id="securityAnswers1"></div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="state">@lang('app.security_questions') 2</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b></span>
                                        <select class="form-control" name="securityQuestions2">
                                            <option value="" selected disabled>@lang('--Sila Pilih--')</option>
                                            @foreach($secondaryQuestions as $question)
                                                <option value="{{ $question->question_key }}">{{ __($question->question) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="text-dangerr" id="securityQuestions2"></div>
                                </div>
                            </div>
                        
                            <div class="row mt-4">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label for="exampleInputName2">@lang('app.security_answers') 2</label>
                                        <span class="star">*</span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group inlin">
                                        <span class="pe-3"><b> : </b> </span>
                                        <input type="text" class="form-control" name="securityAnswers2" value="{{old('securityAnswers2')}}">
                                    </div> 
                                    <div class="text-dangerr" id="securityAnswers2"></div>                        
                                </div>
                                <div class="col-md-6"></div>
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
                                    <button type="button" class="btn btn-secondary btn3 ms-4">@lang('app.get_out')</button>
                                </div>
                                <div class="col-md-12 d-inline text-end mobile-only px-0">
                                    <button type="submit" class="btn btn-success btn1 btn-sm" id="submitButton">@lang('app.register')</button>
                                    <button type="button" id="resetButton" class="btn btn-primary btn2 btn-sm" disabled>@lang('app.reset')</button>
                                    <button type="button" class="btn btn-secondary btn3 btn-sm">@lang('app.get_out')</button>
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
</body>
</body>
</html>

<script>
    window.appRoutes = {
        otpVerification: "{{ route('otp.verification') }}",
        clientLogin: "{{ route('client_login') }}"
    };
</script>
<script>
   $(document).ready(function () {
    // Keep your existing code
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
                        options += `<option value="${district.iddaerah}">${district.daerah_code +' - '+district.daerah}</option>`;
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
        // Clear all error messages
        $('.text-dangerr').text('');
    });

    // Add client-side validation function
    function validateForm() {
    let isValid = true;
    
    // Clear previous error messages
    $('.text-dangerr').text('');
    
      $('#password').on('input', function() {
        $('#password-error').text('');
    });
    
    // Also clear the password match error when typing in either password field
    $('#password, #setPassword').on('input', function() {
        $('#password-match-error').text('');
    });
    
    
    // Validate Account Type
    if (!$('select[name="accountType"]').val()) {
        $('#accountType').text('Jenis akaun diperlukan');
        isValid = false;
    }
    
    // Validate Email
    if (!$('input[name="email"]').val()) {
        $('#email-error').text('E-mel diperlukan');
        isValid = false;
    }
    
    // Validate Password - Make sure we're checking the correct element ID
    if (!$('#password').val()) {
        $('#password-error').text('Kata laluan diperlukan');
        isValid = false;
    }
    
    // Validate Confirm Password
    if (!$('#setPassword').val()) {
        $('#password-match-error').text('Sahkan kata laluan diperlukan');
        isValid = false;
    } else if ($('#password').val() !== $('#setPassword').val()) {
        $('#password-match-error').text('Kata laluan tidak sepadan');
        isValid = false;
    }
    
    // Validate Username
    if (!$('input[name="userName"]').val()) {
        $('#userName-error').text('Nama pengguna diperlukan');
        isValid = false;
    }
    
    // Validate ID Card Number
    if (!$('input[name="idCardNumber"]').val()) {
        $('#idCardNumber').text('Nombor Kad Pengenalan diperlukan');
        isValid = false;
    }
    
    // Validate Registered Address
    if (!$('input[name="registeredAddress"]').val()) {
        $('#registeredAddress').text('Alamat Berdaftar diperlukan');
        isValid = false;
    }
    
    // Validate Postal Code
    if (!$('input[name="postalCode"]').val()) {
        $('#postalCode').text('Poskod diperlukan');
        isValid = false;
    }
    
    // Validate State
    if (!$('select[name="state"]').val()) {
        $('#state').text('Negeri diperlukan');
        isValid = false;
    }
    
    // Validate District
    if (!$('select[name="district"]').val()) {
        $('#district').text('Bandar diperlukan');
        isValid = false;
    }
    
    // Validate Mobile Number
    if (!$('input[name="mobileNumber"]').val()) {
        $('#mobileNumber-error').text('Nombor Telefon Bimbit diperlukan');
        isValid = false;
    }
    
    // Validate Landline
    // if (!$('input[name="landline"]').val()) {
    //     $('#landline-error').text('Nombor telefon diperlukan');
    //     isValid = false;
    // }
    
    // Validate Security Questions
    if (!$('select[name="securityQuestion1"]').val()) {
        $('#securityQuestion1').text('Soalan Keselamatan 1 diperlukan');
        isValid = false;
    }
    
    if (!$('input[name="securityAnswers1"]').val()) {
        $('#securityAnswers1').text('Keselamatan Jawapan 1 diperlukan');
        isValid = false;
    }
    
    if (!$('select[name="securityQuestions2"]').val()) {
        $('#securityQuestions2').text('Soalan Keselamatan 2 diperlukan');
        isValid = false;
    }
    
    if (!$('input[name="securityAnswers2"]').val()) {
        $('#securityAnswers2').text('Keselamatan Jawapan 2 diperlukan');
        isValid = false;
    }
    
    // Validate Terms and Conditions
    if (!$('#terms').is(':checked')) {
        // Add an error message span for terms if it doesn't exist
        if ($('#terms-error').length === 0) {
            $('label[for="terms"]').after('<span id="terms-error" class="text-dangerr d-block mt-1"></span>');
        }
        $('#terms-error').text('Anda mesti menerima terma dan syarat');
        isValid = false;
    }
    
    return isValid;
}

    // Handle form submission with AJAX
    // $('#registrationForm').on('submit', function (e) {
    //     e.preventDefault(); // Prevent the default form submission
        
    //     // Validate form before submission
    //     if (!validateForm()) {
    //         return false; // Stop the submission if validation fails
    //     }
        
    //     var recaptchaResponse = grecaptcha.getResponse();
    //     if (!recaptchaResponse) {
    //         $('#recaptcha-error').text('Please complete the reCAPTCHA verification.');
    //         return false;
    //     } else {
    //         $('#recaptcha-error').text('');
    //     }

    //     let formData = $(this).serialize(); // Serialize form data

    //     $.ajax({
    //         url: "{{ route('client_register') }}", // Replace with your route
    //         type: "POST",
    //         data: formData,
    //         success: function (response) {
    //             if (response.success) {
    //                 // Show SweetAlert Success
    //                 Swal.fire({
    //                     title: "@lang('app.success')",
    //                     text: "@lang('app.your_registration_successful')",
    //                     icon: "success",
    //                     confirmButtonText: "OK"
    //                 }).then(() => {
    //                     $('#registrationForm')[0].reset(); // Reset form after submission
    //                     $('#resetButton').prop('disabled', true); // Disable reset button
    //                     window.location.href = "{{ route('client_login') }}"; // Replace with your desired route
    //                 });
    //             }
    //         },
    //         error: function (xhr) {
    //             if (xhr.status === 422) {
    //                 let errors = xhr.responseJSON.errors;
    //                 // Clear previous error messages
    //                 $('.text-dangerr').text('');
                    
    //                 // Display each error under its respective field
    //                 $.each(errors, function (key, value) {
    //                     // Use the key to find the error container
    //                     if (key === 'g-recaptcha-response') {
    //                         $('#recaptcha-error').text(value[0]);
    //                     } 
    //                     if ($("#" + key).length) {
    //                         $("#" + key).text(value[0]);
    //                     } else if ($("#" + key + "-error").length) {
    //                         $("#" + key + "-error").text(value[0]);
    //                     }
    //                      grecaptcha.reset();
    //                 });
    //             } else {
    //                 // For other server errors, you might want to display a message
    //                 $('#responseMessage').html('<div class="alert alert-danger">An unexpected error occurred. Please try again.</div>').show();
    //             }
    //         },
    //     });
    // });

    
    // Add real-time validation for specific fields
    $('input[name="email"]').on('blur', function() {
        if (!$(this).val()) {
            $('#email-error').text('Email is required');
        }
    });
    
    $('input[name="userName"]').on('blur', function() {
        if (!$(this).val()) {
            $('#userName-error').text('Username is required');
        }
    });
    
    $('input[name="mobileNumber"]').on('blur', function() {
        if (!$(this).val()) {
            $('#mobileNumber-error').text('Mobile Number is required');
        }
    });
    
    // Clear error message when user starts typing
    $('.form-control').on('input', function() {
        let name = $(this).attr('name');
        if ($("#" + name).length) {
            $("#" + name).text('');
        } else if ($("#" + name + "-error").length) {
            $("#" + name + "-error").text('');
        }
    });
});

</script>
<script>
    let formData = $('#registrationForm').serializeArray();
if (!formData.some(field => field.name === 'terms')) {
    formData.push({ name: 'terms', value: 0 });
}

</script> 
<script>
$(document).ready(function () {
    // Function to validate fields in real time
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
                console.error("An error occurred during validation.");
            },
        });
    }

    // Attach event listeners to specific fields
    $("input[name='email'], input[name='mobileNumber'], input[name='landline']").on('blur', function () {
        let fieldName = $(this).attr("name");
        let fieldValue = $(this).val();

        if (fieldValue) {
            validateField(fieldName, fieldValue);
        }
    });
});
</script>    
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let passwordInput = document.getElementById("password");
        let confirmPasswordInput = document.getElementById("setPassword");
        let validationBox = document.getElementById("password-validation");
        let passwordError = document.getElementById("password-error");
        let matchError = document.getElementById("password-match-error");
    
        // Show validation box on focus (click)
        passwordInput.addEventListener("focus", function() {
            validationBox.style.display = "block";
        });
    
        // Hide validation box when clicking outside
        document.addEventListener("click", function(event) {
            if (!passwordInput.contains(event.target) && !validationBox.contains(event.target)) {
                validationBox.style.display = "none";
            }
        });
    
        // Show validation box and validate password while typing
        passwordInput.addEventListener("input", function() {
            validationBox.style.display = "block";
            validatePassword();
        });
    
        // Check password match when typing
        passwordInput.addEventListener("input", matchPasswords);
        confirmPasswordInput.addEventListener("input", matchPasswords);
    });
    
    function validatePassword() {
        let password = document.getElementById("password").value;
        
        if (password) {
        document.getElementById("password-error").textContent = "";
        }
        
        let length = document.getElementById("length");
        let uppercase = document.getElementById("uppercase");
        let lowercase = document.getElementById("lowercase");
        let number = document.getElementById("number");
        let noSpaces = document.getElementById("noSpaces");
        let special = document.getElementById("special");
        let noSequential = document.getElementById("noSequential");
    
        // Check conditions
        let checks = {
            length: password.length >= 8 && password.length <= 20,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            noSpaces: !/\s/.test(password),
            specialChar: /[!@#$%]/.test(password),
            noSequential: !/(?:012|123|234|345|456|567|678|789|abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz)/i.test(password),
        };
    
        // Update UI
        length.innerHTML = (checks.length ? "✅" : "❌") + " {{ trans('app.password_minimum') }} 8 {{ trans('app.too') }} 20 {{ trans('app.characters') }}";
        uppercase.innerHTML = (checks.uppercase ? "✅" : "❌") + " {{ trans('app.uppercase_letter') }} (A-Z)";
        lowercase.innerHTML = (checks.lowercase ? "✅" : "❌") + " {{ trans('app.lowercase_letter') }} (a-z)";
        number.innerHTML = (checks.number ? "✅" : "❌") + " {{ trans('app.number') }} (0-9)";
        noSpaces.innerHTML = (checks.noSpaces ? "✅" : "❌") + " {{ trans('app.no_spaces') }}";
        special.innerHTML = (checks.specialChar ? "✅" : "❌") + " {{ trans('app.special_character') }} (!@#$%)";
        noSequential.innerHTML = (checks.noSequential ? "✅" : "❌") + " {{ trans('app.no_sequential_characters') }} (abc, 123)";
    }
    
    function matchPasswords() {
        let password = document.getElementById("password").value;
        let confirmPassword = document.getElementById("setPassword").value;
        let matchError = document.getElementById("password-match-error");
    
        if (confirmPassword === "" && password === "") {
            matchError.innerHTML = "";
        } else if (password !== confirmPassword) {
            matchError.innerHTML = "❌ {{ trans('app.passwords_do_not_match') }}";
            matchError.style.color = "red";
        } else {
            matchError.innerHTML = "✅ {{ trans('app.passwords_match') }}";
            matchError.style.color = "green";
        }
    }
</script>  
<script>
document.addEventListener('DOMContentLoaded', function() {
    const accountTypeSelect = document.querySelector('select[name="accountType"]');
    const userInfoButton = document.querySelector('button[data-bs-target="#collapseTwo"]');
    const userNameLabel = document.querySelector('label[for="userName"]');
    const idCardLabel = document.querySelector('label[for="idTypeNumber"]');
    const userNameHintDiv = document.querySelector('label[for="userName"]').closest('.row').querySelector('.col-md-5');
    
    const originalTexts = {
        sectionHeader: userInfoButton.innerText.trim(),
        userName: userNameLabel.innerText.trim(),
        idCard: idCardLabel.innerText.trim()
    };
    
    accountTypeSelect.addEventListener('change', function() {
        const selectedAccountTypeId = parseInt(this.value);
        
        if (selectedAccountTypeId === 3) {
            // Type 3 - Company information
            userInfoButton.innerText = "Maklumat Syarikat";
            userNameLabel.innerText = "Nama Syarikat";
            idCardLabel.innerText = "No Pendaftaran Syarikat";
            userNameHintDiv.style.display = 'none'; 
        } 
        else if (selectedAccountTypeId === 2) {
            userInfoButton.innerText = "Maklumat Syarikat"; 
            userNameLabel.innerText = "Nama Syarikat"; 
            idCardLabel.innerText = "No Pendaftaran Syarikat"; 
            userNameHintDiv.style.display = 'none'; 
        }
        else {
            // Default - Type 1 or any other type
            userInfoButton.innerText = originalTexts.sectionHeader;
            userNameLabel.innerText = originalTexts.userName;
            idCardLabel.innerText = originalTexts.idCard;
            userNameHintDiv.style.display = ''; 
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const securityQuestion1 = document.querySelector('select[name="securityQuestion1"]');
    const securityQuestion2 = document.querySelector('select[name="securityQuestions2"]');
    let originalOptions = [];
    Array.from(securityQuestion2.options).forEach(option => {
        if (option.value) { 
            originalOptions.push({
                value: option.value,
                text: option.text
            });
        }
    });
    
    function updateSecondDropdown() {
        const selectedValue = securityQuestion1.value;
        securityQuestion2.innerHTML = '';
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = '--Sila Pilih--';
        defaultOption.selected = true;
        defaultOption.disabled = true;
        securityQuestion2.appendChild(defaultOption);
        originalOptions.forEach(option => {
            const baseKey1 = selectedValue ? selectedValue.replace(/_[ps]$/, '') : '';
            const baseKey2 = option.value ? option.value.replace(/_[ps]$/, '') : '';
            if (baseKey1 !== baseKey2) {
                const newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.text = option.text;
                securityQuestion2.appendChild(newOption);
            }
        });
    }
    securityQuestion1.addEventListener('change', updateSecondDropdown);
    updateSecondDropdown();
});
</script>
<script>
    $(document).ready(function() {
    $('.toggle-password').on('click', function() {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        const type = input.attr('type') === 'password' ? 'text' : 'password';

        input.attr('type', type);
        $(this).toggleClass('bi-eye bi-eye-slash');
    });
});
</script>
<script>
// Function to scroll to the first error field
function scrollToFirstError() {
    // Find all visible error messages
    const errorElements = $('.text-dangerr:visible').filter(function() {
        return $(this).text().trim() !== '';
    });
    
    if (errorElements.length > 0) {
        // Get the first error element
        const firstError = errorElements.first();
        
        // Find the corresponding input field or select
        const fieldId = firstError.attr('id');
        let targetField = null;
        
        // Try different ways to find the associated field
        if (fieldId.endsWith('-error')) {
            const baseId = fieldId.replace('-error', '');
            targetField = $('#' + baseId);
        } else {
            // For fields where error span id matches field name
            targetField = $(`[name="${fieldId}"]`);
        }
        
        // If we found the field, scroll to it
        if (targetField && targetField.length > 0) {
            // Open the accordion that contains this field
            const accordionCollapse = targetField.closest('.accordion-collapse');
            if (accordionCollapse.length > 0 && !accordionCollapse.hasClass('show')) {
                accordionCollapse.collapse('show');
            }
            
            // Scroll to the field with some offset
            $('html, body').animate({
                scrollTop: targetField.offset().top - 100
            }, 500);
            
            // Focus on the field
            targetField.focus();
            
            // Add a highlight effect
            targetField.addClass('border-danger');
            setTimeout(() => {
                targetField.removeClass('border-danger');
            }, 3000);
        } else {
            // If we can't find the specific field, scroll to the error message
            $('html, body').animate({
                scrollTop: firstError.offset().top - 100
            }, 500);
        }
    }
}

$(document).ready(function () {
    // Add global flag to prevent multiple submissions
    let isSubmitting = false;
    
    // District loading functionality
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
                        options += `<option value="${district.iddaerah}">${district.daerah_code +' - '+district.daerah}</option>`;
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
        $('#registrationForm')[0].reset();
        $('#responseMessage').hide();
        $('#resetButton').prop('disabled', true);
        $('.text-dangerr').text('');
        $('.form-control, .form-select').removeClass('border-danger');
        // Reset submission flag
        isSubmitting = false;
        $('#submitButton').prop('disabled', false).text('Register');
    });

    // Enhanced validation function with scroll functionality
    function validateForm() {
        let isValid = true;
        
        // Clear previous error messages and styling
        $('.text-dangerr').text('');
        $('.form-control, .form-select').removeClass('border-danger');
        
        $('#password').on('input', function() {
            $('#password-error').text('');
        });
        
        $('#password, #setPassword').on('input', function() {
            $('#password-match-error').text('');
        });
        
        // Validate Account Type
        if (!$('select[name="accountType"]').val()) {
            $('#accountType').text('Jenis akaun diperlukan');
            isValid = false;
        }
        
        // Validate Email
        if (!$('input[name="email"]').val()) {
            $('#email-error').text('E-mel diperlukan');
            isValid = false;
        }
        
        // Validate Password
        if (!$('#password').val()) {
            $('#password-error').text('Kata laluan diperlukan');
            isValid = false;
        }
        
        // Validate Confirm Password
        if (!$('#setPassword').val()) {
            $('#password-match-error').text('Sahkan kata laluan diperlukan');
            isValid = false;
        } else if ($('#password').val() !== $('#setPassword').val()) {
            $('#password-match-error').text('Kata laluan tidak sepadan');
            isValid = false;
        }
        
        // Validate Username
        if (!$('input[name="userName"]').val()) {
            $('#userName-error').text('Nama pengguna diperlukan');
            isValid = false;
        }
        
        // Validate ID Card Number
        if (!$('input[name="idCardNumber"]').val()) {
            $('#idCardNumber').text('Nombor Kad Pengenalan diperlukan');
            isValid = false;
        }
        
        // Validate Registered Address
        if (!$('input[name="registeredAddress"]').val()) {
            $('#registeredAddress').text('Alamat Berdaftar diperlukan');
            isValid = false;
        }
        
        // Validate Postal Code
        if (!$('input[name="postalCode"]').val()) {
            $('#postalCode').text('Poskod diperlukan');
            isValid = false;
        }
        
        // Validate State
        if (!$('select[name="state"]').val()) {
            $('#state').text('Negeri diperlukan');
            isValid = false;
        }
        
        // Validate District
        if (!$('select[name="district"]').val()) {
            $('#district').text('Bandar diperlukan');
            isValid = false;
        }
        
        // Validate Mobile Number
        if (!$('input[name="mobileNumber"]').val()) {
            $('#mobileNumber-error').text('Nombor Telefon Bimbit diperlukan');
            isValid = false;
        }
        
        // Validate Security Questions
        if (!$('select[name="securityQuestion1"]').val()) {
            $('#securityQuestion1').text('Soalan Keselamatan 1 diperlukan');
            isValid = false;
        }
        
        if (!$('input[name="securityAnswers1"]').val()) {
            $('#securityAnswers1').text('Keselamatan Jawapan 1 diperlukan');
            isValid = false;
        }
        
        if (!$('select[name="securityQuestions2"]').val()) {
            $('#securityQuestions2').text('Soalan Keselamatan 2 diperlukan');
            isValid = false;
        }
        
        if (!$('input[name="securityAnswers2"]').val()) {
            $('#securityAnswers2').text('Keselamatan Jawapan 2 diperlukan');
            isValid = false;
        }
        
        // Validate Terms and Conditions
        if (!$('#terms').is(':checked')) {
            if ($('#terms-error').length === 0) {
                $('label[for="terms"]').after('<span id="terms-error" class="text-dangerr d-block mt-1"></span>');
            }
            $('#terms-error').text('Anda mesti menerima terma dan syarat');
            isValid = false;
        }
        
        // If validation fails, scroll to first error
        if (!isValid) {
            setTimeout(scrollToFirstError, 100);
        }
        
        return isValid;
    }

    // Handle form submission with AJAX - FIXED VERSION
    // $('#registrationForm').off('submit').on('submit', function (e) {
    //     e.preventDefault();
        
    //     console.log('Form submission started, isSubmitting:', isSubmitting);
        
    //     // Prevent multiple submissions
    //     if (isSubmitting) {
    //         console.log('Already submitting, ignoring duplicate submission');
    //         return false;
    //     }
        
    //     // Validate form before submission
    //     if (!validateForm()) {
    //         console.log('Validation failed');
    //         return false;
    //     }

    //     // Set submitting flag and disable button
    //     isSubmitting = true;
    //     const submitButton = $('#submitButton');
    //     const originalText = submitButton.text();
    //     submitButton.prop('disabled', true).text('Registering...');

    //     let formData = $(this).serialize();
        
    //     console.log('Making AJAX request...');

    //     $.ajax({
    //         url: "{{ route('client_register') }}",
    //         type: "POST",
    //         data: formData,
    //         timeout: 30000, // 30 seconds timeout
    //         success: function (response) {
    //             console.log('AJAX Success:', response);
                
    //             if (response.success) {
    //                 Swal.fire({
    //                     title: "@lang('app.success')",
    //                     text: "@lang('app.your_registration_successful')",
    //                     icon: "success",
    //                     confirmButtonText: "OK",
    //                     allowOutsideClick: false,
    //                     allowEscapeKey: false
    //                 }).then(() => {
    //                     $('#registrationForm')[0].reset();
    //                     $('#resetButton').prop('disabled', true);
    //                     window.location.href = "{{ route('client_login') }}";
    //                 });
    //             } else {
    //                 // Reset on failure
    //                 isSubmitting = false;
    //                 submitButton.prop('disabled', false).text(originalText);
                    
    //                 Swal.fire({
    //                     title: "Error",
    //                     text: response.message || "Registration failed",
    //                     icon: "error",
    //                     confirmButtonText: "OK"
    //                 });
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.log('AJAX Error:', xhr.status, status, error);
                
    //             // Reset submission state
    //             isSubmitting = false;
    //             submitButton.prop('disabled', false).text(originalText);
                
    //             if (xhr.status === 422) {
    //                 let errors = xhr.responseJSON.errors;
    //                 $('.text-dangerr').text('');
                    
    //                 // Display each error under its respective field
    //                 $.each(errors, function (key, value) {
    //                     if ($("#" + key).length) {
    //                         $("#" + key).text(value[0]);
    //                     } else if ($("#" + key + "-error").length) {
    //                         $("#" + key + "-error").text(value[0]);
    //                     }
    //                 });
                    
    //                 // Scroll to first server-side error
    //                 setTimeout(scrollToFirstError, 100);
    //             } else if (status === 'timeout') {
    //                 Swal.fire({
    //                     title: "Timeout",
    //                     text: "Request timed out. Please try again.",
    //                     icon: "error",
    //                     confirmButtonText: "OK"
    //                 });
    //             } else {
    //                 $('#responseMessage').html('<div class="alert alert-danger">An unexpected error occurred. Please try again.</div>').show();
    //             }
    //         },
    //         complete: function() {
    //             console.log('AJAX Complete');
    //             // This runs regardless of success or error
    //             // Don't reset isSubmitting here for success case as we redirect
    //         }
    //     });
    // });
    
    $('#registrationForm').off('submit').on('submit', function (e) {
    e.preventDefault();
    
    console.log('Form submission started, isSubmitting:', isSubmitting);
    
    // Prevent multiple submissions
    if (isSubmitting) {
        console.log('Already submitting, ignoring duplicate submission');
        return false;
    }
    
    // Validate form before submission
    if (!validateForm()) {
        console.log('Validation failed');
        return false;
    }

    // Set submitting flag and disable button
    isSubmitting = true;
    const submitButton = $('#submitButton');
    const originalText = submitButton.text();
    submitButton.prop('disabled', true).text('Registering...');

    let formData = $(this).serialize();
    
    console.log('Making AJAX request...');

    $.ajax({
        url: "{{ route('client_register') }}",
        type: "POST",
        data: formData,
        timeout: 30000, // 30 seconds timeout
        success: function (response) {
            console.log('AJAX Success:', response);
            
            if (response.success) {
                // Get email using the correct ID: emailAddress
                let userEmail = $('#emailAddress').val() || 
                               $('input[name="email"]').val();
                
                console.log('Email value:', userEmail); // Debug log
                
                // Check if email is valid before proceeding
                if (!userEmail || userEmail === 'undefined' || userEmail === '') {
                    console.error('Email is undefined or empty');
                    Swal.fire({
                        title: "Error",
                        text: "Unable to retrieve email address. Please try again.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    
                    // Reset submission state
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
                    // Reset form
                    $('#registrationForm')[0].reset();
                    $('#resetButton').prop('disabled', true);
                    
                    // Redirect to OTP verification page with email parameter
                    let redirectUrl = "{{ route('otp.verification') }}" + "?email=" + encodeURIComponent(userEmail);
                    console.log('Redirecting to:', redirectUrl); // Debug log
                    window.location.href = redirectUrl;
                });
            } else {
                // Reset on failure
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
            console.log('AJAX Error:', xhr.status, status, error);
            
            // Reset submission state
            isSubmitting = false;
            submitButton.prop('disabled', false).text(originalText);
            
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.text-dangerr').text('');
                
                // Display each error under its respective field
                $.each(errors, function (key, value) {
                    if ($("#" + key).length) {
                        $("#" + key).text(value[0]);
                    } else if ($("#" + key + "-error").length) {
                        $("#" + key + "-error").text(value[0]);
                    }
                });
                
                // Scroll to first server-side error
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
        },
        complete: function() {
            console.log('AJAX Complete');
            // This runs regardless of success or error
            // Don't reset isSubmitting here for success case as we redirect
        }
    });
});
    
    // Add visual feedback when fields have errors
    $(document).on('focus', '.form-control, .form-select', function() {
        $(this).removeClass('border-danger');
        const fieldName = $(this).attr('name') || $(this).attr('id');
        if (fieldName) {
            $(`#${fieldName}, #${fieldName}-error`).text('');
        }
    });
    
    // Real-time validation for specific fields
    $('input[name="email"]').on('blur', function() {
        if (!$(this).val()) {
            $('#email-error').text('Email is required');
        }
    });
    
    $('input[name="userName"]').on('blur', function() {
        if (!$(this).val()) {
            $('#userName-error').text('Username is required');
        }
    });
    
    $('input[name="mobileNumber"]').on('blur', function() {
        if (!$(this).val()) {
            $('#mobileNumber-error').text('Mobile Number is required');
        }
    });
    
    // Clear error message when user starts typing
    $('.form-control').on('input', function() {
        let name = $(this).attr('name');
        if ($("#" + name).length) {
            $("#" + name).text('');
        } else if ($("#" + name + "-error").length) {
            $("#" + name + "-error").text('');
        }
    });
    
    // Prevent browser back/forward causing issues
    window.addEventListener('beforeunload', function() {
        if (isSubmitting) {
            return 'Registration is in progress. Are you sure you want to leave?';
        }
    });
});

// Additional safety: Prevent multiple script executions
if (window.registrationScriptLoaded) {
    console.warn('Registration script already loaded, skipping...');
} else {
    window.registrationScriptLoaded = true;
}
</script>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{get_company_name()}} | {{trans('app.login')}}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{image_url('favicon.png')}}">
    {!! Html::style(asset('assets/css/font-awesome.min.css')) !!}
    {!! Html::style(asset('assets/css/bootstrap.min.css')) !!}
    {!! Html::style(asset('assets/css/theme.min.css')) !!}
    {!! Html::style(asset('assets/plugins/amaranjs/css/amaran.min.css')) !!}
    {!! Html::style(asset('assets/css/style.css')) !!}
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JPS LOGIN PAGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- bi bi icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style>
    @media screen and (min-width: 769px) { 
        .navbar {
        font-family: "Poppins", sans-serif;
        background-color: #80A5D0 !important; /* Semi-transparent background */
        width: 100%; /* Ensure it spans full width */
        height: 25px;
    }
}
li.nav-item {
    font-size: 13px;
}
.nav-link{
      color: #fff !important;
}
.navbar-nav .nav-link {
    color: #fff;
    /*font-weight: bold;*/
    padding: 8px 15px;
}

.navbar-nav .nav-link:hover {
    color: #337ABB; /* Matches your existing blue theme */
    background-color: rgba(0, 0, 0, 0.1); /* Subtle hover effect */
    border-radius: 5px;
    height: 30px;
}

.navbar-brand img {
    border-radius: 5px;
}

@media screen and (max-width: 768px) {
    .navbar-nav .nav-link {
        text-align: center !important;
        padding: 10px !important;
    }

    .navbar {
        font-family: "Poppins", sans-serif;
        background-color: #80A5D0 !important; 
        width: 100%;
    }
}


    body {
       font-family: "Poppins", sans-serif;
}
    h1, h2, h3, h4, h5, h6 {
    font-family: "Poppins", sans-serif;
    font-weight: 400;
    margin: 5px 0;
    line-height: 20px;
}
p{
    font-size:13px;
}
        .portal {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: initial;
            /*border-radius: 0 10px 10px 0;*/
            color: white;
        }

        .icon-text {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .icon-text2 {
            background-color: #497EB9;
            border-radius: 12px;
            border: 2px solid #7E8389;
        }

        .stick-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            /*background-color: rgba(0, 0, 0, 0.2);*/
            margin: 0;
            /*padding: 10px 0;*/
            z-index: 1000;
        }

        .w3-sidebar {
            height: 100%;
            width: 200px;
            background-color: #fff;
            position: relative !important;
            z-index: 1;
            /* overflow: auto; */
        }

        .side-icon {
            display: flex;
            flex-direction: row;
            justify-content: end;
        }

        .w3-bar-block .w3-bar-item {
            width: 100%;
            display: block;
            padding: 2px 8px;
            text-align: center;
            border: none;
            white-space: normal;
            float: none;
            outline: 0;
        }

        /*@import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');*/

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
              font-family: "Poppins", sans-serif;
            }

        body {
            background-repeat: no-repeat;
            background-size: cover;
            /* min-height: 100vh; */
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            /* background-color: rgba(0, 0, 0, 0.3); */
        }

        .container {
            box-shadow: 0px 0px 10px white;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            color: #fff;
            height: 380px;
            width: 340px;
            padding: 20px;
        }

        .title {
            font-size: 40px;
            text-align: center;
        }

        .form-container .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-container .email {
            margin-top: 30px;
        }

        .form-container .password {
            margin-top: 20px;
        }

        .input-box input {
            width: 100%;
            outline: 0;
            border: 2px solid #cecece;
            border-radius: 15px;
            /*padding: 8px 8px 8px 15px;*/
            /* background: transparent; */
            /* color: #fff; */
            font-size: 16px;
        }

        input::placeholder {
            color: black;
        }

        box3::placeholder {
            color: white;
        }

        .input-box img {
            position: absolute;
            right: 25px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
        }

        .forgot a {
            font-size: 15px;
            color: #fff;
        }

        .button {
            display: flex;
            justify-content: center;
            margin-top: 28px;
        }
        .input-box.login {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }
        .button button {
            border: none;
            background-color: #fff;
            border-radius: 50px;
            color: #000;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 0;
            outline: none;
            width: 100%;
        }

        .button button:hover {
            background-color: #cecece;
        }

        .register p {
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        .register p a {
            color: #fff;
        }

        .register p a:hover,
        .forgot a:hover {
            color: blue;
        }
        
        .login-page, .register-page {
             height: auto ;
        }
         .btn-outline-light{
                display: none;
        }
        ecap.{
                font-family: "Poppins", sans-serif;
        }
        
        .captcha-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: repeating-linear-gradient(
        45deg,
        transparent,
        transparent 2px,
        rgba(0,0,0,0.1) 2px,
        rgba(0,0,0,0.1) 4px
    );
    pointer-events: none;
}

.captcha-image span {
    position: relative;
    z-index: 1;
    transform: rotate(-2deg);
}

.refresh-btn:hover {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
}

.captcha-feedback.success {
    color: #28a745;
}

.captcha-feedback.error {
    color: #dc3545;
}

.alert-dismissible .btn-close{
    top: -16px !important;
}

form.loginFrm.needs-validation {
    padding: 0 20px;
}
input.btn.btn-primary.login-button.btn-sm.form-control.disabled {
    background: #2c2cb7;
    border-radius: 15px;
    border: 2px solid #cecece;
}
a.btn.btn-primary.login-button.btn-sm.form-control.disabled {
    background: #2c2cb7;
    border-radius: 15px;
    border: 2px solid #cecece;
    font-size: inherit;
}
input.btn.btn-primary.login-button.btn-sm.form-control {
    background: #3649B8;
}
body {
    background-image: url("https://ecp-jps.selangor.gov.my/assets/images/JPS logo.jpg");
    background-size: cover; 
    background-position: center; /* Centers the image */
    background-repeat: no-repeat; /* Prevents the image from repeating */
    background-attachment: fixed; /* Keeps the image fixed during scrolling */
    margin: 0;
    height: 100vh;
    width: 100vw; /* Ensures the width is full screen */
    overflow: hidden; /* Prevents scrolling if unnecessary */
}

    @media (max-width: 768px) {
    body {
        /*background-size: contain; */
        
        /*background-attachment: scroll;*/
        
    }
    }
    .w3-xxlarge {
        font-size: 30px !important;
    }
    .w3-button:hover {
        color: #000 !important;
        background-color: #ccc !important;
    }
    @media (min-width: 1200px) {
        .h2, h2 {
            font-size: 1.83rem;
            
        }
        .footerForMobile{
            display: none !important;
        }
    }

    @media (min-width: 600px) {
        .footerForMobile{
            display: none !important;
        }
    }

    #canvas {
        position: fixed;
        top: 0;
        left: 0;
        z-index: -1; /* Ensures it's behind other elements */
        width: 100%;
        height: 100%;
        pointer-events: none; /* Prevents interference with user interactions */
    }
    .form-check {
        font-size: 15px;
    }
    .filterform{
        padding: 20px 45px;
        border: 1px solid #DDDDDD;
        border-radius: 5px;
    }
    .modal-dialog.modal-lg{
        padding: 0px 55px;
    }
    .modal-header {
        padding: 0px 20px;
        border-bottom: none;
        background: #fff !important;
    }
    h5#searchModalLabel {
        color: #000;
    }
    label:not(.form-check-label):not(.custom-file-label) {
        font-weight: 400;
        font-size: 13px;
    }
    button.btn.btn-primary {
        background: #5B90E1;
        border: 1px solid #5B90E1;
    }
    button.btn.btn-warning {
        background: #FF9B46;
        border: 1px solid #FF9B46;
        color: #000;
    }
    button.btn.btn-outline-secondary {
        background: #FF9B46;
        color: #000;
    }
    .form-select{
        font-size:13px;
    }
    .form-control{
        font-size:16px;
        border-radius: 25px !important;
    }
    input#captcha {
        margin: 0px 5px 0px 0px;
    }
    .important {
        color: red;
        font-weight: bold;
    }

   /* Ensure modal background is not overriding */
    .modal-content {
        background-color: #fff !important;
        border-radius: 10px;
        padding: 20px;
    }

    /* Maintain your existing styles */
    .ag-format-container {
        width: 1020px !important;
        margin: 0 auto;
    }

    .ag-courses_box {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 20px 0;
        max-width: 100%;
        overflow: hidden;
    }

    .ag-courses_item {
        flex: 1 1 calc(33.333% - 20px); /* 3 cards per row */
        max-width: calc(33.333% - 20px); /* Prevents overflow */
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        padding: 10px;
    }

    @media (max-width: 992px) {
        .ag-courses_item {
            flex: 1 1 calc(50% - 20px); /* 2 cards per row on medium screens */
            max-width: calc(50% - 20px);
        }
    }

    @media (max-width: 576px) {
        .ag-courses_item {
            flex: 1 1 100%; /* 1 card per row on small screens */
            max-width: 100%;
        }
    }
    .ag-courses_item:hover {
        transform: scale(1.05);
    }

    .ag-courses-item_link {
        padding: 20px;
        height: 100%;
        text-decoration: none;
    }

    .ag-courses-item_title {
        font-size: 20px;
        font-weight: bold;
        color: #000;
    }

    .ag-courses-item_date-box {
        font-size: 16px;
        color: #000;
    }

    .ag-courses-item_date {
        font-weight: bold;
        color: #1991EE;
    }

    
    .modal-fullscreen .modal-content {
        height: 90%;
        border: 0;
        border-radius: 0;
        width: 90%;
        display: flex;
    }

    .modal-fullscreen {
        width: 100vw;
        max-width: none;
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
    }

    .accordion-title:before {
        float: right !important;
        font-family: FontAwesome;
        content: "\f068";
        padding-right: 5px;
    }

    .accordion-title.collapsed:before {
        content: "\f067";
    }
    a.card-link.accordion-title {
        text-decoration: none;
    }
    .card-link:hover {
        text-decoration: none !important;
    }
    .heading1{
        font-size: 24px
    }
    .heading2{
            font-size: 19px
    }
    .fill{
        margin-top: 48px
    }

    @media only screen and (max-width: 600px) {
        .heading1{
            font-size: 13px;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .heading2{
                font-size: 12px;
        }
        .fill{
            margin-top: 2px;
        }
        .stick-bottom{
            display: none !important;
        }
        .footerForMobile{
            text-align: center;
            color: white;
            margin-top: 6px;
        }
        .ecap{
            padding-inline: 0px;
        }
        .navbar-toggler-icon{
                width: 18px;
                height: 12px;
        }
        
    } 

    i.bi.bi-eye-slash.toggle-password.position-absolute.end-0.top-50.translate-middle-y.me-3.pe-4.text-muted.cursor-pointer{
        cursor: pointer !important;
        padding-bottom: 35px !important;
    }


    @media (min-width: 426px) and (max-width: 768px) {
        .cursor-pointer {

        }
    }

   .alert.alert-danger {
        position: absolute;
        top: -50px;
        left: 0px;
        right: 0px;
        z-index: 11; /* Above form content */
        margin: 0;
        padding: 0 10px;
        font-size: 14px;
        background-color: rgba(220, 53, 69, 0.9);
        color: white;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

      /* Ensure Third Party Modal appears on top */
    #thirdPartyRegisterModal,
    #thirdPartyRegisterModal.modal {
        z-index: 99999 !important;
    }
    
    #thirdPartyRegisterModal + .modal-backdrop {
        z-index: 99998 !important;
    }
    
    /* Ensure login form stays behind modals */
    .login-page {
        z-index: 1 !important;
    }

    .cursor-pointer {
        cursor: pointer !important;
    }

    .toggle-password {
        z-index: 10;
        cursor: pointer;
    }
</style>
</head>
<body class="login-page">
     <canvas id="canvas"></canvas>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            </ul>
        </div>
    </div>
</nav>

    <div class="container-fluid ps-0 mt-5">
        <div class="row ">
            <div class="col-md-2 col-5 pe-0 icon-text text-center ">
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
            <div class="col-md-10 col-7 portal icon-text ecap" style="justify-content: center;">
                <h2 class="">PORTAL e-CP (CARUMAN PARIT)</h2>
                <h3>JPS NEGERI SELANGOR</h3>
            </div>
        </div>
        <div class="row fill">
                <div class="col-md-2 "></div>
                    @if (session('error'))
                        <div class="alert alert-danger">{!! session('error') !!}</div>
                    @endif
                    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12 icon-text2 pt-4 pb-0 mb-0 mt-3" style="z-index: 99999;">
    
                            {{-- Display Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0" style="list-style: none; padding: 0;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Session Error Messages --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {!! session('error') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Session Success Messages --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Login Form --}}
                         <form method="POST" action="{{ route('third.party.login.submit') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <input type="email"
                                name="email"
                                class="form-control"
                                placeholder="Emel"
                                style="border-radius:25px; padding:12px 20px;"
                                required>
                        </div>

                        <!-- Password -->
                        <div class="mb-2 position-relative">
                            <input type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Kata Laluan"
                                style="border-radius:25px; padding:12px 45px 12px 20px;"
                                required>

                            <i class="bi bi-eye-slash toggle-password position-absolute"
                            data-target="password"
                            style="cursor:pointer; right:18px; top:25%; transform:translateY(-50%);">
                            </i>
                        </div>

                        <!-- Forgot password -->
                        <div class="text-end mb-3">
                            <a href="{{ url('third-party/forgot-password') }}"
                             style="text-decoration:none; font-size:16px; color:white !important;"> 
                                Lupa Kata Laluan ?
                            </a>
                        </div>

                        <!-- Buttons -->
                        <div class="row justify-content-center text-center">
                            <div class="col-6 mb-2">
                                <button type="submit"
                                        class="btn w-100"
                                        style="
                                            background:#3949e7;
                                            color:white;
                                            border-radius:15px;
                                            border:2px solid #bfc9ff;
                                            padding:6px 0;
                                            font-size:14px;
                                        ">
                                    Log masuk
                                </button>
                            </div>

                            <div class="col-6 mb-2">
                                <button type="button"
                                        onclick="this.form.reset();"
                                        class="btn w-100"
                                        style="
                                            background:#3949e7;
                                            color:white;
                                            border-radius:15px;
                                            border:2px solid #bfc9ff;
                                            padding:6px 0;
                                            font-size:14px;
                                        ">
                                    Isi Semula
                                </button>
                            </div>
                        </div>
                    </form>

                    </div>
                    <footer>
                            <div class="row">
                                <div class="col-md-12 text-center text-light pt-3 stick-bottom">
                                    <p>@lang('Hak Cipta Terpelihara @ 2025 , Jabatan Pengairan Dan Saliran Negeri Selangor <br>
                                    Paparan terbaik menggunakan pelayar Google Chrome dengan resolusi skrin 1280x768')</p>
                                </div>

                            </div>
                            <p class="footerForMobile">Hak Cipta Terpelihara @ 2025 , Jabatan Pengairan Dan Saliran Negeri Selangor
                                Paparan terbaik menggunakan pelayar Google Chrome dengan resolusi skrin 1280x768
                            </p>
                    </footer>       

                </div>

        </div>

    </div>
{!! Html::script(asset('assets/js/jquery.min.js')) !!}
{!! Html::script(asset('assets/js/bootstrap.min.js')) !!}
{!! Html::script(asset('assets/js/validator.min.js')) !!}
{!! Html::script(asset('assets/plugins/amaranjs/js/jquery.amaran.min.js')) !!}
{!! Html::script(asset('assets/plugins/backstretch-js/jquery.backstretch.min.js')) !!}
{!! Html::script(asset('assets/plugins/togglepassword/togglepassword.js')) !!}
{!! Html::script(asset('assets/js/auth.js')) !!}
@php
$bg = get_setting_value('login_bg') != '' ? image_url(get_setting_value('login_bg')) : image_url('bg.jpg');
@endphp

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
    $(function(){
        $('form').validator();
        // $.backstretch("{{$bg}}");
    });
</script>
@if (session()->has('flash_notification'))
    <?php
    $notification = session()->pull('flash_notification')[0];
    $message_type = $notification->level;
    ?>
    @if($message_type === 'success')
        <script>
            $.amaran({
                'theme'     :'awesome ok',
                'content'   :{
                    title:'Success !',
                    message:'{{$notification->message}}!',
                    info:'',
                    icon:'fa fa-check-square-o'
                },
                'position'  :'bottom right',
                'outEffect' :'slideBottom'
            });
        </script>
    @elseif($message_type === 'danger')
        <script>
            $.amaran({
                'theme'     :'awesome error',
                'content'   :{
                    title:'Error !',
                    message:'{{$notification->message}}!',
                    info:'',
                    icon:'fa fa-times-circle-o'
                },
                'position'  :'bottom right',
                'outEffect' :'slideBottom'
            });
        </script>
    @endif
@endif
<script>
    var canvas = document.getElementById("canvas"),
        ctx = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    var stars = [], 
        FPS = 60, 
        x = 100, 
        mouse = {
          x: 0,
          y: 0
        };  

    for (var i = 0; i < x; i++) {
        stars.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            radius: Math.random() * 1 + 1,
            vx: Math.floor(Math.random() * 50) - 25,
            vy: Math.floor(Math.random() * 50) - 25
        });
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.globalCompositeOperation = "lighter";

        for (var i = 0, x = stars.length; i < x; i++) {
            var s = stars[i];

            ctx.fillStyle = "#fff";
            ctx.beginPath();
            ctx.arc(s.x, s.y, s.radius, 0, 2 * Math.PI);
            ctx.fill();
            ctx.fillStyle = 'black';
            ctx.stroke();
        }

        ctx.beginPath();
        for (var i = 0, x = stars.length; i < x; i++) {
            var starI = stars[i];
            ctx.moveTo(starI.x, starI.y);
            if (distance(mouse, starI) < 150) ctx.lineTo(mouse.x, mouse.y);
            for (var j = 0, x = stars.length; j < x; j++) {
                var starII = stars[j];
                if (distance(starI, starII) < 150) {
                    ctx.lineTo(starII.x, starII.y);
                }
            }
        }
        ctx.lineWidth = 0.05;
        ctx.strokeStyle = 'white';
        ctx.stroke();
    }

    function distance(point1, point2) {
        var xs = 0;
        var ys = 0;

        xs = point2.x - point1.x;
        xs = xs * xs;

        ys = point2.y - point1.y;
        ys = ys * ys;

        return Math.sqrt(xs + ys);
    }

   
    function update() {
        for (var i = 0, x = stars.length; i < x; i++) {
            var s = stars[i];

            s.x += s.vx / FPS;
            s.y += s.vy / FPS;

            if (s.x < 0 || s.x > canvas.width) s.vx = -s.vx;
            if (s.y < 0 || s.y > canvas.height) s.vy = -s.vy;
        }
    }

    canvas.addEventListener('mousemove', function(e) {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });

    // Update and draw
    function tick() {
        draw();
        update();
        requestAnimationFrame(tick);
    }

    tick();
</script>
<script>
    $(document).ready(function() {
        $('.toggle-password').on('click', function() {
            const targetId = $(this).data('target');
            const input = $('#' + targetId);
            const type = input.attr('type') === 'password' ? 'text' : 'password';
            
            input.attr('type', type);
            $(this).toggleClass('bi-eye-slash bi-eye');
        });
    });
    
    function resetLoginForm(el) {
        // find the nearest form inside same column
        let form = el.closest('.col-lg-4').querySelector('form');
        if(form){
            form.reset(); // clears inputs
        }
    }
</script>
</body>
</html>

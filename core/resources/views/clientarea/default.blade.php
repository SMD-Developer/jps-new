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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

form.loginFrm.needs-validation {
    padding: 0 20px;
}
input.btn.btn-primary.login-button.btn-sm.form-control.disabled {
    background: #2c2cb7;
    border-radius: 15px;
    border: 2px solid #cecece;
    font-size: inherit;
}
a.btn.btn-primary.login-button.btn-sm.form-control.disabled {
    background: #2c2cb7;
    border-radius: 15px;
    border: 2px solid #cecece;
    font-size: inherit;
    display: flex;
    justify-content: center;
    align-items: center;
}
input.btn.btn-primary.login-button.btn-sm.form-control {
    background: #3649B8;
}
body {
    background-image: url("https://ecp-jps.selangor.gov.my/assets/images/JPS logo.jpg");
    background-size: cover; /* Ensures the image covers the entire screen */
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
        background: #1858b9;
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
        font-size:13px;
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
        background-color: rgba(220, 53, 69, 0.9); /* Semi-transparent for visibility */
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

    .password-wrapper {
    position: relative;
}

.password-wrapper i {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 10;
}

.dropdown-item{
    font-size: 13px !important;
}


/* Banner Styles */
.banner-container {
    margin-bottom: 20px;
}

.banner-container img {
    width: 100%;
    height: auto;
    display: block;
}

.banner-top {
    margin-top: 0;
}

.banner-middle {
    margin: 20px 0;
}

.banner-bottom {
    margin-top: 20px;
    margin-bottom: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .banner-container img {
        max-height: 150px !important;
    }
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
                <!-- Add this button where you want (in navbar or main page) -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#thirdPartyRegisterModal">
                        <i class="fa fa-search"></i> @lang('app.search_c')
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i> @lang('app.search_c')</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="manualDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-book"></i> @lang('app.users_manual')
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('INDIVIDU.pdf') }}" target="_blank">
                            <i class="fa fa-file-pdf"></i> PENDAFTARAN PENGGUNA -INDIVIDU
                        </a>
                        <a class="dropdown-item" href="{{ url('AGENSI.pdf') }}" target="_blank">
                            <i class="fa fa-file-pdf"></i> PENDAFTARAN PENGGUNA-PEMAJU DAN AGENSI
                        </a>
                    </div>
                </li>
                <li class="nav-item" data-bs-toggle="modal" data-bs-target="#faqModal">
                    <a class="nav-link" href="#"><i class="fa fa-question-circle"></i> @lang('app.frequently_asked_questions_(faq)')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#feedbackModal"><i class="fa fa-comments"></i> @lang('app.feedback')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#contactModal">
                        <i class="fa fa-phone"></i> @lang('app.contact_uss')
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


{{-- Banner Modal/Popup - Fetched directly from DB --}}
@php
    $banner = DB::table('settings')
                ->select('banner_image', 'banner_enabled', 'banner_title', 'banner_link', 
                        'banner_new_tab', 'banner_position', 'banner_start_date', 'banner_end_date')
                ->first();
    
    $showBanner = false;
    if ($banner && $banner->banner_enabled && $banner->banner_image) {
        $now = \Carbon\Carbon::now();
        $showBanner = true;
        
        // Check date range if set
        if ($banner->banner_start_date && $now->lt(\Carbon\Carbon::parse($banner->banner_start_date))) {
            $showBanner = false;
        }
        if ($banner->banner_end_date && $now->gt(\Carbon\Carbon::parse($banner->banner_end_date))) {
            $showBanner = false;
        }
    }
@endphp

@if($showBanner)
    <!-- Banner Overlay -->
    <div id="bannerOverlay" class="banner-overlay" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
    ">
        <!-- Banner Modal Container -->
        <div class="banner-modal" style="
            position: relative;
            max-width: 90%;
            max-height: 90vh;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            z-index: 9999999;
        ">
            <!-- Close Button -->
            <button onclick="closeBanner()" style="
                position: absolute;
                top: 10px;
                right: 10px;
                background: rgba(255, 255, 255, 0.9);
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                font-size: 24px;
                color: #e74c3c;
                cursor: pointer;
                z-index: 99999999;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                transition: all 0.3s ease;
            " 
            onmouseover="this.style.background='#e74c3c'; this.style.color='white'; this.style.transform='scale(1.1)';"
            onmouseout="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.color='#e74c3c'; this.style.transform='scale(1)';">
                ×
            </button>

            <!-- Banner Image -->
            @if($banner->banner_link)
                <a href="{{ $banner->banner_link }}" 
                   {!! $banner->banner_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' !!}>
                    <img src="{{ asset('assets/images/uploads/settings/' . $banner->banner_image) }}" 
                         alt="{{ $banner->banner_title ?? 'Banner' }}" 
                         style="
                            display: block;
                            width: 100%;
                            height: auto;
                            max-height: 85vh;
                            object-fit: contain;
                         ">
                </a>
            @else
                <img src="{{ asset('assets/images/uploads/settings/' . $banner->banner_image) }}" 
                     alt="{{ $banner->banner_title ?? 'Banner' }}" 
                     style="
                        display: block;
                        width: 100%;
                        height: auto;
                        max-height: 85vh;
                        object-fit: contain;
                     ">
            @endif
        </div>
    </div>

    <script>
        function closeBanner() {
            document.getElementById('bannerOverlay').style.display = 'none';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeBanner();
            }
        });

        document.getElementById('bannerOverlay').addEventListener('click', function(event) {
            if (event.target === this) {
                closeBanner();
            }
        });
    </script>

@endif

<div class="container-fluid ps-0 mt-5">
        <div class="row ">
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
                    <!--<p class="text-center text-light"><b>Log Masuk</b></p>-->
                    {!! Form::open(['url' => '/clientarea/login','class'=>'loginFrm needs-validation mt-3','novalidate']) !!}
                    <div class="input-box email">
                        <!--<input type="email" id="email-input" required placeholder="Emel">-->
                        <!--{!! Form::label('email', trans('app.email_or_username')) !!}-->
                        {!! Form::input('email','login', null, ['class'  =>"form-control", 'required'=>'required', 'placeholder'=>"Emel"]) !!}
                    </div>
                    <div class="input-box mt-3 position-relative" style="position: relative;">
                        {!! Form::password('password', ['class'=>"form-control", 'id'=>"password", 'required'=>'required' , 'placeholder'=>'Kata Laluan', 'style'=>'padding-right: 40px;' ]) !!}
                       <i class="bi bi-eye-slash toggle-password translate-middle-y me-3 pe-4 text-muted cursor-pointer" data-target="password"></i>
                    </div>
                   
                    <div class="forgot float-right mt-2">
                        <!--<a class="mb-3" href="{{ url('client/password/reset') }}" style="text-decoration: none; float: right;">@lang('app.lost_password')</a>-->
                        <a class="mb-0" href="{{ url('clientarea/password/reset') }}" style="text-decoration: none; float: right;">@lang('app.lost_password') ?</a>
                        <!--<a href="{{ url('password/reset') }}">@lang('app.lost_password')</a>-->
                    </div>
               
                     <div class="input-box login mt-5">
                        <!--<input type="" id="email-input" placeholder="Log Masuk" style="background: #2c2cb7; text-align: center;">-->
                        <!--{!! Form::Submit('Login', ['class'=>"btn btn-primary login-button btn-sm form-control"]) !!}-->
                        <!--{!! Form::Submit('Log masuk', ['class'=>"btn btn-primary login-button btn-sm form-control"]) !!}-->
                        {!! Form::Submit('Log masuk', ['class'=>"btn btn-primary login-button btn-sm form-control"]) !!}&nbsp;&nbsp;&nbsp;
                        <!--{!! Form::Submit('Isi Semula', ['class'=>"btn btn-primary login-button btn-sm form-control"]) !!}-->
                        <a href="#"
                           class="btn btn-primary login-button btn-sm form-control disabled"
                           style="pointer-events:auto; cursor:pointer;"
                           onclick="resetLoginForm(this); return false;">
                           Isi Semula
                        </a>                           
                    </div>
                    
                    <div class="register">
                        <p style="color: white;">Belum mempunyai akaun ? <a href="{{ route('client_register') }}">@lang('Daftar di sini')</a></p>
                    </div>
                </div>
                {!! Form::close() !!}
<footer>
        <div class="row">
            <div class="col-md-12 text-center text-light pt-3 stick-bottom">
                <p>@lang('Hak Cipta Terpelihara @ 2026 , Jabatan Pengairan Dan Saliran Negeri Selangor <br>
                Paparan terbaik menggunakan pelayar Google Chrome dengan resolusi skrin 1280x768')</p>
            </div>

        </div>
         <p class="footerForMobile">Hak Cipta Terpelihara @ 2026 , Jabatan Pengairan Dan Saliran Negeri Selangor
             Paparan terbaik menggunakan pelayar Google Chrome dengan resolusi skrin 1280x768
        </p>
</footer>       
<!-- Contact Us Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen"> <!-- Fullscreen Modal -->
        <div class="modal-content mt-3">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">@lang('app.contact_support')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Custom Styling Container -->
                <div class="ag-format-container">
                    <h2 class="text-center">@lang('Hubungi Kami')</h2>

                    <div class="ag-courses_box d-flex flex-wrap justify-content-center">
                        <!-- Address Section -->
                        <div class="ag-courses_item"  style="min-width: 469px;">
                            <a href="#" class="ag-courses-item_link">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title mb-3">
                                    <img src="{{asset('assets/images/icon/pin.png')}}" width="10%">
                                    @lang('app.address')
                                </div>
                                <div class="ag-courses-item_date-box">
                                    <div style="margin-bottom: 15px;">
                                        <span style="color: #0d6efd; font-weight: 600; font-size: 16px;">
                                            Jabatan Pengairan dan Saliran Negeri Selangor
                                        </span>
                                    </div>
                                    <div>
                                        <span class="ag-courses-item_date" style="color: #888; line-height: 1.6;">
                                            Tingkat 5, Podium Selatan, Bangunan Sultan Salahuddin Abdul Aziz Shah, 40626 Shah Alam, Selangor.
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Phone Section -->
                        <div class="ag-courses_item" style="min-width: 469px; flex: 1 1 400px;">
                            <a href="#" class="ag-courses-item_link">
                                <div class="ag-courses-item_bg"></div>
                                <div class="ag-courses-item_title mb-3">
                                    <img src="{{asset('assets/images/icon/support.png')}}" width="10%">
                                    @lang('Telefon')
                                </div>
                                <div class="ag-courses-item_date-box" style="padding: 20px;">
                                    <div style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                        <i class="fas fa-phone" style="font-size: 18px; margin-right: 12px; color: #333; flex-shrink: 0;"></i>
                                        <div style="flex: 1; overflow-wrap: break-word;">
                                            <span class="ag-courses-item_date">603-5544 7376 / 7586 / 7381 603-5521 2204 / 2205 / 2207</span>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                        <i class="fas fa-fax" style="font-size: 18px; margin-right: 12px; color: #333; flex-shrink: 0;"></i>
                                        <div style="flex: 1; overflow-wrap: break-word;">
                                            <span class="ag-courses-item_date">603-5510 4494 / 5510 2911</span>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: flex-start;">
                                        <i class="fas fa-envelope" style="font-size: 18px; margin-right: 12px; color: #333; flex-shrink: 0;"></i>
                                        <div style="flex: 1; overflow-wrap: break-word;">
                                            <span class="ag-courses-item_date" style="color: #ff6600;">ecp@selangor.gov.my</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Google Map -->
                <div class="text-center mt-3">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d831.3055878343583!2d101.5151222!3d3.0835306999999985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc527aecf7d7db%3A0x63f9c30732d0a1f9!2sBangunan%20Sultan%20Salahuddin%20Abdul%20Aziz%20Shah!5e0!3m2!1sen!2sin!4v1739774441278!5m2!1sen!2sin" width="85%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Modal -->
<div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen mt-3">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: #000"><i class="fa fa-question-circle"></i> @lang('app.faq')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <section class="pb-5">
                    <div class="container" style="width: 99%;">
                        <div id="accordion" class="mb-5">
                            @php
                                $faqs = DB::table('faqs')->where('status', 1)->orderBy('id', 'asc')->get();
                            @endphp
                            
                            @if($faqs->count() > 0)
                                @foreach($faqs as $index => $faq)
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="card-link accordion-title {{ $index == 0 ? '' : 'collapsed' }}" 
                                               data-toggle="collapse" 
                                               href="#collapse{{ $faq->id }}">
                                                <h6>{{ $index + 1 }}. {{ $faq->question }}</h6>
                                            </a>
                                        </div>
                                        <div id="collapse{{ $faq->id }}" 
                                             class="collapse {{ $index == 0 ? 'show' : '' }}" 
                                             data-parent="#accordion">
                                            <div class="card-body">
                                                <p>{{ $faq->answer }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> No FAQs available at the moment.
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
</div>
<!--search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">@lang('app.checking_and_paying')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterSearchForm" class="filterform" method="POST" action="{{ route('applications.search') }}">
                     @csrf
            
                    <!-- State (Pre-selected Selangor and readonly) -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="state" class="col-md-3 col-form-label">@lang('app.state'):</label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" id="negeri" name="state" readonly disabled style="background-color: #f8f9fa; cursor: not-allowed;">
                                <option value="1" selected>Selangor</option>
                            </select>
                            <!-- Hidden input to ensure the value is submitted -->
                            <input type="hidden" name="state" value="1">
                        </div>
                    </div>
            
                    <!-- District -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="district" class="col-md-3 col-form-label">@lang('app.district'):</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group inlin">
                                <select class="form-control" id="daerah" name="district">
                                    <option value="">Loading districts...</option>
                                </select>
                            </div>
                            <div class="text-dangerr" id="district"></div>
                        </div>
                    </div>
                    
                    <!-- Division / Mukim -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="division" class="col-md-3 col-form-label">@lang('app.division'):</label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group inlin">
                                <select class="form-control" id="mukim" name="division">
                                    <option value="">@lang('--Sila Pilih--')</option>
                                </select>
                            </div>
                            <div class="text-dangerr" id="division"></div>
                        </div>
                    </div>
            
                    <!-- Applicant Name -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="applicant_name" class="col-md-3 col-form-label text-nowrap">
                                Nama Pemohon:
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="applicant_name" class="form-control" value="{{ request('applicant_name') }}" placeholder="Masukkan Nama">
                        </div>
                    </div>
            
                    <!-- Lot Number -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="lot_number" class="col-md-3 col-form-label">@lang('app.lot_pt'):</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="lot_number" class="form-control" value="{{ request('lot_number') }}" placeholder="Enter lot number">
                        </div>
                    </div>

                    <!-- Reference Number -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="reference_no" class="col-md-3 col-form-label text-nowrap">
                                No. Rujukan:
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="reference_no" class="form-control" value="{{ request('reference_no') }}" placeholder="Masukkan No. Rujukan">
                        </div>
                    </div>

                   <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="captcha" class="col-md-3 col-form-label">@lang('app.captcha'):</label>
                        </div>    
                        <div class="col-md-9">
                            <div class="d-flex align-items-center gap-2">
                                <div class="captcha-image" id="captchaImage" style="width: 120px; height: 50px; background: linear-gradient(135deg, #f0f0f0, #e0e0e0); border: 2px solid #ccc; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-family: 'Courier New', monospace; font-weight: bold; font-size: 18px; letter-spacing: 3px; color: #333; text-shadow: 1px 1px 2px rgba(0,0,0,0.3); position: relative; overflow: hidden;">
                                    <span id="captchaText">LOADING</span>
                                </div>
                                <button type="button" class="btn btn-outline-secondary refresh-btn" id="refreshCaptcha" title="@lang('app.refresh_captcha')" style="min-width: 40px; height: 40px;">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                            <div class="d-flex mt-2">
                                <input type="text" class="form-control" id="captcha" name="captcha" placeholder="@lang('app.enter_captcha')" maxlength="6" style="text-transform: uppercase;">
                            </div>
                            <div class="captcha-feedback mt-1" id="captchaFeedback" style="font-size: 0.875em;"></div>
                        </div>
                    </div>

                     <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fa fa-search"></i> @lang('app.search')
                        </button>&nbsp;&nbsp;
                        <button type="reset" class="btn btn-primary">
                            ↻ @lang('app.reset')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel" style="color:#000;">@lang('app.feedback')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="feedbackForm" method="POST" action="{{ route('feedback.submit') }}">
                            @csrf
                            
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="name" class="col-form-label">@lang('app.name'):<span class="important">*</span></label>
                                </div>    
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="@lang('app.name')" required>
                                </div>
                            </div>
                            
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3" style="white-space: nowrap;">
                                    <label for="email" class="col-form-label">@lang('app.email'):<span class="important">*</span></label>
                                </div>    
                                <div class="col-md-9">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="@lang('app.email')" required>
                                </div>
                            </div>
                            
                            <div class="row align-items-center mb-3" style="white-space: nowrap;">
                                <div class="col-md-3">
                                    <label for="telephone" class="col-form-label">@lang('app.telephone_no'):<span class="important">*</span></label>
                                </div>    
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="telephone" id="telephone" placeholder="@lang('app.telephone_no')" required>
                                </div>
                            </div>
                            
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="comment" class="col-form-label">@lang('app.comment'):<span class="important">*</span></label>
                                </div>    
                                <div class="col-md-9">
                                    <textarea rows="4" cols="50" name="comment" id="comment" class="form-control" placeholder="@lang('app.please_fill')" required></textarea>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label for="captcha" class="col-form-label">@lang('app.safety'):<span class="important">*</span></label>
                                </div>    
                                <div class="col-md-9">
                                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start gap-2">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> @lang('app.send')</button>&nbsp;&nbsp;
                                <button type="reset" class="btn btn-secondary">↻ @lang('app.reset')</button>
                            </div>      
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

<!-- Third Party Registration Modal -->
<div class="modal fade" id="thirdPartyRegisterModal" tabindex="-1" aria-labelledby="thirdPartyRegisterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="thirdPartyRegisterModalLabel" style="color:#000;">
                    <i class="fa fa-user-plus"></i> Borang Pendaftaran Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="thirdPartyRegisterMessage"></div>
                
                <form id="thirdPartyRegisterForm" method="POST" action="{{ route('third.party.register.submit') }}">
                    @csrf
                    
                    <!-- Name -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="tp_name" class="col-form-label">
                                Nama:<span class="text-danger">*</span>
                            </label>
                        </div>    
                        <div class="col-md-9">
                            <input type="text" 
                                   class="form-control" 
                                   id="tp_name" 
                                   name="name" 
                                   placeholder="" 
                                   required>
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="tp_email" class="col-form-label">
                                Emel:<span class="text-danger">*</span>
                            </label>
                        </div>    
                        <div class="col-md-9">
                            <input type="email" 
                                   class="form-control" 
                                   id="tp_email" 
                                   name="email" 
                                   placeholder="" 
                                   required>
                            <div class="invalid-feedback">Please enter a valid email.</div>
                        </div>
                    </div>

                    <!-- ID Card Number -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="tp_id_card" class="col-form-label">
                                No Kad Pengenalan/<wbr>No SSM:<span class="text-danger"></span>
                            </label>
                        </div>    
                        <div class="col-md-9">
                            <input type="text" 
                                   class="form-control" 
                                   id="tp_id_card" 
                                   name="id_card_number" 
                                   placeholder="" 
                                   >
                            <div class="invalid-feedback">Please enter your ID card number.</div>
                             <small class="form-text text-muted text-end d-block mt-1">
                                Kad Pengenalan Baru perlu (-)
                            </small>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="tp_address" class="col-form-label">
                                Alamat:<span class="text-danger">*</span>
                            </label>
                        </div>    
                        <div class="col-md-9">
                            <textarea class="form-control" 
                                      id="tp_address" 
                                      name="address" 
                                      rows="3" 
                                      placeholder="" 
                                      required></textarea>
                            <div class="invalid-feedback">Please enter your address.</div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="tp_password" class="col-form-label">
                                Kata Laluan:<span class="text-danger">*</span>
                            </label>
                        </div>    
                        <div class="col-md-9">
                            <div class="position-relative">
                                <input type="password" 
                                    class="form-control" 
                                    id="tp_password" 
                                    name="password" 
                                    placeholder="" 
                                    minlength="8"
                                    required>
                                <i class="bi bi-eye-slash toggle-password mb-2" 
                                data-target="tp_password" 
                                style="position: absolute; right: 15px; top: 25%; transform: translateY(-50%); cursor: pointer; cursor: pointer; z-index: 10;"></i>
                            </div>
                            <small class="form-text text-muted">Minimum 8 aksara</small>
                            <div class="invalid-feedback">Password must be at least 8 characters.</div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3">
                            <label for="tp_confirm_password" class="col-form-label">
                                Tetapkan Kata Laluan:<span class="text-danger">*</span>
                            </label>
                        </div>    
                        <div class="col-md-9">
                             <div class="position-relative">
                                <input type="password" 
                                    class="form-control" 
                                    id="tp_confirm_password" 
                                    name="confirm_password" 
                                    placeholder="Re-enter password" 
                                    minlength="8"
                                    required>
                                <i class="bi bi-eye-slash toggle-password" 
                                data-target="tp_confirm_password" 
                                style="position: absolute; right: 15px; top: 25%; transform: translateY(-50%); cursor: pointer; cursor: pointer; z-index: 10;"></i>
                            </div>
                            <div class="invalid-feedback">Passwords do not match.</div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary" id="tp_submit_btn">
                            <i class="fa fa-user-plus"></i> Daftar
                        </button>
                        <button type="reset" class="btn btn-secondary" id="tp_reset_btn">
                            <i class="fa fa-refresh"></i> lsi Semula
                        </button>
                    </div>
                   
                    <!-- Already have account link -->
                    <div class="text-center mt-3">
                        <p>Sudah mempunyai akaun? 
                            <a href="{{ route('third.party.login') }}">
                                Log masuk disini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
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
$(document).ready(function() {
    
    let formIsReady = false; 

    function loadSelangorDistricts() {
        const stateId = 1; 
        $('#daerah').html('<option value="">Loading districts...</option>');
        $('#mukim').html('<option value="">-- Sila Pilih --</option>');

        formIsReady = false;
        $.ajax({
            url: `/clientarea/register-districts/${stateId}`,
            type: 'GET',
            success: function (data) {
                let options = '<option value="">Sila Pilih Daerah</option>';
                data.forEach(district => {
                    options += `<option value="${district.iddaerah}">${district.daerah_code} - ${district.daerah}</option>`;
                });
                $('#daerah').html(options);
                formIsReady = true;
            },
            error: function () {
                $('#daerah').html('<option value="">Error loading districts</option>');
                formIsReady = true;
            }
        });
    }

    loadSelangorDistricts();

    // when district changes -> get divisions/mukim (keeping existing functionality)
    $('#daerah').on('change', function () {
        const districtId = $(this).val();
        $('#mukim').html('<option value="">Loading...</option>');

        if (districtId) {
            formIsReady = false;
            $.ajax({
                url: `/divisions/${districtId}`,
                type: 'GET',
                success: function (data) {
                    let options = '<option value="">Sila Pilih Mukim</option>';
                    data.forEach(division => {
                        options += `<option value="${division.idmukim}">${division.mukim_code} - ${division.mukim}</option>`;
                    });
                    $('#mukim').html(options);
                    formIsReady = true;
                },
                error: function (xhr) {
                    console.error('Error loading divisions:', xhr);
                    $('#mukim').html('<option value="">Error loading divisions</option>');
                    formIsReady = true;
                }
            });
        } else {
            $('#mukim').html('<option value="">-- Sila Pilih --</option>');
            formIsReady = true;
        }
    });


    let currentCaptcha = '';
    
    // Generate random CAPTCHA
    function generateCaptcha() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        const colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FECA57', '#FF9FF3', '#54A0FF'];
        
        for (let i = 0; i < 6; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        
        currentCaptcha = result;
        
        // Apply random styling
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        const randomRotation = (Math.random() - 0.5) * 10; // -5 to 5 degrees
        const randomBackground = `linear-gradient(${Math.random() * 360}deg, #f0f0f0, #e0e0e0)`;
        
        $('#captchaImage').css('background', randomBackground);
        $('#captchaText').text(result).css({
            'color': randomColor,
            'transform': `rotate(${randomRotation}deg)`
        });
        
        // Clear previous feedback and input
        $('#captcha').val('');
        $('#captchaFeedback').removeClass('success error').text('');
        
    }
    
    // Refresh CAPTCHA button
    $('#refreshCaptcha').on('click', function() {
        $(this).addClass('fa-spin');
        setTimeout(() => {
            $(this).removeClass('fa-spin');
            generateCaptcha();
        }, 500);
    });
    
    // Real-time CAPTCHA validation
    $('#captcha').on('input', function() {
        const userInput = $(this).val().toUpperCase();
        const feedback = $('#captchaFeedback');
        
        if (userInput.length === 0) {
            feedback.removeClass('success error').text('');
        } else if (userInput === currentCaptcha) {
            feedback.removeClass('error').addClass('success').text('✓ CAPTCHA verified');
        } else if (currentCaptcha.startsWith(userInput)) {
            feedback.removeClass('success error').text('Keep typing...');
        } else {
            feedback.removeClass('success').addClass('error').text('✗ CAPTCHA does not match');
        }
    });
    
    // Form submission validation
   $('#filterSearchForm').on('submit', function(e) {
        e.preventDefault();
        
        // CAPTCHA validation
        const userInput = $('#captcha').val().toUpperCase();
        if (userInput !== currentCaptcha) {
            $('#captchaFeedback').removeClass('success').addClass('error').text('✗ Please enter correct CAPTCHA');
            $('#captcha').focus();
            return false;
        }
        
        // Collect form data (state will always be 1 for Selangor)
        const formData = {
            state: 1, 
            district: $('#daerah').val(),
            division: $('#mukim').val(),
            applicant_name: $('input[name="applicant_name"]').val(),
            lot_number: $('input[name="lot_number"]').val(),
            _token: $('input[name="_token"]').val() 
        };
        
        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Searching...').prop('disabled', true);
        
        // Send AJAX request
        $.ajax({
            url: "{{ route('applications.search') }}", // You'll need to define this route
            type: 'POST',
            data: formData,
            success: function(response) {
                // Redirect to results page or update current page
                window.location.href = "{{ route('search.results') }}?" + $.param(formData);
            },
            error: function(xhr) {
                console.error('Search error:', xhr);
                alert('Search failed. Please try again.');
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Reset button functionality - reload Selangor districts
    $('button[type="reset"]').on('click', function(e) {
        e.preventDefault();
        
        // Clear form fields but keep state as Selangor
        $('input[name="applicant_name"]').val('');
        $('input[name="lot_number"]').val('');
        $('input[name="reference_no"]').val('');
        $('#captcha').val('');
        $('#captchaFeedback').removeClass('success error').text('');
        
        // Reload districts for Selangor
        loadSelangorDistricts();
        
        // Generate new CAPTCHA
        generateCaptcha();
    });
    
    // Generate initial CAPTCHA when page loads
    generateCaptcha();
    
    // Auto-refresh CAPTCHA every 5 minutes for security
    setInterval(generateCaptcha, 300000);

    // If modal is used, reload districts when modal opens
    $('#searchModal').on('shown.bs.modal', function () {
        if ($('#daerah option').length <= 1) {
            loadSelangorDistricts();
        }
    });
});
</script>

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

    var stars = [], // Array that contains the stars
        FPS = 60, // Frames per second
        x = 100, // Number of stars
        mouse = {
          x: 0,
          y: 0
        };  // Mouse location

    // Push stars to array
    for (var i = 0; i < x; i++) {
        stars.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            radius: Math.random() * 1 + 1,
            vx: Math.floor(Math.random() * 50) - 25,
            vy: Math.floor(Math.random() * 50) - 25
        });
    }

    // Draw the scene
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

    // Update star locations
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
     // Password toggle functionality - KEEP THIS ONE
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
<script>
    // Third Party Registration Form Validation
    document.getElementById('thirdPartyRegisterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        document.getElementById('thirdPartyRegisterMessage').innerHTML = '';
        const password = document.getElementById('tp_password').value;
        const confirmPassword = document.getElementById('tp_confirm_password').value;
        if (password !== confirmPassword) {
            document.getElementById('thirdPartyRegisterMessage').innerHTML = 
                '<div class="alert alert-danger">Passwords do not match!</div>';
            document.getElementById('tp_confirm_password').classList.add('is-invalid');
            return false;
        }
        document.getElementById('tp_confirm_password').classList.remove('is-invalid');
        
        // Show loading state
        const submitBtn = document.getElementById('tp_submit_btn');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Registering...';
    
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('thirdPartyRegisterMessage').innerHTML = 
                    '<div class="alert alert-success">' + data.message + '</div>';
                document.getElementById('thirdPartyRegisterForm').reset();
                setTimeout(() => {
                    window.location.href = '{{ route("third.party.login") }}';
                }, 2000);
            } else {
                let errorMsg = '<div class="alert alert-danger"><ul class="mb-0">';
                if (data.errors) {
                    Object.values(data.errors).forEach(error => {
                        errorMsg += '<li>' + error + '</li>';
                    });
                } else {
                    errorMsg += '<li>' + data.message + '</li>';
                }
                errorMsg += '</ul></div>';
                document.getElementById('thirdPartyRegisterMessage').innerHTML = errorMsg;
            }
        })
        .catch(error => {
            document.getElementById('thirdPartyRegisterMessage').innerHTML = 
                '<div class="alert alert-danger">An error occurred. Please try again.</div>';
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });
</script>
<script>
    document.getElementById('tp_reset_btn').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('thirdPartyRegisterForm').reset();
        document.getElementById('thirdPartyRegisterMessage').innerHTML = '';
    
        document.querySelectorAll('#thirdPartyRegisterForm .is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('#thirdPartyRegisterForm .is-valid').forEach(el => {
            el.classList.remove('is-valid');
        });
    });
</script>
<script>
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        // Check if reCAPTCHA is completed
        if (grecaptcha.getResponse() === '') {
            e.preventDefault();
            alert('Sila lengkapkan reCAPTCHA.');
            return false;
        }
    });

    // Reset reCAPTCHA when modal is closed
    $('#feedbackModal').on('hidden.bs.modal', function () {
        grecaptcha.reset();
        document.getElementById('feedbackForm').reset();
    });

    // Show success/error messages
    @if(session('success'))
        $('#feedbackModal').modal('hide');
        alert('{{ session('success') }}');
    @endif

    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
</script>
</body>
</html>

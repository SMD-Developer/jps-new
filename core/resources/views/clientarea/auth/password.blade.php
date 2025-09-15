<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ get_company_name() }} | {{ trans('app.login') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ image_url('favicon.png') }}">
    {!! Html::style(asset('assets/css/font-awesome.min.css')) !!}
    {!! Html::style(asset('assets/css/bootstrap.min.css')) !!}
    {!! Html::style(asset('assets/css/theme.min.css')) !!}
    {!! Html::style(asset('assets/plugins/amaranjs/css/amaran.min.css')) !!}
    {!! Html::style(asset('assets/css/style.css')) !!}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JPS LOGIN PAGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        .navbar {
            font-family: "Poppins", sans-serif;
            background-color: #80A5D0 !important;
            /* Semi-transparent background */
            width: 100%;
            /* Ensure it spans full width */
            height: 25px;
        }

        li.nav-item {
            font-size: 13px;
        }

        .nav-link {
            color: #fff !important;
        }

        .navbar-nav .nav-link {
            color: #fff;
            /*font-weight: bold;*/
            padding: 8px 15px;
        }

        .navbar-nav .nav-link:hover {
            color: #337ABB;
            /* Matches your existing blue theme */
            background-color: rgba(0, 0, 0, 0.1);
            /* Subtle hover effect */
            border-radius: 5px;
            height: 30px;
        }

        .navbar-brand img {
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .navbar-nav .nav-link {
                text-align: center;
                padding: 10px;
            }
        }

        body {
            font-family: "Poppins", sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            margin: 5px 0;
            line-height: 20px;
        }

        p {
            font-size: 13px;
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

        .sticky-bottom {
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

        .login-page,
        .register-page {
            height: auto;
        }

        .btn-outline-light {
            display: none;
        }

        ecap. {
            font-family: "Poppins", sans-serif;
        }

        form.loginFrm.needs-validation {
            padding: 0 20px;
        }

        body {
            background-image: url("https://jpsonline.smddeveloper.com/assets/images/JPS logo.jpg");
            background-size: cover;
            /* Ensures the image covers the entire screen */
            background-position: center;
            /* Centers the image */
            background-repeat: no-repeat;
            /* Prevents the image from repeating */
            background-attachment: fixed;
            /* Keeps the image fixed during scrolling */
            margin: 0;
            height: 100vh;
            width: 100vw;
            /* Ensures the width is full screen */
            overflow: hidden;
            /* Prevents scrolling if unnecessary */
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

            .h2,
            h2 {
                font-size: 1.83rem;
            }
        }

        #canvas {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
            /* Ensures it's behind other elements */
            width: 100%;
            height: 100%;
            pointer-events: none;
            /* Prevents interference with user interactions */
            border: none;
            /* Remove border */
            margin: 0;
        }

        .form-check {
            font-size: 15px;
        }

        .filterform {
            padding: 20px 45px;
            border: 1px solid #DDDDDD;
            border-radius: 5px;
        }

        .modal-dialog.modal-lg {
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

        button.btn.btn-warning {
            background: #5B90E1;
            border: 1px solid #5B90E1;
        }

        /* Style for reset password button */

        input.btn.btn-primary.form-control.disabled {
            background: #2c2cb7;
            border-radius: 15px;
            border: 2px solid #cecece;
            width: auto;
        }

        input.btn.btn-primary.form-control {
            background: #2c2cb7;
            border-radius: 15px;
            border: 2px solid #cecece;
            width: auto;
        }

        a.pull-right {
            color: #fff;
        }

        .form-select {
            font-size: 13px;
        }

        .form-control {
            font-size: 13px;
        }

        input#captcha {
            margin: 0px 5px 0px 0px;
        }
    </style>
</head>

<body class="login-page">
    <canvas id="canvas"></canvas>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <!--<a class="navbar-brand" href="{{ url('/') }}">-->
            <!--    <img src="{{ asset('assets/images/selangor.png') }}" alt="Logo" width="40">-->
            <!--</a>-->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal"><i
                                class="fa fa-search"></i> @lang('app.search_c')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-book"></i> @lang('app.users_manual')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-question-circle"></i> @lang('app.frequently_asked_questions_(faq)')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-comments"></i> @lang('app.feedback')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-phone"></i> @lang('app.contact_us')</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid ps-0 mt-5">
        <div class="row ">
            <div class="col-md-2 col-5 pe-0 icon-text ">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/selangor.png') }}" class="img-fluid" alt="Responsive image">
                </a>
            </div>
            <div class="col-md-10 col-7 portal icon-text ecap">
                <h2 class="">@lang('PORTAL e-CP (CARUMAN PARIT)')</h2>
                <h3>@lang('JPS NEGERI SELANGOR')</h3>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-2 ">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }} 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Notification -->
                @if ($errors->has('email'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first('email') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="col-md-4 col-9 icon-text2 pt-4 pb-0 mb-0 mt-3">
                {!! Form::open(['route' => 'client.password.email']) !!}
                <div class="input-box email">
                    {!! Form::input('email', 'email', null, [
                        'class' => 'form-control',
                        'required',
                        'placeholder' => trans('app.email'),
                    ]) !!}
                </div>
                <div class="input-box login mt-3">
                    {!! Form::submit(trans('app.reset_password'), ['class' => 'btn btn-primary form-control']) !!}
                </div>
                <!-- ... rest of your form ... -->
                {!! Form::close() !!}
                <div class="row mt-5">
                    <div class="col-md-12  text-center text-light pt-3 sticky-bottom">
                        <p>@lang('Hak Cipta Terpelihara @ 2024 , Jabatan Pengairan Dan Saliran Negeri Selangor <br>
                                                                                        Paparan terbaik menggunakan pelayar Google Chrome dengan resolusi skrin 1280x768')</p>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchModalLabel">Semakan dan Bayar Bil Caruman Parit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="filterSearchForm" class="filterform">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('app.tax_review'):</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="taxCheck"
                                                    id="taxLand" value="Hakmilik Tanah" checked>
                                                <label class="form-check-label"
                                                    for="taxLand">@lang('app.land_title')</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="taxCheck"
                                                    id="taxStrata" value="Hakmilik Strata">
                                                <label class="form-check-label"
                                                    for="taxStrata">@lang('app.strata_ownership')</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="taxCheck"
                                                    id="taxAccount" value="No. Akaun / ID Hakmilik">
                                                <label class="form-check-label"
                                                    for="taxAccount">@lang('app.no_account_ownership_id')</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-3">
                                            <label for="state"
                                                class="col-md-3 col-form-label">@lang('app.state'):</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="state">
                                                <option selected disabled>- Sila Pilih -</option>
                                                <option value="1">Selangor</option>
                                                <option value="2">District 2</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-3">
                                            <label for="district"
                                                class="col-md-3 col-form-label">@lang('app.district'):</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="district">
                                                <option selected disabled>- Sila Pilih -</option>
                                                <option value="1">District 1</option>
                                                <option value="2">District 2</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-3">
                                            <label for="city"
                                                class="col-md-3 col-form-label">@lang('app.city'):</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="city">
                                                <option selected disabled>- Sila Pilih -</option>
                                                <option value="1">City 1</option>
                                                <option value="2">City 2</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-3">
                                            <label for="lot"
                                                class="col-md-3 col-form-label">@lang('app.no_lot_pt'):</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select" id="lot">
                                                <option selected disabled>- Sila Pilih -</option>
                                                <option value="1">Lot 1</option>
                                                <option value="2">Lot 2</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-3">
                                            <label for="ownershipNumber"
                                                class="col-md-3 col-form-label">@lang('app.no_ownership'):</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="ownershipNumber"
                                                placeholder=" @lang('app.no_ownership') ">
                                        </div>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-3">
                                            <label for="captcha"
                                                class="col-md-3 col-form-label">@lang('app.captcha'):</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class=" gap-2">
                                                <div class="captcha-image"
                                                    style="width: 50%; height: 50px; background: #e9ecef; text-align: center; display: flex; align-items: center; justify-content: center;">
                                                    <span>A P Q B</span>
                                                </div>
                                                <div class="d-flex" style="align-items: baseline;">
                                                    <input type="text" class="form-control mt-1" id="captcha"
                                                        placeholder=" @lang('app.captcha') ">
                                                    <button type="button"
                                                        class="btn btn-outline-secondary">↻</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i>
                                            @lang('app.search')</button>&nbsp;&nbsp;
                                        <button type="reset" class="btn btn-primary">↻ @lang('app.reset')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
        <script>
            $(function() {
                $('form').validator();
                // $.backstretch("{{ $bg }}");
            });
        </script>
        @if (session()->has('flash_notification'))
            <?php
            $notification = session()->pull('flash_notification')[0];
            $message_type = $notification->level;
            ?>
            @if ($message_type === 'success')
                <script>
                    $.amaran({
                        'theme': 'awesome ok',
                        'content': {
                            title: 'Success !',
                            message: '{{ $notification->message }}!',
                            info: '',
                            icon: 'fa fa-check-square-o'
                        },
                        'position': 'bottom right',
                        'outEffect': 'slideBottom'
                    });
                </script>
            @elseif($message_type === 'danger')
                <script>
                    $.amaran({
                        'theme': 'awesome error',
                        'content': {
                            title: 'Error !',
                            message: '{{ $notification->message }}!',
                            info: '',
                            icon: 'fa fa-times-circle-o'
                        },
                        'position': 'bottom right',
                        'outEffect': 'slideBottom'
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
                }; // Mouse location

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

</body>

</html>

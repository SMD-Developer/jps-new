@section('content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
    @if (count($errors) > 0)
        {!! form_errors($errors) !!}
    @endif
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
    <!--<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
    
     .navbar {
     font-family: "Poppins", sans-serif;
    background-color: #80A5D0 !important; /* Semi-transparent background */
    width: 100%; /* Ensure it spans full width */
    height: 25px;
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

@media (max-width: 768px) {
    .navbar-nav .nav-link {
        text-align: center;
        padding: 10px;
    }
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
body, html {
    min-height: 100vh; /* Ensures full height */
    display: flex;
    flex-direction: column;
}

body {
     font-family: "Poppins", sans-serif;
}

            .portal {
            display: flex;
            flex-direction: column;
            justify-content: end;
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
            z-index: 9999;
        }

.container-fluid {
    min-height: 100vh; /* Ensures it takes at least full screen height */
    /*display: flex;*/
    flex-direction: column;
}
.container-fluid {
    flex: 1; /* Pushes footer to bottom */
}
.sticky-bottom {
    position: fixed; /* Ensures footer is positioned at the bottom of content */
    bottom: 0;
    left: 0;
    width: 100vw; /* Ensures full width */
    background-color: rgba(0, 0, 0, 0.2); /* Darker background for better visibility */
    color: white;
    padding: 10px 0;
    text-align: center;
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
            padding: 8px 8px 8px 15px;
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

form.loginFrm.needs-validation {
    padding: 0 20px;
}
input.btn.btn-primary.login-button.btn-sm.form-control.disabled {
    background: #2c2cb7;
    border-radius: 50px;
    border: 2px solid #cecece;
    font-size: inherit;
}
body {
    background-image: url("https://jpsonline.smddeveloper.com/assets/images/JPS logo.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    margin: 0;
    min-height: 100vh;
    width: 100%; /* Changed from 100vw to 100% */
    overflow-x: hidden; /* Prevents horizontal scroll but allows vertical */
}


@media (max-width: 768px) {
  body {
    /*background-size: contain; */
    
    /*background-attachment: scroll;*/
    
  }
}

form.loginFrm.needs-validation {
    padding: 0 20px;
}
input.btn.btn-primary.form-control.disabled {
    background: #2c2cb7;
    border-radius: 15px;
    border: 2px solid #cecece;
    /*padding: 5px 0px 9px 0px;*/
    width: auto;
}
a.pull-right {
    color: #fff;
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
}
#canvas {
    position: fixed;
    top: 0;
    left: 0;
    z-index: -1; /* Ensures it's behind other elements */
    width: 100%;
    height: 100%;
    pointer-events: none; /* Prevents interference with user interactions */
    border: none; /* Remove border */
    margin: 0;
}
input.btn.btn-primary.form-control {
    background: #2c2cb7;
    border-radius: 15px;
    border: 2px solid #cecece;
    /* padding: 5px 0px 9px 0px; */
    width: auto;
}
</style>

</head>

<body class="login-page">
    <canvas id="canvas"></canvas>
    <!--<div class="login-box">-->
    <!--    <div class="login-logo">-->
    <!--        {{get_company_name()}}-->
    <!--    </div>-->
    <!--    <div class="login-box-body bg-white p-4">-->
    <!--        @yield('content')-->
    <!--    </div>-->
    <!--    <section class="panel-footer">-->
    <!--        <a href="{{ url('password/reset') }}">@lang('app.lost_password')</a>-->
    <!--    </section>-->
    <!--</div>-->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="collapse navbar-collapse">
        <!--<a class="navbar-brand" href="{{ url('/') }}">-->
        <!--    <img src="{{ asset('assets/images/selangor.png') }}" alt="Logo" width="40">-->
        <!--</a>-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i> @lang('app.search_c')</a>
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
                <a href="{{url('/')}}">
                    <img src="{{ asset('assets/images/selangor.png') }}" class="img-fluid" alt="Responsive image">
                </a>    
            </div>
            <div class="col-md-10 col-7 portal icon-text ecap" style="justify-content: center;">
                <h2 class="">PORTAL e-CP (CARUMAN PARIT)</h2>
                <h3>JPS NEGERI SELANGOR</h3>
            </div>
        </div>
        <div class="row mt-5">
                <div class="col-md-2 "></div>
                <div class="col-md-4 col-9 icon-text2 pt-4 pb-0 mb-0 mt-3">
                    <!--<p class="text-center text-light"><b>Log Masuk</b></p>-->
                     {!! Form::open(['url' => '/password/email']) !!}
                     <h6>{{trans('app.reset_password')}}</h6>
                    <div class="input-box password">
                            <!--<label for="password">{{ trans('app.new_password') }}</label>-->
                            <div style="position: relative;">
                                <input id="password" name="password" type="password" class="form-control mt-2" placeholder="{{ trans('app.new_password') }}">
                                <i class="bi bi-eye-slash toggle-password" data-target="password"></i>
                            </div>
                        </div>
                        
                        <div class="input-box password mt-3">
                            <!--<label for="confirm_password">{{ trans('app.new_password') }} ({{ trans('app.reset') }})</label>-->
                            <div style="position: relative;">
                                <input id="confirm_password" name="password_confirmation" type="password" class="form-control mt-2" placeholder="{{ trans('app.new_password') }} ({{ trans('app.reset') }})">
                                <i class="bi bi-eye-slash toggle-password" data-target="confirm_password"></i>
                            </div>
                            <div class="input-box login mt-3">
                                <a href="#" type="submit" class="btn btn-primary form-control">{{trans('app.go_ahead')}}</a>
                            </div>
                        </div>
                        
                        <!-- Password Validation Box -->
                        <div class="password-validation-box mt-3">
                            <p id="password-match-status" style="font-size: 14px; margin-top: 5px; color: red;">❌ {{ trans('app.passwords_do_not_match') }}</p>
                            <ul id="password-requirements" style="font-size: 14px; list-style: none; padding: 10px; margin-top: 5px;">
                                <li style="color: red;">❌ {{ trans('app.password_minimum') }} 8 {{ trans('app.too') }} 20 {{ trans('app.characters') }}</li>
                                <li style="color: red;">❌ {{ trans('app.uppercase_letter') }} (A-Z)</li>
                                <li style="color: red;">❌ {{ trans('app.lowercase_letter') }} (a-z)</li>
                                <li style="color: red;">❌ {{ trans('app.number') }} (0-9)</li>
                                <li style="color: red;">❌ {{ trans('app.no_spaces') }}</li>
                                <li style="color: red;">❌ {{ trans('app.special_character') }} (!@#$%)</li>
                                <li style="color: red;">❌ {{ trans('app.no_sequential_characters') }} (abc, 123)</li>
                            </ul>
                        </div>
                </div>
                <!--<div class="col-md-4 col-9 icon-text2 pt-4 pb-0 mb-0 mt-3" style="background-color: rgba(0, 0, 0, 0.2);">-->
                <!--    <ul id="password-requirements" style="font-size: 14px; list-style: none; padding: 0; margin-top: 10px;">-->
                <!--            <li style="color: red;">❌ Minimum 8 hingga maksimum 20 aksara</li>-->
                <!--            <li style="color: red;">❌ Huruf besar (A-Z)</li>-->
                <!--            <li style="color: red;">❌ Huruf kecil (a-z)</li>-->
                <!--            <li style="color: red;">❌ Nombor (0-9)</li>-->
                <!--            <li style="color: red;">❌ Kata laluan tidak boleh mengandungi jarak</li>-->
                <!--            <li style="color: red;">❌ Aksara simbol (!@#$%)</li>-->
                <!--            <li style="color: red;">❌ Tiada aksara berturut-turut (abc, 123)</li>-->
                <!--    </ul>-->
                <!--</div>-->
                <footer class="sticky-bottom">
                    <p>Hak Cipta Terpelihara @ 2024, Jabatan Pengairan Dan Saliran Negeri Selangor <br>
                    Paparan terbaik menggunakan pelayar Google Chrome dengan resolusi skrin 1280x768</p>
                </footer>

            </div>
        </div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");
    const passwordMatchStatus = document.getElementById("password-match-status");
    const validationList = document.getElementById("password-requirements");

    // Store translation messages from Blade into JS variables
    const passwordsMatchMsg = "{{ trans('app.passwords_match') }}";
    const passwordsNotMatchMsg = "{{ trans('app.passwords_do_not_match') }}";

    // Initially hide validation and match status
    validationList.style.display = "none";
    passwordMatchStatus.style.display = "none";

    // Select all eye icons
    document.querySelectorAll(".toggle-password").forEach(icon => {
        icon.addEventListener("click", function () {
            const targetInput = document.getElementById(this.getAttribute("data-target"));
            if (targetInput.type === "password") {
                targetInput.type = "text";
                this.classList.remove("bi-eye-slash");
                this.classList.add("bi-eye");
            } else {
                targetInput.type = "password";
                this.classList.remove("bi-eye");
                this.classList.add("bi-eye-slash");
            }
        });
    });

    // Live Password Validation
    passwordInput.addEventListener("input", function () {
        const password = passwordInput.value;

        if (password === "") {
            validationList.style.display = "none"; // Hide validation if empty
            return;
        } else {
            validationList.style.display = "block"; // Show validation if typing
        }

        const checks = {
            length: password.length >= 8 && password.length <= 20,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            noSpaces: !/\s/.test(password),
            specialChar: /[!@#$%^&*(),.?":{}|<>]/.test(password),
            noSequential: !/(?:123|abc|ABC|789)/.test(password),
        };

        validationList.innerHTML = `
            <li style="color: ${checks.length ? 'white' : 'red'};">${checks.length ? '✅' : '❌'} {{ trans('app.password_minimum') }} 8 {{ trans('app.too') }} 20 {{ trans('app.characters') }}</li>
            <li style="color: ${checks.uppercase ? 'white' : 'red'};">${checks.uppercase ? '✅' : '❌'} {{ trans('app.uppercase_letter') }} (A-Z)</li>
            <li style="color: ${checks.lowercase ? 'white' : 'red'};">${checks.lowercase ? '✅' : '❌'} {{ trans('app.lowercase_letter') }} (a-z)</li>
            <li style="color: ${checks.number ? 'white' : 'red'};">${checks.number ? '✅' : '❌'} {{ trans('app.number') }} (0-9)</li>
            <li style="color: ${checks.noSpaces ? 'white' : 'red'};">${checks.noSpaces ? '✅' : '❌'} {{ trans('app.no_spaces') }}</li>
            <li style="color: ${checks.specialChar ? 'white' : 'red'};">${checks.specialChar ? '✅' : '❌'} {{ trans('app.special_character') }} (!@#$%)</li>
            <li style="color: ${checks.noSequential ? 'white' : 'red'};">${checks.noSequential ? '✅' : '❌'} {{ trans('app.no_sequential_characters') }} (abc, 123)</li>
        `;
    });

    // Confirm Password Matching - Live Validation
    function checkPasswordMatch() {
        if (passwordInput.value === "" && confirmPasswordInput.value === "") {
            passwordMatchStatus.style.display = "none"; // Hide when both fields are empty
        } else {
            passwordMatchStatus.style.display = "block"; // Show when typing
            if (confirmPasswordInput.value === passwordInput.value) {
                passwordMatchStatus.textContent = "✅ " + passwordsMatchMsg;
                passwordMatchStatus.style.color = "white";
            } else {
                passwordMatchStatus.textContent = "❌ " + passwordsNotMatchMsg;
                passwordMatchStatus.style.color = "red";
            }
        }
    }

    passwordInput.addEventListener("input", checkPasswordMatch);
    confirmPasswordInput.addEventListener("input", checkPasswordMatch);
});
</script>

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
</body>

</html>
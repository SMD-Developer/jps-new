<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ get_company_name() }}</title>
    @if (get_setting_value('favicon') != '')
        <link rel="icon" type="image/png" sizes="16x16" href="{{ image_url(get_setting_value('favicon')) }}">
    @endif
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('assets/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.6.4.min.js') }}"></script>
    <style>
        .notification {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        .unread {
            background-color: #f8f9fa;
            /* Light grey for unread notifications */
        }

        .read {
            background-color: white;
            /* Default white after being read */
        }
    </style>
</head>

<body class="skin-blue layout-navbar-fixed control-sidebar-slide-open layout-fixed">
    <div class="wrapper animsition">
        <header class="main-header">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link sidebar-toggle" data-widget="pushmenu" href="#" role="button">
                            <i class="fa fa-home " style="font-size:20px;"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link text-uppercase text-white" data-toggle="dropdown">
                            <!--<img src="{{ image_url(current_language()['flag']) }}" class="language-img">-->
                            <!--{{ current_language()['lang']->locale_name ?? null }} <b class="caret"></b>-->
                            <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                            <?php $languages = get_languages(); ?>
                            @foreach ($languages as $language)
                                <?php $flag = $language->flag != '' ? $language->flag : 'placeholder_Flag.jpg'; ?>
                                <a class="dropdown-item" rel="alternate"
                                    href="{{ route('client_lang_switch', $language->short_name) }}">
                                    <!--<img src="{{ image_url($flag) }}" class="language-img">{{ $language->locale_name }}-->
                                    <img src="{{ image_url($flag) }}" class="language-img">
                                </a>
                            @endforeach
                        </div>
                    </li>
                    <li style="display: flex; align-items: center; position: relative;" class="nav-item">
                        <div style="position: relative; cursor: pointer;" id="notificationBell">
                            <i class="fa fa-bell" aria-hidden="true" style="color:#fff; font-size: 25px;"></i>

                            @php
                                $notificationCount = auth('user')->user()
                                    ? auth('user')->user()->unreadNotifications()->count()
                                    : 0;
                            @endphp
                            @if ($notificationCount > 0)
                                <span id="notificationCount" class="badge"
                                    style="position: absolute; top: -5px; right: -10px; background-color: #dc3545; color: #fff; 
                                    border-radius: 50%; padding: 2px 6px; font-size: 12px;">
                                    {{ $notificationCount }}
                                </span>
                            @endif
                        </div>

                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown"
                                style="display: none; position: absolute; top: 35px; left: 0; background: white; 
                                    width: 430px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); border-radius: 5px; z-index: 1000;">

                            <div
                                style="padding: 10px; font-weight: 600; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between;">
                                <span>@lang('app.notificationss')</span>
                            </div>

                            <ul id="notificationList" style="list-style: none; padding: 0; margin: 0;">
                                @if (auth('user')->check())
                                    @php
                                        $user = auth('user')->user();
                                        $notifications = $user->notifications()->take(5)->get();
                                    @endphp

                                    @forelse ($notifications as $notification)
                                        @php
                                            $redirectUrl = '#';
                                            if (isset($notification->data['type'])) {
                                                switch ($notification->data['type']) {
                                                    case 'application_approved':
                                                    case 'application_rejected':
                                                    case 'application_submitted':
                                                        $redirectUrl = isset($notification->data['application_id']) 
                                                            ? route('client_application_status')
                                                            : route('client_application_status');
                                                        break;
                                                        
                                                    case 'claim_status_update':
                                                        $redirectUrl = isset($notification->data['claim_id']) 
                                                          ? route('claim.contribution.list')
                                                            : route('claim.contribution.list');
                                                        break;
                                                        
                                                    default:
                                                        $redirectUrl = isset($notification->data['application_id']) 
                                                            ? route('client_application_status')
                                                            : route('client_application_status');
                                                        break;
                                                }
                                            } else {
                                                $redirectUrl = isset($notification->data['application_id']) 
                                                    ? route('client_application_status')
                                                            : route('client_application_status');
                                            }
                                        @endphp

                                        <li class="notification {{ $notification->read_at ? 'read' : 'unread' }}"
                                            data-id="{{ $notification->id }}"
                                            style="padding: 10px; border-bottom: 1px solid #ddd; cursor: pointer;">

                                            <a href="{{ $redirectUrl }}"
                                                style="text-decoration: none; color: inherit;">
                                                <strong>{{ $notification->data['message'] ?? 'No message' }}</strong>
                                                
                                                <p style="font-size: 12px; margin: 5px 0;">
                                                    @if(isset($notification->data['type']))
                                                        @switch($notification->data['type'])
                                                            @case('payment_success')
                                                            @case('payment_received')
                                                                <span style="color: #666;">Payment Status:</span> 
                                                                <span style="color: #28a745;">Success</span>
                                                                <br>
                                                                <span style="color: #666;">Amount:</span> 
                                                                RM {{ number_format($notification->data['amount'] ?? 0, 2) }}
                                                                @break
                                                                
                                                            @case('application_approved')
                                                                <span style="color: #666;">Status:</span> 
                                                                <span style="color: #28a745;">Diluluskan</span>
                                                                @break
                                                                
                                                            @case('application_rejected')
                                                                <span style="color: #666;">Status:</span> 
                                                                <span style="color: #dc3545;">Ditolak</span>
                                                                @if(isset($notification->data['reason']))
                                                                    <br>
                                                                    <span style="color: #666;">Reason:</span> 
                                                                    {{ Str::limit($notification->data['reason'], 50) }}
                                                                @endif
                                                                @break
                                                                
                                                            @case('claim_approved')
                                                                <span style="color: #666;">Claim Status:</span> 
                                                                <span style="color: #28a745;">Approved</span>
                                                                @break
                                                                
                                                            @case('claim_rejected')
                                                                <span style="color: #666;">Claim Status:</span> 
                                                                <span style="color: #dc3545;">Rejected</span>
                                                                @break
                                                                
                                                            @case('document_required')
                                                                <span style="color: #666;">Action Required:</span> 
                                                                <span style="color: #ffc107;">Upload Documents</span>
                                                                @break
                                                                
                                                            @default
                                                                <span style="color: #666;">Applicant:</span> 
                                                                {{ $notification->data['applicant'] ?? 'Unknown Applicant' }}
                                                        @endswitch
                                                    @else
                                                        <span style="color: #666;">Applicant:</span> 
                                                        {{ $notification->data['applicant'] ?? 'Unknown Applicant' }}
                                                    @endif
                                                </p>
                                                
                                                <span style="font-size: 11px; color: gray;">
                                                    {{ $notification->created_at->format('d/m/Y h:i A') }}
                                                </span>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-center" style="padding: 10px;">No notifications available</li>
                                    @endforelse
                                @else
                                    <li class="text-center" style="padding: 10px;">Please log in to see notifications</li>
                                @endif
                            </ul>

                            <div style="text-align: center; padding: 10px;">
                                <a href="{{ route('user_notification') }}"
                                    style="text-decoration: none; color: blue; font-weight: 600;">
                                    @lang('app.view_all')
                                </a>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown user user-menu">
                        <a href="#" class="nav-link text-uppercase text-white" data-toggle="dropdown">
                            @if (auth()->guard('user')->check())
                                <img src="{{ Auth::guard('user')->user()->photo != '' ? image_url('/assets/images/uploads/client_images/' . Auth::guard('user')->user()->photo) : image_url('uploads/defaultavatar.png') }}"
                                    class="user-image" alt="User Image" />
                                <strong><span>Selamat Datang,</span>
                                         @php
                                            // First check if user is logged in
                                            if(auth()->guard('user')->check()) {
                                                $userId = auth()->guard('user')->id();
                                                
                                                // Get the account type with error handling
                                                $accountRecord = DB::table('client_register')
                                                                ->where('client_id', $userId)
                                                                ->first();
                                                
                                                // Determine the account type text
                                                $accountTypeText = 'Default'; // Default value
                                                
                                                if($accountRecord && isset($accountRecord->accountType)) {
                                                    switch($accountRecord->accountType) {
                                                        case 1: $accountTypeText = 'Individu'; break;
                                                        case 2: $accountTypeText = 'Pemaju'; break;
                                                        case 3: $accountTypeText = 'Agensi Kerajaan'; break;
                                                        case 4: $accountTypeText = 'Perunding'; break;

                                                    }
                                                }
                                            }
                                        @endphp
                                    <span class="hidden-xs"> {{ auth()->guard('user')->user()->name }} </span>
                                   <span class="hidden-xs">({{ $accountTypeText ?? 'Default' }})</span>
                                </strong>
                            @endif
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header text-uppercase text-white">
                                @if (auth()->guard('user')->check())
                                    <img src="{{ Auth::guard('user')->user()->photo != '' ? image_url('/assets/images/uploads/client_images/' . Auth::guard('user')->user()->photo) : image_url('uploads/defaultavatar.png') }}"
                                        class="img-circle" alt="User Image" />
                                    <p>{{ auth()->guard('user')->user()->name }} </p>
                                @endif
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <!--<a href="{{ url('clientarea/cprofile') }}"-->
                                    <!--    class="btn btn-primary btn-sm btn-flat">{{ trans('app.edit_profile') }}</a>-->
                                    <a href="{{ route('update_profile', auth()->guard('user')->user()->uuid) }}"
                                            class="btn btn-primary btn-sm btn-flat">{{ trans('app.edit_profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('client_logout') }}"
                                        class="btn btn-danger btn-sm btn-flat">{{ trans('app.logout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        @include('clientarea.nav')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('content')
        </div><!-- /.content-wrapper -->
    </div><!-- ./wrapper -->
    <div id="ajax-modal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document"></div>
    </div>
    @include('partials.scripts')
    @yield('scripts')
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBell = document.getElementById('notificationBell');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const markAllRead = document.getElementById('markAllRead');

            // Toggle dropdown
            notificationBell.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.style.display = notificationDropdown.style.display === 'none' ?
                    'block' : 'none';
            });

            document.addEventListener('click', function() {
                notificationDropdown.style.display = 'none';
            });


            function updateNotificationCount() {
                $.ajax({
                    url: '{{ route('get.notification.count') }}',
                    method: 'GET',
                    success: function(response) {
                        $('#notificationCount').text(response.count);
                        if (response.count > 0) {
                            $('#notificationCount').show();
                        } else {
                            $('#notificationCount').hide();
                        }
                    },
                    error: function() {
                        console.error('Failed to fetch notification count');
                    }
                });
            }
            setInterval(updateNotificationCount, 30000);

            markAllRead.addEventListener('click', function(e) {
                e.preventDefault();

                fetch('/mark-notifications-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelectorAll('.notification.unread').forEach(el => {
                                el.classList.remove('unread');
                                el.classList.add('read');
                            });
                            document.getElementById('notificationCount').textContent = '0';
                        }
                    });
            });

            document.querySelectorAll('.notification').forEach(notification => {
                notification.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');

                    fetch(`/mark-notification-read/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                });
            });
        });
    </script>

    <script>
        let inactivityTime = function () {
            let warningTime;
            let logoutTime;
            
            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onscroll = resetTimer;
            document.onclick = resetTimer;
            document.ontouchstart = resetTimer;

            function showWarning() {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Sesi anda akan ditamatkan dalam masa 1 minit kerana tiada sebarang aktiviti',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Log Keluar',
                    timer: 900000,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        resetTimer();
                    } else if (result.dismiss === Swal.DismissReason.timer || result.dismiss === Swal.DismissReason.cancel) {
                        logout();
                    }
                });
            }

            function logout() {
                Swal.fire({
                    title: 'Tamat',
                    text: 'Anda telah log keluar kerana tidak aktif.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = "{{ route('client_logout') }}";
                });
            }

            function resetTimer() {
                clearTimeout(warningTime);
                clearTimeout(logoutTime);
                warningTime = setTimeout(showWarning, 840000); // 9 minutes
                logoutTime = setTimeout(logout, 900000); // 10 minutes
            }
        };

        window.onload = function() {
            inactivityTime();
        }
    </script>
<!--    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"-->
<!--    async defer>-->
<!--</script>-->
<!--<script type="text/javascript">-->
<!--  var onloadCallback = function() {-->
<!--    alert("grecaptcha is ready!");-->
<!--  };-->
<!--</script>-->
</body>

</html>

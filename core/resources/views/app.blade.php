<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ get_company_name() }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <script src="{{ asset('assets/js/jquery-3.6.4.min.js') }}"></script>
    <style>
        body {
            font-family: "poppins", sans-serif;
        }

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
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link text-uppercase text-white" data-toggle="dropdown"
                            style="display: flex;align-items: center;">
                            <!--<img src="{{ image_url(current_language()['flag']) }}" alt="flag" class="language-img" > -->
                            <!--{{ current_language()['lang']->locale_name ?? null }} <b class="caret"></b>-->
                            <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                            <?php $languages = get_languages(); ?>
                            @foreach ($languages as $language)
                                <?php $flag = $language->flag != '' ? $language->flag : 'placeholder_Flag.jpg'; ?>
                                <a class="dropdown-item" rel="alternate"
                                    href="{{ route('admin_lang_switch', $language->short_name) }}">
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
                                $notificationCount = auth('admin')->user()
                                    ? auth('admin')->user()->unreadNotifications()->count()
                                    : 0;
                            @endphp
                            @if ($notificationCount > 0)
                                <span id="notificationCount" class="badge notification-badge"
                                    style="position: absolute; top: -5px; right: -10px; background-color: #dc3545; color: #fff; 
                                      border-radius: 50%; padding: 2px 6px; font-size: 12px;">
                                    {{ $notificationCount }}
                                </span>
                            @endif
                        </div>

                        <!-- Notification Dropdown -->
                           <div id="notificationDropdown"
                            style="display: none; position: fixed; top: 60px; background: white; 
                                    width: auto; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); border-radius: 5px; z-index: 1000;">
                            <div
                                style="padding: 10px; font-weight: 600; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between;">
                                <span>@lang('app.notification')</span>
                            </div>

                            <ul id="notificationList" style="list-style: none; padding: 0; margin: 0;">
                                @if (auth('admin')->check())
                                    @php
                                        $user = auth('admin')->user();
                                        $notifications = collect();

                                        if ($user->role_id === '9e032984-8ef0-4e00-b7b9-439679a4d1aa') {
                                            $notifications = $user
                                                ->notifications()
                                                ->where('type', 'App\Notifications\AdminNewApplicationNotification')
                                                ->where('notifiable_type', 'App\Models\User')
                                                ->take(5)
                                                ->get();
                                        } else {
                                            $notifications = $user
                                                ->notifications()
                                                ->where('notifiable_type', 'App\Models\User')
                                                ->take(5)
                                                ->get();
                                        }
                                    @endphp

                                    @forelse ($notifications as $notification)
                                        <li class="notification {{ $notification->read_at ? 'read' : 'unread' }}"
                                            data-id="{{ $notification->id }}"
                                            style="padding: 10px; border-bottom: 1px solid #ddd; cursor: pointer;">

                                            <a href="{{ route('application_list') }}?id={{ $notification->data['application_id'] }}"
                                                style="text-decoration: none; color: inherit;">
                                                <strong>{{ $notification->data['message'] ?? 'No message' }}</strong>
                                                <p style="font-size: 12px; margin: 5px 0;">
                                                    {{ $notification->data['applicant'] ?? 'Unknown Applicant' }}
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
                                    <li class="text-center" style="padding: 10px;">Please log in to see notifications
                                    </li>
                                @endif
                            </ul>

                            <div style="text-align: center; padding: 10px;">
                                <a href="{{ route('notification') }}"
                                    style="text-decoration: none; color: blue; font-weight: 600;">
                                    @lang('app.view_all')
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown user user-menu">
                        <a href="#" class="nav-link text-uppercase text-white" data-toggle="dropdown"
                            style="display: flex;align-items: center;">
                            @if (auth('admin')->check())
                                <img src="{{ auth('admin')->user()->photo != '' ? image_url(auth('admin')->user()->photo) : image_url('uploads/defaultavatar.png') }}"
                                    class="user-image" alt="User Image" />
                                <strong><span>Selamat Datang,</span>
                                    <span class="hidden-xs"> {{ auth()->guard('admin')->user()->username }} </span>
                                    <span
                                        class="hidden-xs">({{ trans('app.' . get_role(auth()->guard('admin')->user()->role_id)) }})</span>
                                </strong>
                            @endif
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header text-uppercase text-white">
                                @if (auth()->guard('admin')->check())
                                    <img src="{{ auth('admin')->user()->photo != '' ? image_url(auth('admin')->user()->photo) : image_url('uploads/defaultavatar.png') }}"
                                        class="img-circle" alt="User Image" />

                                    <p>{{ auth('admin')->user()->name }} </p>
                                @endif
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('profile') }}"
                                        class="btn btn-primary btn-sm btn-flat">{{ trans('app.edit_profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('admin_logout') }}"
                                        class="btn btn-danger btn-sm btn-flat">{{ trans('app.logout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        @include('nav')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <div id="ajax-modal" class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1"
            role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document"></div>
        </div>
        <div class="modal fade" id="notificationsModal" tabindex="-1" role="dialog"
            aria-labelledby="notificationsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        @if (auth('admin')->check())
                            @php
                                $notifications = auth('admin')->user()->unreadNotifications;
                            @endphp

                            @forelse ($notifications as $notification)
                                <div class="dropdown-item" data-notification-id="{{ $notification->id }}"
                                    style="padding: 10px; border-bottom: 1px solid #eee;">
                                    <a href="{{ route('application_list') }}?id={{ $notification->data['application_id'] }}"
                                        style="color: #333; text-decoration: none; display: block;">
                                        {{ $notification->data['message'] ?? 'No message' }} <br>
                                        <small style="color: #666;">
                                            {{ $notification->data['applicant'] ?? 'Unknown Applicant' }} -
                                            {{ $notification->data['created_at'] ?? now()->format('Y-m-d H:i:s') }}
                                        </small>
                                    </a>
                                </div>
                            @empty
                                <div class="text-center" style="padding: 10px;">
                                    No new notifications
                                </div>
                            @endforelse
                        @else
                            <div class="text-center" style="padding: 10px;">
                                Please log in to see notifications
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @if (!is_verified())
            <div id="activation-modal" class="modal fade" role="dialog" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title"><i class="fa fa-lock"></i> Verification of the license</h6>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['url' => '/settings/verify', 'id' => 'verify_form']) !!}
                            <div class="row">
                                <div class=" col-xs-3 col-sm-3">
                                    <img src="{{ asset(config('app.images_path') . 'lock.png') }}" width="100%">
                                </div>
                                <div class="col-xs-9 col-sm-9 ">
                                    <div class="form-group">
                                        <label for="envato_username">Envato Username</label>
                                        <input type="text" class="form-control input-sm" required
                                            name="envato_username" id="envato_username"
                                            placeholder="Enter your envato username here" />
                                    </div>
                                    <div class="form-group">
                                        <label for="envato_username">Purchase Code</label>
                                        <input type="text" class="form-control input-sm" name="purchase_code"
                                            id="purchase_code" placeholder="Enter your purchase code here" />
                                        <span style="font-size:12px;"><a
                                                href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-"
                                                target="_blank">Where can I find my purchase code ?</a></span>
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:" onclick="checkLicense()"
                                            class="btn btn-sm btn-success"><span
                                                class="glyphicon glyphicon-check"></span>Verify</a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12">
                                    <div class="alert alert-info" style="font-size:12px;  margin-bottom: 0px;">
                                        <span class="glyphicon glyphicon-warning-sign"
                                            style="margin-right: 12px;float: left;font-size: 22px;margin-top: 10px;margin-bottom: 10px;"></span>
                                        Each website using this plugin needs a legal license (1 license = 1
                                        website).<br />
                                        To read find more information on envato licenses,
                                        <a href="https://codecanyon.net/licenses/standard" target="_blank">click
                                            here</a>.<br />
                                        If you need to buy a new license of this plugin, <a
                                            href="https://codecanyon.net/item/classic-invoicer/6193251?ref=elantsys"
                                            target="_blank">click here</a>.
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('partials.scripts')
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
    <li style="display: none; align-items: center; position: relative;" class="nav-item">
        @php
            $notificationCount = auth('admin')->user() ? auth('admin')->user()->unreadNotifications()->count() : 0;
        @endphp
        <a href="#" class="nav-link" data-toggle="modal" data-target="#notificationsModal"
            style="color: #fff; text-decoration: none; position: relative;">
            <i class="fa fa-bell" aria-hidden="true"></i>
            @if ($notificationCount > 0)
                <span id="notificationCount" class="badge"
                    style="position: absolute; top: -5px; right: -10px; background-color: #dc3545; color: #fff; border-radius: 50%; padding: 2px 6px; font-size: 12px;">
                    {{ $notificationCount }}
                </span>
            @endif
        </a>
    </li>
    <script>
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

        // Update count periodically
        setInterval(updateNotificationCount, 30000); // Every 30 seconds

        // Mark notification as read when clicked
        $(document).on('click', '#notificationsModal .dropdown-item a', function(e) {
            const notificationId = $(this).closest('.dropdown-item').data('notification-id');

            $.ajax({
                url: '{{ route('mark.notification.read') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    notification_id: notificationId
                },
                success: function() {
                    updateNotificationCount();
                    // Optionally, remove the notification from the modal
                    $(`[data-notification-id="${notificationId}"]`).remove();
                }
            });
        });
    </script>

    <script>
        document.getElementById('notificationBell').addEventListener('click', function() {
            let dropdown = document.getElementById('notificationDropdown');
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(event) {
            let dropdown = document.getElementById('notificationDropdown');
            let bell = document.getElementById('notificationBell');
            if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Mark notifications as read
        document.querySelectorAll('.notification').forEach(item => {
            item.addEventListener('click', function() {
                this.classList.remove('unread');
                this.classList.add('read');

                // Update notification count
                let unreadItems = document.querySelectorAll('.notification.unread');
                let notificationCount = document.getElementById('notificationCount');

                if (unreadItems.length === 0) {
                    notificationCount.style.display = 'none';
                } else {
                    notificationCount.innerText = unreadItems.length;
                }
            });
        });
    </script>
</body>

</html>

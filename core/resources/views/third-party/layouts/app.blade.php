<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Third Party Portal - {{ get_company_name() }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @if (get_setting_value('favicon') != '')
        <link rel="icon" type="image/png" sizes="16x16" href="{{ image_url(get_setting_value('favicon')) }}">
    @endif
    
    @include('partials.styles')
    <script src="{{ asset('assets/js/jquery-3.6.4.min.js') }}"></script>
    
    <style>
        body {
            font-family: "poppins", sans-serif;
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
                            <i class="fa fa-home" style="font-size:20px;"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <!-- Language Dropdown (Optional) -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link text-uppercase text-white" data-toggle="dropdown"
                            style="display: flex;align-items: center;">
                            <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                            <?php $languages = get_languages(); ?>
                            @foreach ($languages as $language)
                                <?php $flag = $language->flag != '' ? $language->flag : 'placeholder_Flag.jpg'; ?>
                                <a class="dropdown-item" rel="alternate"
                                    href="{{ route('admin_lang_switch', $language->short_name) }}">
                                    <img src="{{ image_url($flag) }}" class="language-img">
                                </a>
                            @endforeach
                        </div>
                    </li>

                    <!-- Third Party User Menu -->
                    <li class="nav-item dropdown user user-menu">
                        <a href="#" class="nav-link text-uppercase text-white" data-toggle="dropdown"
                            style="display: flex;align-items: center;">
                            <img src="{{ image_url('uploads/defaultavatar.png') }}"
                                class="user-image" alt="User Image" />
                            <strong>
                                <span>Welcome,</span>
                                <span class="hidden-xs">{{ session('third_party_user_name', 'User') }}</span>
                            </strong>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header text-uppercase text-white">
                                <img src="{{ image_url('uploads/defaultavatar.png') }}"
                                    class="img-circle" alt="User Image" />
                                <p>{{ session('third_party_user_name', 'User') }}</p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <form action="{{ route('third.party.logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm btn-flat">
                                            {{ trans('app.logout') }}
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>

        <!-- Third Party Sidebar -->
        @include('third-party.partials.nav')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Modals -->
        <div id="ajax-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document"></div>
        </div>
    </div>

    @include('partials.scripts')

    <!-- Flash Messages -->
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

    <!-- Session Messages -->
    @if(session('success'))
        <script>
            $.amaran({
                'theme': 'awesome ok',
                'content': {
                    title: 'Success !',
                    message: '{{ session('success') }}',
                    info: '',
                    icon: 'fa fa-check-square-o'
                },
                'position': 'bottom right',
                'outEffect': 'slideBottom'
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            $.amaran({
                'theme': 'awesome error',
                'content': {
                    title: 'Error !',
                    message: '{{ session('error') }}',
                    info: '',
                    icon: 'fa fa-times-circle-o'
                },
                'position': 'bottom right',
                'outEffect': 'slideBottom'
            });
        </script>
    @endif
</body>
</html>
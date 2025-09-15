<style>
.layout-navbar-fixed.layout-fixed .wrapper .sidebar {
    margin-top: calc(5.5rem + 1px) !important;
}
.main-sidebar {
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
}

/* Brand/logo section */
.brand-logo-container {
    text-align: center;
    padding: 10px 0;
    flex-shrink: 0; /* prevents shrinking */
}

.brand-logo-container img {
    max-width: 240px;
    height: auto;
    display: block;
    margin: 0 auto;
}

/* Sidebar content scrollable */
.sidebar {
    flex: 1 1 auto; /* take remaining height */
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}

.sidebar-header {
    position: sticky;
    z-index: 9999;
    background: #2c3e50;
    top: 105px; /* default for desktop logo */
}
/* Sidebar header sticky */
.sidebar-header h4 {
    position: sticky;
    top: 0;
    background: #2c3e50;
    z-index: 1100;
    color: #fff;
    font-weight: 700;
    padding: 15px 15px 15px 40px;
    margin: 0;
    text-align: left;
    text-transform: uppercase;
    font-size: 14px;
}

/* Nav treeview scrolling if too long */
.nav-treeview {
    max-height: 60vh; /* adjust as needed */
    overflow-y: auto;
}


/* ---------- RESPONSIVENESS ---------- */

/* Small screens (phones) */
@media screen and (max-width: 575px) {
  .main-sidebar {
    left: -250px; /* hidden by default */
    width: 250px !important;
    transition: left 0.3s ease-in-out;
    overflow: hidden;
  }
  .main-sidebar.active {
    left: 0; /* slide in */
  }

  .sidebar {
    height: 100%;
    overflow-y: auto; /* enable scrolling on mobile */
    -webkit-overflow-scrolling: touch; /* smooth iOS scroll */
    padding-bottom: 80px; /* avoid cut-off at bottom */
  }
    .sidebar-header {
        top: 100px; /* smaller logo height */
      }

  .brand-logo-container img,
  .brand-link img {
    max-width: 160px !important;
  }

  .sidebar-header h4 {
    font-size: 12px;
    padding: 10px 10px 10px 40px;
  }
}

/* Medium screens (tablets) */
@media screen and (min-width: 576px) and (max-width: 991px) {
  .main-sidebar {
    width: 200px !important;
  }
  .brand-logo-container img,
  .brand-link img {
    max-width: 180px !important;
  }
}

/* Larger screens (default behavior) */
@media screen and (min-width: 992px) {
  aside {
      width: 240px !important; /* default width */
  }
}

.brand-logo-container {
    text-align: center;
    padding: 10px 0;
}
.brand-logo-container img {
    max-width: 240px;
    height: auto;
    display: block;
    margin: 0 auto;
}
.sidebar-header h4 {
    position: sticky;
    top: 0;                      /* sticks to top of sidebar */
    background: #2c3e50;         /* match sidebar color so it looks clean */
    z-index: 1100;               /* stays above scrolling items */
    color: #ffffff;
    font-weight: 700;
    padding: 15px 15px 15px 40px; /* extra left padding so icon doesn’t overlap text */
    margin: 0;
    text-align: left;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-size: 14px;
    border-radius: 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3); /* subtle shadow under sticky bar */
}

.sidebar-header h4:before {
    content: '\f0e8'; /* FontAwesome icon */
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;             /* required for solid icons */
    position: absolute;
    left: 15px;
    top: 50%;                     /* vertically center */
    transform: translateY(-50%);
    color: #3498db;
    font-size: 18px;
}

</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
   <div style="display: flex; justify-content: center; align-items: center;">
    @if(get_setting_value('logo') != '')
        <a href="{{ route('update_profile', auth()->guard('user')->user()->uuid) }}" class="brand-link">
            <img src="{{ image_url(get_setting_value('logo')) }}" alt="Logo" style="max-width: 240px;">
        </a>
    @else
        <a href="{{ route('update_profile', auth()->guard('user')->user()->uuid) }}" class="brand-link">
            <img src="{{ asset('assets/images/selangor.png') }}" alt="Logo" style="max-width: 200px;">
        </a>
    @endif
</div>
    <div class="sidebar-header mb-3">
            <h4 class="">{{ trans('Sistem e-CP (Caruman Parit)') }}</h4>
        </div>
    <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">
        <!-- Sidebar user panel -->
        <!--@if(auth('user')->check())-->
        <!--    <div class="user-panel mt-3">-->
        <!--        @if(auth()->guard('user')->check())-->
        <!--        <div class="pull-left image">-->
        <!--            <img src="{{auth('user')->user()->photo != '' ? image_url(Auth::guard('user')->user()->photo) : image_url('uploads/defaultavatar.png')  }}" class="img-circle" alt="User Image" />-->
        <!--        </div>-->
        <!--        <div class="pull-left info">-->
        <!--            <p> {{  auth('user')->user()->name }} </p>-->
        <!--            <a href="#"><i class="fa fa-circle text-success"></i> {{trans('app.online')}}</a>-->
        <!--        </div>-->
        <!--        @endif-->
        <!--    </div>-->
        <!--@endif-->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        
        <nav class="mt-2 mb-5">
            <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu" data-widget="treeview" role="menu" data-accordion="false">
                {{-- <!--<li class="nav-item has-treeview {{ Form::menu_active('clientarea/cprofile') }}">--> --}}
                 <!-- Commented out the cprofile section -->
    
                 <li class="nav-item  request()->is('clientarea/edit-profile*') || request()->is('clientarea/settings*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('clientarea/cprofile*') || request()->is('clientarea/edit-profile*') || request()->is('clientarea/settings*') ? 'active' : '' }}">
                        <i class="fa fa-user-md"></i>
                        <span>{{ trans('app.profile') }}</span>
                        <i class="fa fa-angle-right right"></i>
                    </a>
                    <ul class="nav nav-treeview" style="{{ request()->is('clientarea/cprofile*') || request()->is('clientarea/edit-profile*') || request()->is('clientarea/settings*') ? 'display: block;' : 'display: none;' }}">
                        <!-- Submenu Item: Update Profile -->
                        <li class="nav-item">
                            <a href="{{ route('update_profile', auth()->guard('user')->user()->uuid) }}" 
                               class="nav-link {{ request()->is('clientarea/edit-profile*') ? 'active' : '' }}">
                                <i class="fa fa-edit nav-icon"></i>
                                <span>{{ trans('app.personal_details') }}</span>
                            </a>
                        </li>
                        <!-- Submenu Item: Settings -->
                        <li class="nav-item">
                            <a href="{{ route('settings', auth()->guard('user')->user()->uuid) }}" 
                               class="nav-link {{ request()->is('clientarea/settings*') ? 'active' : '' }}">
                                <i class="fa fa-cog nav-icon"></i>
                                <span>{{ trans('app.change_password') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
   
                <li class="nav-item {{ request()->is('clientarea/new-application') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link  {{ request()->is('clientarea/new-application') ? 'active' : '' }}">
                        <i class="fa fa-folder-open"></i>
                        <span>{{ trans('app.application') }}</span>
                        <i class="fa fa-angle-right right"></i>
                         <!-- Dropdown arrow -->
                    </a>
                    <ul class="nav nav-treeview" style="display: none; padding-left: 20px;">
                        <li class="nav-item {{ request()->is('clientarea/new-application') ? 'active' : '' }}">
                            <a href="{{route('client_application')}}" class="nav-link {{ request()->is('clientarea/new-application') ? 'active' : '' }}">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <span>{{ trans('app.new_application') }}</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('clientarea/application-status') ? 'active' : '' }}">
                            <a href="{{route('client_application_status')}}" class="nav-link {{ request()->is('clientarea/application-status') ? 'active' : '' }}">
                                <i class="fa fa-list-alt nav-icon"></i>
                                <span>{{ trans('app.application_status') }}</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('clientarea/contribution-history') ? 'active' : '' }}">
                            <a href="{{route('contribution_history')}}" class="nav-link {{ request()->is('clientarea/contribution-history') ? 'active' : '' }}">
                                <i class="fa fa-history nav-icon"></i>
                                <span>{{ trans('app.contribution_history') }}</span>
                            </a>
                        </li>
                        <!--<li class="nav-item {{ request()->is('clientarea/contribution-claim') ? 'active' : '' }}">-->
                        <!--    <a href="{{route('contribution_claim')}}" class="nav-link {{ request()->is('clientarea/contribution-claim') ? 'active' : '' }}">-->
                        <!--        <i class="fa fa-money nav-icon"></i>-->
                        <!--        <span>{{ trans('app.claim_contribution') }}</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                    </ul>
                </li>
                
                 <li class="nav-item {{ request()->is('clientarea/contribution-claim') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link  {{ request()->is('clientarea/contribution-claim') ? 'active' : '' }}">
                        <i class="fa fa-folder-open"></i>
                        <span>{{ trans('app.claim_contribution') }}</span>
                        <i class="fa fa-angle-right right"></i>
                        <!-- Dropdown arrow -->
                    </a>
                    <ul class="nav nav-treeview" style="display: none; padding-left: 20px;">
                        <li class="nav-item {{ request()->is('clientarea/contribution-claim') ? 'active' : '' }}">
                            <a href="{{ route('contribution_claim') }}"
                                class="nav-link {{ request()->is('clientarea/contribution-claim') ? 'active' : '' }}">
                                <i class="fa fa-money nav-icon"></i>
                                <span>{{ trans('app.new_application') }}</span>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('clientarea/claim-contribution-list') ? 'active' : '' }}">
                            <a href="{{ route('claim.contribution.list') }}"
                                class="nav-link {{ request()->is('clientarea/claim-contribution-list') ? 'active' : '' }}">
                                <i class="fa fa-money nav-icon"></i>
                                <span>{{ trans('app.application_status') }}</span>
                            </a>
                        </li>
                    </ul>
                    {{-- <ul class="nav nav-treeview" style="display: none; padding-left: 20px;">
                        <li class="nav-item {{ request()->is('clientarea/contribution-claim') ? 'active' : '' }}">
                            <a href="{{ route('claim.contribution.list) }}"
                                class="nav-link {{ request()->is('clientarea/claim-contribution-list') ? 'active' : '' }}">
                                <i class="fa fa-money nav-icon"></i>
                                <span>{{ trans('app.claim_contribution_list') }}</span>
                            </a>
                        </li>
                    </ul> --}}
                </li>
                

                <!--<li class="nav-item has-treeview nav-item {{ request()->is('clientarea/helpdesk') ? 'menu-open' : '' }}">-->
                <!--    <a href="{{route('helpdesk')}}" class="nav-link {{ request()->is('clientarea/helpdesk') ? 'active' : '' }}">-->
                <!--        <i class="fa fa-question-circle "></i>-->
                <!--        <span>{{trans('app.helpdesk')}}</span>-->
                <!--    </a>-->
                <!--</li>-->
                <li class="nav-item has-treeview {{ request()->is('clientarea/faq') ? 'menu-open' : '' }}">
                    <a href="{{route('faq')}}" class="nav-link {{ request()->is('clientarea/faq') ? 'active' : '' }}">
                        <i class="fa fa-comments "></i>
                        <span>{{trans('app.faq')}}</span>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->is('clientarea/contact-support') ? 'menu-open' : '' }}">
                    <a href="{{route('contact_support')}}" class="nav-link {{ request()->is('clientarea/contact-support') ? 'active' : '' }}">
                        <i class="fa fa-phone "></i>
                        <span>{{trans('app.contact_support')}}</span>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ request()->is('clientarea/user-manual') ? 'menu-open' : '' }}">
                    <a href="{{route('user_manual')}}" class="nav-link {{ request()->is('clientarea/user-manual') ? 'active' : '' }}">
                        <i class="fa fa-book "></i>
                        <span>{{trans('app.user_manual')}}</span>
                    </a>
                </li>
                <!--<li class="header p-2">{{trans('app.main_menu')}}</li>-->
                <!--<li class="{{ Form::menu_active('clientarea/home') }}">-->
                <!--    <a href="{{ route('client_dashboard') }}" class="nav-link">-->
                <!--        <i class="fa fa-home"></i>-->
                <!--        <span>{{trans('app.dashboard')}}</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="{{ Form::menu_active('clientarea/cinvoices') }}">-->
                <!--    <a href="{{ route('cinvoices.index') }}" class="nav-link">-->
                <!--        <i class="fa fa-file-pdf-o"></i>-->
                <!--        <span>{{trans('app.invoices')}}</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="{{ Form::menu_active('clientarea/cestimates') }}">-->
                <!--    <a href="{{ route('cestimates.index') }}" class="nav-link">-->
                <!--        <i class="fa fa-list-alt"></i>-->
                <!--        <span>{{trans('app.estimates')}}</span>-->
                <!--    </a>-->
                <!--</li>-->
                
                <!--<li class="{{ Form::menu_active('clientarea/reports') }}">-->
                <!--    <a href="{{ url('clientarea/reports') }}" class="nav-link">-->
                <!--        <i class="fa fa-line-chart"></i>-->
                <!--        <span>{{trans('app.reports')}}</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="header">{{trans('app.account_menu')}}</li>-->
                
                <li class="nav-item has-treeview {{ Form::menu_active('clientarea/logout') }}">
                    <a href="{{ route('client_logout') }}" class="nav-link">
                        <i class="fa fa-power-off"></i> 
                        <span>{{trans('app.logout')}}</span>
                    </a>
                </li>
            </ul>
            </nav>
    </section>
    <!-- /.sidebar -->
</aside>
<script>
    document.querySelectorAll('.nav-item > .nav-link').forEach(function(menu) {
    menu.addEventListener('click', function() {
        let parent = this.closest('.sidebar');
        let submenu = this.nextElementSibling;

        if (submenu && submenu.classList.contains('nav-treeview')) {
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';

            // Adjust scrolling if the submenu is expanded
            if (submenu.style.display === 'block') {
                submenu.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.nav-item').forEach(function (menu) {
        let activeLink = menu.querySelector('.nav-link.active');
        if (activeLink) {
            let submenu = activeLink.closest('.nav-treeview');
            if (submenu) {
                submenu.style.display = 'block';
                let parentMenu = submenu.closest('.nav-item');
                if (parentMenu) {
                    parentMenu.classList.add('menu-open');
                }
            }
        }
    });
});
</script>
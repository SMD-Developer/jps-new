<style>

[class*="sidebar-dark"] .user-panel {
    border-bottom: none;
}
i.right.fa.fa-angle-right.mt-2 {
    right: 1.2rem;
}
/* Set sidebar to full height and enable scrolling for content */
.main-sidebar {
    max-height: 100vh; /* Limit the height to the viewport */
    overflow: hidden; /* Prevent sidebar scrolling at the main level */
    display: flex;
    flex-direction: column;
    
}

/* Fix logo section at the top */
.main-sidebar .logo-section {
    flex-shrink: 0;
    padding: 10px; /* Optional: Add padding around the logo */
    text-align: center;
    background: #343a40; /* Optional: Match sidebar background */
    
}

/* Make the sidebar content scrollable */
.main-sidebar .scrollable-content {
    flex-grow: 1;
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: hidden; /* Prevent horizontal scrolling */
    
}

/* Optional: Improve scrollbar appearance */
.scrollable-content::-webkit-scrollbar {
    width: 8px;
    
}

.brand-link {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
}
.brand-link img {
    max-width: 100%;
    height: auto;
    margin-left: 70px;
}

.sidebar-header {
    position: sticky;
    z-index: 9999;
    background: #2c3e50;
    top: 115px; /* default for desktop logo */
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
/* Style Option 3: Elegant with Icon */
.sidebar-header h4 {
    color: #fff;
    font-weight: 600;
    padding: 15px 10px 15px 45px;
    margin: 0;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
    font-size: 14px;
    position: relative;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
}

.sidebar-header h4:before {
    content: '\f0e8'; /* FontAwesome icon - adjust as needed */
    font-family: 'Font Awesome 5 Free';
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #3498db;
    font-size: 18px;
}

.scrollable-content::-webkit-scrollbar-thumb {
    background-color: #888; /* Scrollbar color */
    border-radius: 4px;
    
}

.scrollable-content::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Scrollbar hover color */
    
}
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
        top: 70px; /* smaller logo height */
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
</style>


<aside class="main-sidebar sidebar-dark-primary elevation-4" style="font-family: poppins;">
    <div class="card">
        @php
        $user = auth('admin')->user(); // Use the correct guard if needed
        $dashboardRoute = route('home'); // Default route
    
        if ($user) {
            if ($user->username == 'admin') {
                $dashboardRoute = route('home');
            } elseif ($user->username == 'finance') {
                $dashboardRoute = route('home-finance');
            } elseif ($user->username == 'reviewer') {
                $dashboardRoute = route('home-reviewer'); 
            } elseif ($user->username == 'approver') {
                $dashboardRoute = route('approver-home');
            } elseif ($user->username == 'adminstaff') {
                $dashboardRoute = route('home_admin_staff');
            } elseif ($user->username == 'applicationapprover') {
                $dashboardRoute = route('home_adminapprover');
            }
        }
    @endphp
    
        <a href="{{ $dashboardRoute }}" class="brand-link">
            @if(get_setting_value('logo') != '')
                <img src="{{ image_url(get_setting_value('logo')) }}" alt="Logo" width="100%">
            @else
                <img src="{{ asset('assets/images/selangor.png') }}" alt="Logo" width="100%">
            @endif
        </a>
    </div>
    <div class="sidebar-header">
        <h4>{{ trans('Sistem e-CP (Caruman Parit)') }}</h4>
    </div>
   <section class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu" data-widget="treeview" role="menu" data-accordion="false">
            @foreach(getMenus() as $menuCategory)
                @foreach($menuCategory['menus'] as $menu)
                    @if(!isset($menu['permission']) || auth('admin')->user()->hasPermission($menu['permission']))
                        <li class="nav-item {{ $menu['active_dropdown'] ?? $menu['menu_active'] }}">
                            <a href="{{ $menu['route'] }}" class="nav-link {{ $menu['menu_active'] }}">
                                <i class="fa fa-{{ $menu['icon'] }}"></i>
                                <p>
                                    {{ $menu['text'] }}
                                    <!-- Add badge count here -->
                                @if(isset($menu['badge_count']) && $menu['badge_count'] > 0)
                                    <span class="{{ $menu['badge_class'] ?? 'badge bg-danger text-white' }}" style="margin-left: 8px;">
                                        {{ $menu['badge_count'] }}
                                    </span>
                                @endif
                                
                                <!--@if(isset($menu['submenus']) && count($menu['submenus']) > 0)-->
                                <!--    <i class="right fa fa-angle-right"></i>-->
                                <!--@endif-->
                                    @if(isset($menu['submenus']) && count($menu['submenus']) > 0)
                                        <i class="right fa fa-angle-right mt-2 "></i>
                                    @endif
                                </p>
                            </a>
                            @if(isset($menu['submenus']) && count($menu['submenus']) > 0)
                                <ul class="nav nav-treeview" style="display: {{ $menu['active_dropdown_menu'] ?? 'none' }};">
                                    @foreach($menu['submenus'] as $submenu)
                                        @if(!isset($submenu['permission']) || auth('admin')->user()->hasPermission($submenu['permission']))
                                            <li class="nav-item {{ $submenu['menu_active'] }}">
                                                <a href="{{ $submenu['route'] }}" class="nav-link {{ $submenu['menu_active'] }}">
                                                    <i class="fa fa-{{ $submenu['icon'] }} nav-icon"></i>
                                                    <p>
                                                        {{ $submenu['text'] }}
                                                        @if(isset($submenu['submenus']) && count($submenu['submenus']) > 0)
                                                            <i class="right fa fa-angle-right"></i>
                                                        @endif
                                                    </p>
                                                </a>
                                                @if(isset($submenu['submenus']) && count($submenu['submenus']) > 0)
                                                    <ul class="nav nav-treeview">
                                                        @foreach($submenu['submenus'] as $subsubmenu)
                                                            @if(!isset($subsubmenu['permission']) || auth('admin')->user()->hasPermission($subsubmenu['permission']))
                                                                <li class="nav-item {{ $subsubmenu['menu_active'] }}">
                                                                    <a href="{{ $subsubmenu['route'] }}" class="nav-link {{ $subsubmenu['menu_active'] }}">
                                                                        <i class="fa fa-{{ $subsubmenu['icon'] }} nav-icon"></i>
                                                                        <p>{{ $subsubmenu['text'] }}</p>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            @endforeach
        </ul>
    </nav>

</section>
</aside>






<style>
[class*="sidebar-dark"] .user-panel {
    border-bottom: none;
}
i.right.fa.fa-angle-right.mt-2 {
    right: 1.2rem;
}
.main-sidebar {
    max-height: 100vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.main-sidebar .logo-section {
    flex-shrink: 0;
    padding: 10px;
    text-align: center;
    background: #343a40;
}
.main-sidebar .scrollable-content {
    flex-grow: 1;
    overflow-y: auto;
    overflow-x: hidden;
}
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
    margin-left: 87px;
}
.sidebar-header {
    position: sticky;
    z-index: 9999;
    background: #2c3e50;
    top: 115px;
}
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
    content: '\f0e8';
    font-family: 'Font Awesome 5 Free';
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #3498db;
    font-size: 18px;
}
.scrollable-content::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 4px;
}
.scrollable-content::-webkit-scrollbar-thumb:hover {
    background-color: #555;
}
@media screen and (max-width: 575px) {
  .main-sidebar {
    left: -250px;
    width: 250px !important;
    transition: left 0.3s ease-in-out;
    overflow: hidden;
  }
  .main-sidebar.active {
    left: 0;
  }
  .sidebar {
    height: 100%;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    padding-bottom: 80px;
  }
  .sidebar-header {
    top: 70px;
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
        <!-- Brand Logo -->
        <a href="{{ route('third.party.dashboard') }}" class="brand-link d-flex align-items-center justify-content-center" style="padding: 15px;">
            @if(get_setting_value('logo') != '')
                <img src="{{ image_url(get_setting_value('logo')) }}" alt="Logo" style="max-height: 93px; width: auto; object-fit: contain;">
            @else
                <img src="{{ asset('assets/images/selangor.png') }}" alt="Logo" style="max-height: 60px; width: auto; object-fit: contain;">
            @endif
        </a>
    </div>

    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h4>{{ trans('SISTEM E-CP (CARUMAN PARIT)') }}</h4>
    </div>

    <!-- Sidebar Menu -->
    <section class="sidebar scrollable-content">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('third.party.dashboard') }}" class="nav-link {{ request()->routeIs('third.party.dashboard') ? 'active' : '' }}">
                        <i class="fa fa-tachometer-alt nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('third.party.search')}}" class="nav-link">
                        <i class="fa fa-file-alt nav-icon"></i>
                        <p>Carian</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('third.party.my.requests') }}" class="nav-link">
                        <i class="fa fa-credit-card nav-icon"></i>
                        <p>Permohonan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('third.party.my.payments') }}" class="nav-link">
                        <i class="fa fa-credit-card nav-icon"></i>
                        <p>Pembayaran</p>
                    </a>
                </li>
            </ul>
        </nav>
    </section>
</aside>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Keraton - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('admin-assets/images/favicon.png') }}" />
</head>
<body>
    <div class="container-scroller">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
           <ul class="nav">
  <li class="nav-item nav-category">
    <span class="nav-link">Main Menu</span>
  </li>
  
  <li class="nav-item menu-items {{ Request::is('admin/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
      <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
      <span class="menu-title">Laporan Penjualan</span>
    </a>
  </li>

  <li class="nav-item menu-items {{ Request::is('admin/museum*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.museum.index') }}">
      <span class="menu-icon"><i class="mdi mdi-bank"></i></span>
      <span class="menu-title">Kelola Museum</span>
    </a>
  </li>

  <li class="nav-item menu-items {{ Request::is('admin/tickets*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.tickets.index') }}">
      <span class="menu-icon"><i class="mdi mdi-ticket-confirmation"></i></span>
      <span class="menu-title">Kelola Tiket</span>
    </a>
  </li>

  <li class="nav-item menu-items {{ Request::is('admin/shop*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.shop.index') }}">
      <span class="menu-icon"><i class="mdi mdi-cart"></i></span>
      <span class="menu-title">Kelola Shop</span>
    </a>
  </li>

  <li class="nav-item menu-items">
    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
      <span class="menu-icon"><i class="mdi mdi-logout text-danger"></i></span>
      <span class="menu-title">Keluar (Logout)</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </li>
</ul>
        </nav>

        <div class="container-fluid page-body-wrapper">
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                </nav>

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content') </div>
                
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © Keraton 2026</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin-assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('admin-assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin-assets/js/misc.js') }}"></script>
</body>
</html>
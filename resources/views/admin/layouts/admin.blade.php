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

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* --- 1. GLOBAL & TYPOGRAPHY --- */
        body { 
            font-family: 'Inter', sans-serif; /* Clean, modern font */
            background: #f4f5f7; 
        }
        
        /* --- 2. SIDEBAR (Solid & Professional) --- */
        .sidebar {
            background: #1e1e2d; /* Solid Dark Navy (No Gradient) */
            border-right: none;
        }

        /* Profile Card - Natural Look */
        .nav-item.profile {
            /* Removed gradient, just solid dark */
            background: #1e1e2d; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 25px 15px !important;
            margin-bottom: 10px;
        }
        .profile-desc {
            display: flex;
            align-items: center;
        }
        .profile-pic {
            width: 48px;
            height: 48px;
            border-radius: 8px; /* Slightly rounded square looks more professional */
            background: #2b2b40;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d4af37; /* Gold Icon */
            font-size: 24px;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }
        .profile-name {
            margin-left: 15px;
        }
        .profile-name h5 {
            margin-bottom: 2px;
            font-weight: 600;
            color: #ffffff;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }
        .profile-name span {
            font-size: 11px;
            color: #7e8299; /* Standard muted text */
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* --- 3. MENU ITEMS (Flat Design) --- */
        .sidebar .nav .nav-item .nav-link {
            color: #9899ac; /* Soft gray text */
            padding: 12px 20px;
            /* Removed odd rounded shapes */
            border-radius: 6px; 
            margin: 4px 12px; /* Add margin for floating effect */
            transition: all 0.2s ease-in-out;
            font-size: 13px;
            font-weight: 500;
        }
        
        /* Hover: Simple Lighten */
        .sidebar .nav .nav-item:hover .nav-link {
            background: rgba(255, 255, 255, 0.04);
            color: #ffffff;
        }
        .sidebar .nav .nav-item:hover .menu-icon {
            color: #ffffff;
        }

        /* Active State: Solid Background (No Gradient) */
        .sidebar .nav .nav-item.active > .nav-link {
            background: #2b2b40; /* Lighter dark block */
            color: #d4af37; /* Gold Text */
        }
        .sidebar .nav .nav-item.active .menu-icon {
            color: #d4af37; /* Gold Icon */
        }

        /* Icons */
        .menu-icon {
            color: #5e6278;
            font-size: 18px;
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Categories */
        .nav-category .nav-link {
            color: #5e6278 !important;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 15px;
            padding-left: 30px !important;
        }

        /* --- 4. NAVBAR (Clean White) --- */
        .navbar .navbar-menu-wrapper {
            background: #1e1e2d;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            color: #ffff;
        }
        .navbar-brand-wrapper { 
            background: #ffffff !important; /* Match sidebar */
        }
        
        /* Navbar Text */
        .brand-text-nav {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 18px;
            color: #ffffff;
        }
    </style>
</head>
<body>
  
  <nav class="navbar p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="#">
          <i class="mdi mdi-castle text-warning"></i>
        </a>
      </div>

      <div class="navbar-menu-wrapper flex-grow d-flex align-items-center px-4">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 brand-text-nav">Admin Keraton</h5>
        </div>

        <ul class="navbar-nav ml-auto d-flex align-items-center">
          <li class="nav-item dropdown">
            <a class="nav-link text-white font-weight-small" href="#" data-toggle="dropdown" style="font-size: 13px;">
              <i class="mdi mdi-account-circle mr-1 text-muted"></i>
              {{ Auth::user()->name ?? 'Admin' }}
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list shadow-sm border-0">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item preview-item px-3 py-2">
                        <i class="mdi mdi-logout text-danger mr-2"></i> Logout
                    </button>
                </form> 
            </div>
          </li>
        </ul>
        
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
  </nav>

  <div class="container-scroller">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            
            <li class="nav-item profile">
                <div class="profile-desc">
                    <div class="profile-pic">
                        <i class="mdi mdi-account"></i>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0">{{ Auth::user()->name ?? 'Administrator' }}</h5>
                        <span>Admin</span>
                    </div>
                </div>
            </li>

            <li class="nav-item nav-category">
                <span class="nav-link">Utama</span>
            </li>
          
            <li class="nav-item menu-items {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <span class="menu-icon"><i class="mdi mdi-grid"></i></span>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item menu-items {{ Request::is('admin/tickets*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.tickets.index') }}">
                    <span class="menu-icon"><i class="mdi mdi-ticket-outline"></i></span>
                    <span class="menu-title">Kelola Tiket</span>
                </a>
            </li>

            <li class="nav-item menu-items {{ Request::is('admin/shop*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.shop.index') }}">
                
                <span class="menu-icon"><i class="mdi mdi-cart"></i></span>
                    <span class="menu-title">Kelola Shop</span>
                </a>  
            </li>

            <li class="nav-item menu-items {{ Request::is('admin/museum*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.museum.index') }}">
                    <span class="menu-icon"><i class="mdi mdi-bank-outline"></i></span>
                    <span class="menu-title">Data Museum</span>
                </a>
            </li>

            <li class="nav-item menu-items {{ Request::is('admin/reports*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.reports.index') }}">
                   <span class="menu-icon"><i class="mdi mdi-ticket-confirmation"></i></span>
                    <span class="menu-title">Laporan Penjualan</span>
                </a>
            </li>

            <li class="nav-item nav-category">
                <span class="nav-link">Sistem</span>
            </li>

            <li class="nav-item menu-items">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="menu-icon"><i class="mdi mdi-logout-variant text-danger"></i></span>
                    <span class="menu-title text-danger">Keluar</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                
                {{-- Alert Standard --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="background: #e8f5e9; color: #2e7d32;">
                        <i class="mdi mdi-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="background: #ffebee; color: #c62828;">
                        <i class="mdi mdi-alert-circle mr-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

  </div>

  <script src="{{ asset('admin-assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('admin-assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('admin-assets/js/misc.js') }}"></script>
  @stack('scripts')
</body>
</html>
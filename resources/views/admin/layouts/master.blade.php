<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin — Fokuskesini')</title>

    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* 🖤 GAYA MEWAH MONOKROM: Siku Tajam & Minimalis */
        body { font-family: 'Plus Jakarta Sans', sans-serif !important; background-color: #ffffff; color: #000000; }
        
        /* Sidebar Hitam Pekat */
        .bg-gradient-primary { background-color: #000000 !important; background-image: none !important; }
        .sidebar { width: 14rem !important; border-right: 1px solid #eeeeee; }
        .sidebar-dark .nav-item .nav-link { 
            color: rgba(255,255,255,0.6); font-size: 0.75rem; text-transform: uppercase; 
            letter-spacing: 1px; padding: 1.2rem; border-radius: 0 !important; 
        }
        .sidebar-dark .nav-item.active .nav-link { 
            color: #ffffff !important; background-color: #1a1a1a !important; 
            font-weight: 700; border-left: 4px solid #ffffff; 
        }
        .sidebar-brand { background: #000000; height: 5rem !important; border-radius: 0 !important; }
        .sidebar-brand img { height: 35px; filter: invert(1) brightness(100%); }

        /* Topbar & Komponen Tanpa Shadow */
        .topbar { background-color: #ffffff !important; border-bottom: 1px solid #f2f2f2; box-shadow: none !important; }
        .card, .btn, .badge { border-radius: 0 !important; box-shadow: none !important; }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <img src="{{ asset('sb-admin/img/logo.png') }}" alt="Logo Fokuskesini">
            </a>
            <hr class="sidebar-divider my-0">
            
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fw fa-th-large"></i><span>Dashboard</span></a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.packages.index') }}"><i class="fas fa-fw fa-camera"></i><span>Paket Foto</span></a>
            </li>
            
            <li class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.bookings.index') }}"><i class="fas fa-fw fa-shopping-cart"></i><span>Pesanan</span></a>
            </li>

            <hr class="sidebar-divider">
            
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link bg-transparent border-0 text-left w-100" style="cursor:pointer">
                        <i class="fas fa-fw fa-sign-out-alt"></i><span>Keluar</span>
                    </button>
                </form>
            </li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top">
                    <ul class="navbar-nav ml-auto text-uppercase small font-weight-bold">
                        <li class="nav-item">
                            <span class="nav-link text-dark">{{ auth()->user()->name }} — Administrator</span>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">@yield('content')</div>
            </div>

            <footer class="sticky-footer bg-white border-top">
                <div class="container my-auto text-center">
                    <span class="small text-uppercase" style="letter-spacing: 2px;">&copy; Fokuskesini {{ date('Y') }}</span>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sb-admin/js/sb-admin-2.min.js') }}"></script>
    
    @yield('scripts')
</body>
</html>
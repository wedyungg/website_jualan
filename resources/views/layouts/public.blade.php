<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Fokuskesini - Luxury Photography')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* 🖤 Global Style: Monochrome Luxury */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif !important; 
            background-color: #ffffff; 
            color: #1a1a1a;
        }

        /* 🧭 Navbar: Deep Black & Sharp */
        .navbar-custom {
            background-color: #000000 !important;
            padding: 10px 0; /* Luwih slim ben elegan */
            transition: all 0.3s;
        }
        
        .navbar-brand img {
            height: 40px;
            filter: invert(1) brightness(100%);
        }

        /* 🔘 Dropdown Trigger: Nama User */
        .nav-link.dropdown-toggle {
            font-weight: 700;
            color: #ffffff !important;
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 20px !important;
        }

        /* 📦 Dropdown Box: Shopee Style (Manunggal) */
        .dropdown-menu {
            border-radius: 0 !important; /* Siku Tajam */
            border: 1px solid #ffffff !important; /* Garis pemisah putih tipis */
            padding: 0;
            margin-top: 0 !important; /* Nempel persis neng ngisor trigger */
            background-color: #000000;
            box-shadow: 0 15px 30px rgba(0,0,0,0.5);
            min-width: 200px;
        }

        .dropdown-item {
            padding: 15px 25px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: rgba(255,255,255,0.7) !important;
            transition: 0.3s;
            background-color: #000;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        /* Hover Effect: Invert Color */
        .dropdown-item:hover {
            background-color: #ffffff !important;
            color: #000000 !important;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        /* Luxury Button (Non-Auth) */
        .btn-luxury-nav {
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff !important;
            padding: 8px 25px;
            border-radius: 0;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-luxury-nav:hover {
            background-color: #fff;
            color: #000 !important;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('sb-admin/img/logo.png') }}" alt="FOKUSKESINI">
            </a>

            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto align-items-center">
                    @auth
                        <li class="nav-item dropdown ml-lg-3">
                            <a class="nav-link dropdown-toggle font-weight-bold" href="#" id="userMenu" role="button" data-toggle="dropdown">
                                <i class="fas fa-user-circle mr-2"></i> {{ Auth::user()->name }}
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right">
                                @if(Auth::user()->role == 'admin')
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Admin
                                    </a>
                                @endif

                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
    <i class="fas fa-user mr-2"></i> Akun Saya
</a>
                                
                                <a class="dropdown-item" href="{{ route('customer.orders') }}">
                                    <i class="fas fa-shopping-bag mr-2"></i> Pesanan Saya
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-left" style="cursor:pointer;">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item ml-lg-3">
                            <a class="btn btn-luxury-nav" href="{{ route('login') }}">Masuk</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main style="margin-top: 85px;"> 
        @yield('content')
    </main>

    <footer class="py-5 bg-black text-white text-center mt-5" style="background: #000;">
        <div class="container">
            <p class="small text-muted mb-0 text-uppercase" style="letter-spacing: 2px;">
                &copy; {{ date('Y') }} Fokuskesini. Professional Photography.
            </p>
        </div>
    </footer>

    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
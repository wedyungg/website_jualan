<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Fokuskesini - Luxury Photography')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* 🛠️ SISTEM VISUAL FOKUSKESINI */
        * { 
            font-family: 'Plus Jakarta Sans', sans-serif !important; 
        }

        /* Menghapus Sudut Membulat (Wajib Sharp Edges) */
        .card, .btn, .alert, .badge, .form-control, .dropdown-menu, .navbar {
            border-radius: 0 !important; 
        }

        body { 
            background-color: #ffffff; 
            color: #1a1a1a;
        }

        /* 🧭 Navbar Custom (Deep Black) */
        .navbar-custom {
            background-color: #000000 !important;
            padding: 10px 0;
            border-bottom: 1px solid #222;
        }

        .navbar-brand img {
            height: 40px;
            filter: invert(1) brightness(100%);
        }

        /* 🥪 Gaya Dropdown Mewah (Shopee/Luxury Style) */
        .dropdown-menu-fks {
            background-color: #000000 !important;
            border: 1px solid #ffffff !important; /* Garis tepi putih tipis */
            padding: 0;
            margin-top: 0 !important;
            box-shadow: 0 15px 30px rgba(0,0,0,0.5);
            min-width: 220px;
        }

        .dropdown-item-fks {
            padding: 15px 25px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: rgba(255,255,255,0.7) !important;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background-color: #000;
            transition: 0.3s;
        }

        .dropdown-item-fks:hover {
            background-color: #ffffff !important;
            color: #000000 !important;
            padding-left: 30px;
        }

        .dropdown-item-fks i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        .nav-link-fks {
            color: #ffffff !important;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 20px !important;
        }

        /* Form & Tombol */
        .btn-dark { background: #000 !important; border: 1px solid #000 !important; }
        .form-control { border: 1px solid #000; }
        .form-control:focus { box-shadow: none; border-color: #333; }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('sb-admin/img/logo.png') }}" alt="FOKUSKESINI">
            </a>

            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navUtama">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navUtama">
                <ul class="navbar-nav ml-auto align-items-center">
                    @auth
                        <li class="nav-item dropdown ml-lg-3">
                            <a class="nav-link nav-link-fks dropdown-toggle" href="#" id="userMenu" role="button" data-toggle="dropdown">
                                <i class="fas fa-user-circle mr-2"></i> {{ Auth::user()->name }}
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-fks">
                                @if(Auth::user()->role == 'admin')
                                    <a class="dropdown-item dropdown-item-fks" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                                    </a>
                                @endif

                                <a class="dropdown-item dropdown-item-fks" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user"></i> Akun Saya
                                </a>
                                
                                <a class="dropdown-item dropdown-item-fks" href="{{ route('customer.orders') }}">
                                    <i class="fas fa-shopping-bag"></i> Pesanan Saya
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item dropdown-item-fks text-danger w-100 text-left border-0 bg-transparent">
                                        <i class="fas fa-sign-out-alt"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item ml-lg-3">
                            <a class="btn btn-outline-light px-4" href="{{ route('login') }}" style="border-radius: 0;">MASUK</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main style="margin-top: 100px; min-height: 80vh;"> 
        <div class="container">
            @yield('content')
        </div>
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
    @stack('scripts')
</body>
</html>
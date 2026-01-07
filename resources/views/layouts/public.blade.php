<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Fokuskesini - Luxury Photography')</title>

    <!-- Font Modern: Plus Jakarta Sans (Sangat populer untuk desain modern 2026) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* 🖤 Global Style */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif !important; 
            background-color: #ffffff; 
            color: #1a1a1a;
        }

        /* 🧭 Navbar Luxury Hitam */
        .navbar-custom {
            background-color: #000000 !important; /* Hitam Pekat */
            padding: 20px 0;
            transition: all 0.3s;
        }
        
        /* 🖼️ LOGO MAGIC: Mengubah logo hitam menjadi putih agar terlihat di background gelap */
        .navbar-brand img {
            height: 45px; /* Ukuran logo pas */
            filter: invert(1) brightness(100%); /* Mantra pengubah warna */
        }

        .nav-link {
            font-weight: 500;
            color: rgba(255,255,255,0.7) !important;
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .nav-link:hover { color: #ffffff !important; }

        /* 🔘 Tombol Outline Putih (Sangat Mewah) */
        .btn-luxury-nav {
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff !important;
            padding: 8px 25px;
            border-radius: 0; /* Kotak tegas */
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-luxury-nav:hover {
            background-color: #fff;
            color: #000 !important;
            border-color: #fff;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top shadow-sm">
        <div class="container">
            <!-- LOGO FOKUSKESINI -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('sb-admin/img/logo.png') }}" alt="FOKUSKESINI">
            </a>

            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item"><a class="nav-link px-3" href="{{ url('/') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#katalog">Katalog</a></li>
                    @auth
                        <li class="nav-item ml-lg-3">
                            <a class="btn btn-luxury-nav" href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : url('/customer/dashboard') }}">
                                Akun Saya
                            </a>
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

    <!-- Wrapper Konten -->
    <main style="margin-top: 85px;"> 
        @yield('content')
    </main>

    <!-- Footer Simple -->
    <footer class="py-5 bg-black text-white text-center mt-5" style="background: #000;">
        <div class="container">
            <img src="{{ asset('sb-admin/img/logo.png') }}" alt="Logo" style="height: 30px; filter: invert(1); margin-bottom: 20px; opacity: 0.5;">
            <p class="small text-muted mb-0 text-uppercase" style="letter-spacing: 2px;">&copy; {{ date('Y') }} Fokuskesini. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
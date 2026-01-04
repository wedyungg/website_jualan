<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Fokuskesini</title>

    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .bg-gradient-primary {
            background-color: #000000;
            background-image: linear-gradient(180deg, #000000 10%, #333333 100%);
            background-size: cover;
            background-attachment: fixed;
        }
        .btn-dark-classy {
            background-color: #000000;
            border-color: #000000;
            color: #ffffff;
            font-weight: bold;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn-dark-classy:hover {
            background-color: #333333;
            border-color: #333333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .small.text-secondary:hover {
            color: #000000 !important;
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5" style="border-radius: 15px; overflow: hidden;">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block"
                         style="background-image: url('https://images.unsplash.com/photo-1516961642265-531546e84af2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80');
                                background-position: center; background-size: cover; min-height: 500px;">
                    </div>
                    
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <img src="{{ asset('sb-admin/img/logo.png') }}" alt="Logo" style="width: 150px; margin-bottom: 20px;">
                                <h1 class="h5 text-gray-900 mb-4" style="font-weight: 600;">Buat Akun Fokuskesini</h1>
                            </div>

                            <form class="user" method="POST" action="{{ route('register') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-user" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus
                                    style="border-radius: 10px; padding: 1.5rem 1rem;">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
                                </div>

                                <div class="form-group">
                                    <input type="number" name="nomer_wa" class="form-control form-control-user" placeholder="Nomor WhatsApp (Contoh: 08123456789)" value="{{ old('nomer_wa') }}" required
                                    style="border-radius: 10px; padding: 1.5rem 1rem;">
                                    <x-input-error :messages="$errors->get('nomer_wa')" class="mt-2 text-danger small" />
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required
                                        style="border-radius: 10px; padding: 1.5rem 1rem;">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" class="form-control form-control-user" placeholder="Ulangi Password" required
                                        style="border-radius: 10px; padding: 1.5rem 1rem;">
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-dark-classy btn-user btn-block" style="border-radius: 10px; padding: 0.8rem;">
                                    Daftar Sekarang
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small text-secondary font-weight-bold" href="{{ route('login') }}">Sudah punya akun? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sb-admin/js/sb-admin-2.min.js') }}"></script>
</body>
</html>
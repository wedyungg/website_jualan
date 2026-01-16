@extends('layouts.public')

@section('title', $package->name . ' — Fokuskesini')

@section('content')
<div class="container py-5" style="background-color: #ffffff;">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            
            <nav aria-label="breadcrumb" class="mb-5">
                <ol class="breadcrumb bg-transparent p-0 text-uppercase small" style="letter-spacing: 2px;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category.show', $package->category) }}" class="text-dark">{{ $package->category }}</a></li>
                    <li class="breadcrumb-item active text-muted">{{ $package->name }}</li>
                </ol>
            </nav>

            <div class="row no-gutters border" style="border-color: #eeeeee !important;">
                <div class="col-md-6 border-right" style="border-color: #eeeeee !important; background-color: #fcfcfc;">
                    @if($package->cover_image)
                        <?php
                        // Ambil hanya nama file dari path
                        $filename = basename($package->cover_image);
                        ?>
                        <img src="{{ asset('packages/' . $filename) }}" 
                             alt="{{ $package->name }}" 
                             class="img-fluid w-100 h-100" 
                             style="object-fit: cover; filter: grayscale(20%); transition: 0.5s;">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted" style="min-height: 450px;">
                            <i class="fas fa-camera fa-3x opacity-25"></i>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-6 d-flex align-items-center">
                    <div class="card-body p-5">
                        <span class="badge badge-dark mb-4 px-3 py-2 text-uppercase" style="border-radius: 0; font-size: 0.65rem; letter-spacing: 2px; background: #000;">
                            {{ $package->category }}
                        </span>
                        
                        <h1 class="display-5 font-weight-bold text-uppercase mb-3" style="letter-spacing: 3px; font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $package->name }}
                        </h1>
                        
                        <p class="text-muted small text-uppercase mb-5" style="letter-spacing: 1px;">
                            <i class="fas fa-history mr-2"></i> {{ $package->duration_hours }} Hours Professional Session
                        </p>
                        
                        <div class="mb-5">
                            <h6 class="text-muted small text-uppercase mb-1" style="letter-spacing: 1px;">Investment</h6>
                            <h2 class="h1 font-weight-bold text-dark">IDR {{ number_format($package->price, 0, ',', '.') }}</h2>
                        </div>
                        
                        <div class="mb-5">
                            <h6 class="text-muted small text-uppercase mb-3" style="letter-spacing: 1px;">Description</h6>
                            <p class="text-dark" style="line-height: 1.8; font-size: 0.95rem;">
                                {{ $package->description ?? 'No description available for this premium package.' }}
                            </p>
                        </div>

                        @if($package->features && is_array($package->features))
                        <div class="mb-5">
                            <h6 class="text-muted small text-uppercase mb-3" style="letter-spacing: 1px;">Package Includes</h6>
                            <ul class="list-unstyled">
                                @foreach($package->features as $feature)
                                    @if(trim($feature))
                                        <li class="mb-2 small text-uppercase" style="letter-spacing: 1px;">
                                            <i class="fas fa-minus mr-2 text-dark"></i> {{ $feature }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <div class="mt-5">
                            @auth
                                @if(auth()->user()->role === 'customer')
                                    <!-- PERBAIKAN: Ganti customer.dashboard dengan checkout -->
                                    <a href="{{ route('customer.checkout', $package->id) }}" 
   class="btn btn-dark btn-block py-4 font-weight-bold text-uppercase" 
   style="border-radius: 0; background: #000; letter-spacing: 3px;">
    PESAN SEKARANG
</a>
                                    
                                    <!-- OPTIONAL: Tambahkan link ke My Orders -->
                                    <div class="text-center mt-3">
                                        <a href="{{ route('customer.orders') }}" 
                                           class="text-muted small text-uppercase" 
                                           style="letter-spacing: 1px; text-decoration: none;">
                                            <i class="fas fa-shopping-bag mr-1"></i> View My Orders
                                        </a>
                                    </div>
                                @else
                                    <!-- Untuk Admin -->
                                    <a href="{{ route('admin.packages.index') }}" 
                                       class="btn btn-outline-dark btn-block py-4 font-weight-bold text-uppercase" 
                                       style="border-radius: 0; letter-spacing: 2px; border-width: 2px;">
                                        <i class="fas fa-cog mr-2"></i> MANAGE PACKAGES
                                    </a>
                                @endif
                            @else
                                <!-- Untuk Guest/Not Login -->
                                <a href="{{ route('login') }}" 
                                   class="btn btn-dark btn-block py-4 font-weight-bold text-uppercase" 
                                   style="border-radius: 0; background: #000; letter-spacing: 3px;">
                                    <i class="fas fa-sign-in-alt mr-2"></i> LOGIN TO BOOK
                                </a>
                                
                                <!-- Optional: Register link -->
                                <div class="text-center mt-3">
                                    <span class="text-muted small">Don't have an account?</span>
                                    <a href="{{ route('register') }}" 
                                       class="text-dark small ml-2 font-weight-bold text-uppercase" 
                                       style="letter-spacing: 1px; text-decoration: none;">
                                        REGISTER NOW
                                    </a>
                                </div>
                            @endauth
                        </div>

                    </div>
                </div>
            </div>
            
            <!-- Back to Packages Button -->
            <div class="text-center mt-5">
                <a href="{{ route('category.show', $package->category) }}" 
                   class="btn btn-outline-dark btn-lg text-uppercase" 
                   style="border-radius: 0; letter-spacing: 2px; padding: 12px 40px;">
                    <i class="fas fa-arrow-left mr-2"></i> Back to {{ $package->category }} Packages
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Add FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Optional: Add Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* 🖤 CUSTOM LUXURY STYLE */
    .breadcrumb-item + .breadcrumb-item::before {
        content: "|";
        color: #eeeeee;
    }
    
    img:hover {
        filter: grayscale(0%);
        transform: scale(1.01);
        transition: all 0.5s ease;
    }

    /* Link hover effect */
    .breadcrumb-item a:hover {
        text-decoration: underline;
        color: #000 !important;
    }
    
    /* Button hover effects */
    .btn-dark:hover {
        background-color: #333 !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .btn-outline-dark:hover {
        background-color: #000 !important;
        color: white !important;
        transform: translateY(-2px);
    }
    
    /* Badge styling */
    .badge-dark {
        background: linear-gradient(135deg, #000 0%, #333 100%) !important;
    }
    
    /* Feature list styling */
    ul.list-unstyled li {
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 10px;
    }
    
    ul.list-unstyled li:last-child {
        border-bottom: none;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .border-right {
            border-right: none !important;
            border-bottom: 1px solid #eeeeee !important;
        }
        
        .card-body {
            padding: 2rem !important;
        }
        
        h1.display-5 {
            font-size: 2rem !important;
        }
    }
</style>
@endsection
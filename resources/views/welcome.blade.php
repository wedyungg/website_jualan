@extends('layouts.public')

@section('content')

<header style="background-color: #000; color: #fff; padding: 100px 0; border-bottom: 1px solid #333;">
    <div class="container text-center">
        <h1 class="display-4 font-weight-bold mb-3" style="letter-spacing: 10px; text-transform: uppercase;">
            FOKUSKESINI
        </h1>
        <p class="lead mb-0" style="font-weight: 300; letter-spacing: 5px; text-transform: uppercase; opacity: 0.7;">
            Abadikan momen berhargamu dengan estetik.
        </p>
    </div>
</header>

<section id="kategori" class="container py-5 mt-5">
    <div class="text-center mb-5">
        <h2 class="font-weight-bold text-uppercase" style="letter-spacing: 3px; font-size: 1.2rem;">Pilih Kategori Layanan</h2>
        <div style="width: 40px; height: 1px; background: #000; margin: 20px auto;"></div>
    </div>

    <div class="row justify-content-center">
        @forelse($categories as $item)
        <div class="col-lg-4 col-md-6 mb-4">
            <a href="{{ route('category.show', $item->category) }}" style="text-decoration: none;">
                <div class="card border text-white text-center d-flex align-items-center justify-content-center card-category" 
                     style="height: 250px; background-color: #000; border-radius: 0; border: 1px solid #000; transition: 0.4s;">
                    
                    <div class="p-4">
                        <h4 class="font-weight-bold text-uppercase m-0" style="letter-spacing: 4px; font-size: 1rem;">
                            {{ $item->category }}
                        </h4>
                        <small class="text-uppercase mt-2 d-block" style="letter-spacing: 2px; opacity: 0.6; font-size: 0.6rem;">
                            Lihat Semua Paket <i class="fas fa-arrow-right ml-1"></i>
                        </small>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted font-italic">Belum ada kategori yang tersedia.</p>
        </div>
        @endforelse
    </div>
</section>

<style>
    /* Efek Hover Luxury: Putih dadi Hitam utawa sewalike */
    .card-category:hover {
        background-color: #ffffff !important;
        color: #000000 !important;
        border: 1px solid #000000 !important;
        transform: translateY(-5px);
    }
</style>

@endsection
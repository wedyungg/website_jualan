@extends('layouts.public')

@section('content')
<div class="container py-5 mt-5">
    <div class="text-center mb-5">
        <h2 class="font-weight-bold text-uppercase" style="letter-spacing: 5px; font-size: 1.5rem;">
            {{ $category }} COLLECTION
        </h2>
        <div style="width: 60px; height: 1px; background: #000; margin: 20px auto;"></div>
        <p class="text-muted small text-uppercase" style="letter-spacing: 2px;">Pilih paket yang sesuai dengan kebutuhanmu</p>
    </div>

    <div class="row">
        @forelse($packages as $package)
        <div class="col-lg-4 col-md-6 mb-5">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 0; transition: 0.3s;">
                <img src="{{ asset('storage/' . $package->cover_image) }}" 
                     class="card-img-top" 
                     alt="{{ $package->name }}"
                     style="border-radius: 0; height: 250px; object-fit: cover;">
                
                <div class="card-body text-center p-4">
                    <h5 class="font-weight-bold text-uppercase mb-2" style="letter-spacing: 2px; font-size: 1rem;">
                        {{ $package->name }}
                    </h5>
                    <p class="text-muted small mb-4" style="line-height: 1.6;">
                        {{ Str::limit($package->description, 80) }}
                    </p>
                    <h6 class="font-weight-bold mb-4" style="letter-spacing: 1px;">
                        IDR {{ number_format($package->price, 0, ',', '.') }}
                    </h6>
                    
                    <a href="{{ route('package.show', $package->id) }}" 
                       class="btn btn-dark btn-block py-3" 
                       style="border-radius: 0; background: #000; font-size: 0.7rem; font-weight: 700; letter-spacing: 2px;">
                        DETAIL PAKET
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted font-italic">Belum ada paket untuk kategori ini.</p>
            <a href="{{ route('home') }}" class="btn btn-outline-dark mt-3" style="border-radius: 0;">KEMBALI KE HOME</a>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* Hover effect nggo kartu paket */
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
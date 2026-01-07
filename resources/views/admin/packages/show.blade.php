@extends('layouts.public')

@section('title', $package->name . ' — Fokuskesini')

@section('content')
<div class="container py-5 mt-5">
    <div class="row no-gutters border" style="border-radius: 0;">
        <div class="col-md-7 border-right">
            <div style="background: #f9f9f9;">
                <img src="{{ asset('storage/' . $package->cover_image) }}" 
                     class="img-fluid w-100" 
                     alt="{{ $package->name }}"
                     style="border-radius: 0; min-height: 500px; object-fit: cover;">
            </div>
        </div>

        <div class="col-md-5 d-flex align-items-center bg-white">
            <div class="p-5 w-100">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-transparent p-0 small text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                        <li class="breadcrumb-item active text-muted" aria-current="page">{{ $package->category }}</li>
                    </ol>
                </nav>

                <h1 class="font-weight-bold text-uppercase mb-3" style="letter-spacing: 2px; font-size: 2rem;">
                    {{ $package->name }}
                </h1>
                
                <h3 class="font-weight-bold mb-4" style="letter-spacing: 1px;">
                    Rp {{ number_format($package->price, 0, ',', '.') }}

                <div class="border-top border-bottom py-4 mb-4">
                    <p class="text-muted" style="line-height: 1.8; font-weight: 300;">
                        {{ $package->description }}
                    </p>
                </div>

                <ul class="list-unstyled mb-5">
                    <li class="mb-3 small text-uppercase font-weight-bold" style="letter-spacing: 1px;">
                        <i class="fas fa-clock mr-2"></i> Durasi: {{ $package->duration_hours }} Jam
                    </li>
                    
                    @if($package->features)
                        @foreach($package->features as $feature)
                        <li class="mb-2 small text-uppercase" style="letter-spacing: 1px;">
                            <i class="fas fa-check mr-2 text-success"></i> {{ $feature }}
                        </li>
                        @endforeach
                    @else
                        <li class="text-muted small italic">Fitur tambahan belum diisi.</li>
                    @endif
                </ul>

                <a href="{{ route('checkout', $package->id) }}" 
                   class="btn btn-dark btn-block py-3 font-weight-bold text-uppercase" 
                   style="border-radius: 0; letter-spacing: 3px; background: #000;">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.public')

@section('title', $package->name . ' — Fokuskesini')

@section('content')
<div class="container py-5 mt-5">
    <div class="row no-gutters border">
        <div class="col-md-7 border-right">
            <div style="background: #f9f9f9;">
                <img src="{{ asset('storage/' . $package->cover_image) }}" 
                     class="img-fluid w-100" 
                     alt="{{ $package->name }}">
            </div>
        </div>

        <div class="col-md-5 d-flex align-items-center bg-white">
            <div class="p-5 w-100">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-transparent p-0 small text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item active text-dark font-weight-bold" aria-current="page">{{ $package->category }}</li>
                    </ol>
                </nav>

                <h1 class="font-weight-bold text-uppercase mb-3" style="letter-spacing: 2px; font-size: 2rem;">
                    {{ $package->name }}
                </h1>
                
                <h3 class="font-weight-bold mb-4" style="letter-spacing: 1px;">
                    IDR {{ number_format($package->price, 0, ',', '.') }}
                </h3>

                <div class="border-top border-bottom py-4 mb-4">
                    <p class="text-muted" style="line-height: 1.8; font-weight: 300;">
                        {{ $package->description }}
                    </p>
                </div>

                <ul class="list-unstyled mb-5">
                    <li class="mb-2 small text-uppercase" style="letter-spacing: 1px;">
                        <i class="fas fa-clock mr-2"></i> Durasi: {{ $package->duration_hours }} Jam
                    </li>
                    <li class="mb-2 small text-uppercase" style="letter-spacing: 1px;">
                        <i class="fas fa-check mr-2"></i> Profesional Equipment
                    </li>
                </ul>

                <a href="https://wa.me/6285158018020?text=Halo Fokuskesini, saya tertarik dengan paket {{ $package->name }}" 
                   target="_blank"
                   class="btn btn-dark btn-block py-3 font-weight-bold text-uppercase" 
                   style="border-radius: 0; letter-spacing: 3px; background: #000;">
                    Booking via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
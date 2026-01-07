@extends('layouts.public')

@section('title', 'Pesanan Saya — Fokuskesini')

@section('content')
<div class="container py-5 mt-5">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <h2 class="font-weight-bold text-uppercase m-0" style="letter-spacing: 3px;">Pesanan Saya</h2>
        <a href="{{ route('home') }}" class="btn btn-outline-dark btn-sm" style="border-radius: 0;">Tambah Pesanan</a>
    </div>

    @forelse($bookings as $booking)
    <div class="card mb-4 border shadow-none" style="border-radius: 0;">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <span class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">
                <i class="fas fa-camera mr-2"></i> {{ $booking->package->name }}
            </span>
            <span class="badge {{ $booking->status == 'pending' ? 'badge-dark' : 'badge-success' }} px-3 py-2 text-uppercase" 
                  style="border-radius: 0; font-size: 0.6rem; letter-spacing: 1px;">
                {{ $booking->status }}
            </span>
        </div>
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="{{ asset('storage/' . $booking->package->cover_image) }}" 
                         class="img-fluid border" style="border-radius: 0; filter: grayscale(100%);">
                </div>
                <div class="col-md-7">
                    <h5 class="font-weight-bold mb-1 text-uppercase small" style="letter-spacing: 1px;">Rencana Foto: {{ $booking->booking_date->format('d M Y') }}</h5>
                    <p class="text-muted small mb-0">Jam: {{ $booking->booking_time }} WIB</p>
                    <p class="text-muted small">Lokasi: {{ $booking->location }}</p>
                </div>
                <div class="col-md-3 text-right">
                    <p class="small text-muted mb-0">Total Pembayaran</p>
                    <h5 class="font-weight-bold">Rp. {{ number_format($booking->total_price, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light border-top text-right">
            <a href="https://wa.me/6285158018020?text=Halo Admin, saya ingin tanya status pesanan #{{ $booking->id }}" 
               class="btn btn-dark btn-sm px-4" style="border-radius: 0; background: #000; font-size: 0.7rem;">
                HUBUNGI ADMIN
            </a>
        </div>
    </div>
    @empty
    <div class="text-center py-5 border">
        <p class="text-muted italic">Belum ada riwayat pesanan.</p>
    </div>
    @endforelse
</div>
@endsection
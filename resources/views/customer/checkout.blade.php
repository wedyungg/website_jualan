@extends('layouts.public')

@section('title', 'Checkout — Fokuskesini')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="font-weight-bold text-uppercase mb-5 text-center" style="letter-spacing: 5px;">Checkout</h2>
            
            <div class="row no-gutters border">
                <div class="col-md-5 bg-dark text-white p-5 d-flex flex-column justify-content-center">
                    <h6 class="text-uppercase small mb-2 opacity-50" style="letter-spacing: 2px;">Paket Yang Dipilih</h6>
                    <h3 class="font-weight-bold text-uppercase mb-4" style="letter-spacing: 2px;">{{ $package->name }}</h3>
                    <h4 class="font-weight-bold">Rp. {{ number_format($package->price, 0, ',', '.') }}</h4>
                    <hr class="border-secondary w-100 my-4">
                    <p class="small italic opacity-75">{{ $package->description }}</p>
                </div>

                <div class="col-md-7 bg-white p-5">
                    <form action="{{ route('customer.bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->id }}">

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="small font-weight-bold text-uppercase">Tanggal Sesi Foto</label>
                                <input type="date" name="booking_date" class="form-control" 
                                       style="border-radius: 0; border: 1px solid #000;" required 
                                       min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="small font-weight-bold text-uppercase">Jam Mulai</label>
                                <input type="time" name="booking_time" class="form-control" 
                                       style="border-radius: 0; border: 1px solid #000;" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold text-uppercase">Lokasi Sesi Foto</label>
                            <textarea name="location" class="form-control" rows="3" 
                                      style="border-radius: 0; border: 1px solid #000;" 
                                      placeholder="Contoh: Studio Fokus, Lapangan Pancasila, atau Alamat Rumah..." required></textarea>
                        </div>

                        <div class="form-group mb-5">
                            <label class="small font-weight-bold text-uppercase">Catatan (Opsional)</label>
                            <textarea name="notes" class="form-control" rows="2" 
                                      style="border-radius: 0; border: 1px solid #000;" 
                                      placeholder="Misal: Request warna background putih..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark btn-block py-3 font-weight-bold text-uppercase" 
                                style="border-radius: 0; background: #000; letter-spacing: 2px;">
                            KONFIRMASI BOOKING
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
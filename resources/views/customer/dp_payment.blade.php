@extends('layouts.public')

@section('title', 'Bayar DP — Fokuskesini')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 p-4" style="border: 1px solid #000 !important; border-radius: 0;">
                <h5 class="font-weight-bold text-uppercase mb-4" style="letter-spacing: 2px;">Konfirmasi DP Manual</h5>
                
                <div class="row mb-4">
                    <div class="col-6">
                        <small class="text-muted text-uppercase small" style="letter-spacing: 1px;">Tagihan DP (40%)</small>
                        <h3 class="font-weight-bold">Rp {{ number_format($booking->down_payment, 0, ',', '.') }}</h3>
                    </div>
                    <div class="col-6 text-right">
                        <small class="text-muted text-uppercase small" style="letter-spacing: 1px;">Sisa Pelunasan</small>
                        <p class="font-weight-bold text-muted mb-0">Rp {{ number_format($booking->remaining_payment, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="p-4 mb-4 text-dark" style="background: #fdfdfd; border: 1px dashed #000;">
                    <h6 class="font-weight-bold text-uppercase small mb-3" style="letter-spacing: 1px;">Tujuan Transfer:</h6>
                    <div class="d-flex align-items-center">
                        <div class="mr-3 p-2 bg-dark text-white font-weight-bold small">BANK JAGO</div>
                        <div>
                            <div class="h4 mb-0 font-weight-bold text-monospace">1074 3984 6457</div>
                            <small class="text-muted text-uppercase">a.n Muhammad Ziyan Firdaus</small>
                        </div>
                    </div>
                </div>

                <form action="{{ route('customer.orders.upload_dp', $booking->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-uppercase" style="letter-spacing: 1px;">Upload Bukti Transfer (JPG/PNG)</label>
                        <input type="file" name="payment_proof" class="form-control-file p-2 border w-100" style="border-radius: 0;" required>
                    </div>

                    <button type="submit" class="btn btn-dark btn-block py-3 font-weight-bold text-uppercase" style="border-radius: 0; background: #000; letter-spacing: 2px;">
                        KIRIM BUKTI PEMBAYARAN
                    </button>
                    <a href="{{ route('customer.orders') }}" class="btn btn-link btn-block text-dark small mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
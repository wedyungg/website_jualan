@extends('layouts.public')

@section('title', 'Bayar DP Snap — Fokuskesini')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-none p-4" style="border: 1px solid #000 !important; border-radius: 0;">
                <h5 class="font-weight-bold text-uppercase mb-4" style="letter-spacing: 2px;">Pembayaran DP (40%)</h5>
                
                <div class="alert alert-dark mb-4 text-center" style="border-radius: 0; background: #000; color: #fff; border: none;">
                    <small class="text-uppercase small mr-2" style="letter-spacing: 1px;">Selesaikan Sebelum:</small>
                    <span class="font-weight-bold small text-warning">{{ $booking->payment_deadline->format('d M, H:i') }} WIB</span>
                </div>

                <div class="mb-4 border-bottom pb-3">
                    <p class="small text-muted mb-1 text-uppercase small" style="letter-spacing: 1px;">Detail Tagihan</p>
                    <div class="d-flex justify-content-between align-items-center mb-1 small">
                        <span>Total Paket:</span>
                        <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center font-weight-bold text-dark">
                        <span class="text-uppercase">Tagihan DP:</span>
                        <span style="font-size: 1.5rem;">Rp {{ number_format($booking->down_payment, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button id="pay-button" class="btn btn-dark btn-block py-3 font-weight-bold text-uppercase" 
                        style="border-radius: 0; background: #000; letter-spacing: 2px;">
                    BAYAR OTOMATIS SEKARANG
                </button>
                
                <p class="text-center small text-muted mt-4 italic">
                    * Pembayaran sisa 60% (Rp {{ number_format($booking->remaining_payment, 0, ',', '.') }}) dibayarkan manual sebelum acara.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ env('MIDTRANS_SNAP_URL') }}" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){ window.location.href = "{{ route('customer.orders') }}"; },
            onPending: function(result){ window.location.href = "{{ route('customer.orders') }}"; },
            onError: function(result){ alert("Pembayaran Gagal!"); }
        });
    };
</script>
@endsection
@extends('layouts.public')

@section('title', 'Pesanan Saya — Fokuskesini')

@section('content')
<style>
    /* 🛠️ LUXURY MONOCHROME SYSTEM */
    .card, .btn, .alert, .badge, .form-control, .border-left, .timer-box {
        border-radius: 0 !important; /* Zero Rounded Corners */
    }
    
    body { background-color: #FFFFFF; }

    /* Typography */
    .text-uppercase-luxury {
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Buttons */
    .btn-dark {
        background: #000000 !important;
        border: 1px solid #000000 !important;
        color: #FFFFFF !important;
        transition: 0.3s;
    }
    .btn-dark:hover {
        background: #333333 !important;
        letter-spacing: 3px;
    }
    .btn-outline-dark {
        border: 1px solid #000000 !important;
        color: #000000 !important;
        background: transparent !important;
    }

    /* Badges Monochrome */
    .badge-fks {
        padding: 10px 15px;
        font-size: 0.65rem;
        font-weight: 700;
        border: 1px solid #000;
    }
    .status-pending, .status-dp_paid, .status-dp_verified, .status-full_paid, .status-confirmed {
        background: #000000 !important;
        color: #FFFFFF !important;
    }
    .status-expired, .status-cancelled {
        background: #FAFAFA !important;
        color: #000000 !important;
        border: 1px solid #000000 !important;
    }

    /* Alerts */
    .alert-fks {
        background: #FAFAFA !important;
        border: 1px solid #000 !important;
        color: #000 !important;
    }

    /* Timer Box Luxury Digital */
    .timer-box {
        background: #000000 !important;
        padding: 15px;
        border: 1px solid #000 !important;
        min-width: 150px;
    }
    .timer-neon {
        font-family: 'Courier New', Courier, monospace;
        letter-spacing: 3px;
        font-size: 1.4rem;
        font-weight: bold;
    }
    .neon-green { color: #39ff14 !important; text-shadow: 0 0 5px #39ff14; }
    .neon-yellow { color: #ffde59 !important; text-shadow: 0 0 5px #ffde59; }
    .neon-red { color: #ff3131 !important; text-shadow: 0 0 5px #ff3131; }

    /* Image Filter */
    .img-fks {
        filter: grayscale(100%);
        transition: 0.5s;
        border: 1px solid #eee;
    }
    .img-fks:hover { filter: grayscale(0%); }
</style>

<div class="container py-5 mt-5">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <h2 class="font-weight-bold text-uppercase-luxury m-0">Pesanan Saya</h2>
        <a href="{{ route('home') }}" class="btn btn-dark btn-sm px-4">
            <i class="fas fa-plus mr-2"></i> Paket Baru
        </a>
    </div>

    {{-- Notifications --}}
    @if(session('error') || session('success'))
    <div class="alert alert-fks alert-dismissible fade show mb-4">
        <i class="fas {{ session('error') ? 'fa-exclamation-circle' : 'fa-check-circle' }} mr-2"></i>
        <span class="text-uppercase small font-weight-bold">{{ session('error') ?? session('success') }}</span>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    {{-- 🏦 BANK JAGO INFO SECTION --}}
    @php $bankAccount = \App\Models\Booking::getBankAccount(); @endphp
    <div class="card mb-5 border-0 shadow-none" style="border: 1px solid #000 !important; background: #FAFAFA;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-1 text-center d-none d-md-block">
                    <i class="fas fa-university fa-3x"></i>
                </div>
                <div class="col-md-8 border-left-md">
                    <h6 class="text-uppercase-luxury small font-weight-bold mb-2">Transfer DP 40% Ke:</h6>
                    <div class="d-flex align-items-center">
                        <span class="h2 font-weight-bold mb-0 mr-3" id="accNumber">{{ $bankAccount['number'] }}</span>
                        <button class="btn btn-dark btn-sm" onclick="copyAcc()" style="font-size: 0.6rem;">COPY</button>
                    </div>
                    <p class="mb-0 text-uppercase font-weight-bold small mt-1">{{ $bankAccount['bank'] }} — A.N {{ $bankAccount['name'] }}</p>
                </div>
                <div class="col-md-3 text-right">
                    <small class="text-muted d-block italic font-weight-bold text-uppercase" style="font-size: 0.6rem;">* Berlaku Sistem DP 40%</small>
                </div>
            </div>
        </div>
    </div>

    @forelse($bookings as $booking)
    <div class="card mb-4 border shadow-none" style="border: 1px solid #000 !important;">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #000 !important;">
            <span class="small text-uppercase font-weight-bold" style="letter-spacing: 2px;">
                <i class="fas fa-hashtag mr-2 text-muted"></i> INV/{{ $booking->id }}/{{ $booking->created_at->format('Ymd') }}
            </span>
            <span class="badge badge-fks status-{{ $booking->status }}">
                {{ str_replace('_', ' ', $booking->status) }}
            </span>
        </div>
        
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-2">
                    @if($booking->package->cover_image)
                        <img src="{{ asset('storage/' . $booking->package->cover_image) }}" class="img-fluid img-fks w-100" style="height: 120px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center border" style="height: 120px;"><i class="fas fa-camera"></i></div>
                    @endif
                </div>
                
                <div class="col-md-6">
                    <h5 class="font-weight-bold text-uppercase-luxury mb-1">{{ $booking->package->name }}</h5>
                    <p class="mb-1 small font-weight-bold"><i class="fas fa-calendar-alt mr-2"></i>{{ $booking->booking_date->format('d M Y') }} | {{ $booking->booking_time }} WIB</p>
                    <p class="small text-muted mb-0"><i class="fas fa-map-marker-alt mr-2"></i>{{ $booking->location }}</p>
                </div>
                
                <div class="col-md-4 mt-3 mt-md-0 pl-md-4" style="border-left: 1px solid #eee;">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase d-block mb-1 font-weight-bold" style="font-size: 0.6rem;">Rincian Biaya:</small>
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>Total Paket:</span>
                            <span class="font-weight-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-danger font-weight-bold small">
                            <span>Wajib DP 40%:</span>
                            <span>Rp {{ number_format($booking->down_payment, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- ⏱️ COUNTDOWN TIMER BOX --}}
                    @if($booking->canPayDp() && $booking->payment_deadline)
                    <div class="timer-box text-center w-100">
                        <small class="text-uppercase d-block mb-1 font-weight-bold" style="font-size: 0.5rem; letter-spacing: 2px; color: #666;">Batas Waktu Transfer DP</small>
                        <span class="timer-neon neon-green" id="timer-{{ $booking->id }}">00:00:00</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center" style="border-top: 1px solid #000 !important;">
            <div>
                @if($booking->canPayDp())
                    <a href="{{ route('customer.orders.dp_payment', $booking->id) }}" class="btn btn-dark btn-sm px-4 mr-2">
                        <i class="fas fa-upload mr-2"></i> Upload Bukti DP
                    </a>
                @elseif($booking->canPayFull())
                    <a href="{{ route('customer.orders.full_payment', $booking->id) }}" class="btn btn-dark btn-sm px-4 mr-2">
                        <i class="fas fa-check-double mr-2"></i> Pelunasan 60%
                    </a>
                @endif
            </div>
            
            <div class="d-flex align-items-center">
                <a href="{{ route('customer.orders.show', $booking->id) }}" class="btn btn-outline-dark btn-sm mr-2 px-3">DETAIL</a>
                <a href="https://wa.me/6285158018020" class="btn btn-outline-dark btn-sm px-3" target="_blank"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5 border" style="border: 1px solid #000 !important;">
        <p class="text-uppercase-luxury small font-weight-bold">Belum Ada Riwayat Pesanan</p>
    </div>
    @endforelse
</div>

{{-- 🚀 JS DARI DEEPSEEK (TIDAK DIUBAH LOGIKANYA) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    function copyAcc() {
        const acc = "{{ $bankAccount['number'] }}";
        navigator.clipboard.writeText(acc).then(() => alert("Nomor rekening disalin: " + acc));
    }
    window.copyAcc = copyAcc;

    @foreach($bookings as $booking)
        @if($booking->payment_deadline && $booking->canPayDp())
            updateCountdown('{{ $booking->id }}', '{{ $booking->payment_deadline->format("Y-m-d H:i:s") }}');
        @endif
    @endforeach
    
    function updateCountdown(bookingId, deadlineStr) {
        const timerElement = document.getElementById(`timer-${bookingId}`);
        if (!timerElement) return;
        const deadline = new Date(deadlineStr).getTime();
        
        const interval = setInterval(function() {
            const now = new Date().getTime();
            const distance = deadline - now;
            
            if (distance < 0) {
                timerElement.innerHTML = "EXPIRED";
                timerElement.className = "timer-neon neon-red";
                clearInterval(interval);
                setTimeout(() => window.location.reload(), 3000);
                return;
            }
            
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            timerElement.innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (hours < 2) {
                timerElement.className = "timer-neon neon-red";
            } else if (hours < 12) {
                timerElement.className = "timer-neon neon-yellow";
            } else {
                timerElement.className = "timer-neon neon-green";
            }
        }, 1000);
    }
});
</script>
@endsection
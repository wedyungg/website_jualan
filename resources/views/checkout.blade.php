@extends('layouts.public')

@section('title', 'Pemesanan — ' . $package->name)

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <h2 class="font-weight-bold text-uppercase" style="letter-spacing: 5px;">Formulir Pemesanan</h2>
                <div style="width: 50px; height: 1px; background: #000; margin: 20px auto;"></div>
                <p class="text-muted small text-uppercase" style="letter-spacing: 2px;">Isi data di bawah ini untuk mengunci jadwalmu</p>
            </div>

            <div class="card border shadow-none" style="border-radius: 0;">
                <div class="card-body p-5">
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->id }}">

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Paket yang Kamu Pilih</label>
                                <div class="p-3 border bg-light font-weight-bold" style="letter-spacing: 1px; color: #000;">
                                    {{ $package->name }} — Rp. {{ number_format($package->price, 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Rencana Tanggal Foto</label>
                                <input type="date" name="booking_date" class="form-control" style="border-radius: 0; border: 1px solid #000;" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Jam Mulai Pemotretan</label>
                                <input type="time" name="booking_time" class="form-control" style="border-radius: 0; border: 1px solid #000;" required>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Lokasi atau Alamat Lengkap</label>
                                <textarea name="location" rows="3" class="form-control" style="border-radius: 0; border: 1px solid #000;" placeholder="Contoh: Gedung IPHI Pati atau Alamat Rumah..." required></textarea>
                            </div>

                            <div class="col-md-12 mb-5">
                                <label class="small text-uppercase font-weight-bold" style="letter-spacing: 1px;">Catatan atau Permintaan Khusus (Opsional)</label>
                                <textarea name="notes" rows="2" class="form-control" style="border-radius: 0; border: 1px solid #000;" placeholder="Contoh: Pengen tema baju adat, atau request foto bareng keluarga besar."></textarea>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark btn-block py-3 font-weight-bold text-uppercase" style="border-radius: 0; background: #000; letter-spacing: 3px;">
                                    Konfirmasi & Pesan Sekarang
                                </button>
                                <p class="text-center mt-3 small text-muted italic">
                                    *Setelah klik tombol di atas, tim Fokuskesini akan segera menghubungimu.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
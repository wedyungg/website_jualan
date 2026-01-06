@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Pelanggan</h1>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow h-100 py-2" style="background: #1a1a1a; border-left: 4px solid #f6c23e; border-radius: 15px;">
                <div class="card-body p-5">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Selamat Datang di Fokuskesini
                            </div>
                            <div class="h2 mb-0 font-weight-bold text-white">
                                Halo, {{ Auth::user()->name }}! 👋
                            </div>
                            <p class="text-gray-400 mt-3" style="font-size: 1.1rem;">
                                Siap mengabadikan momen berhargamu? Pilih paket fotografi terbaik yang kami sediakan khusus untuk Anda.
                            </p>
                            <a href="#" class="btn btn-warning btn-icon-split mt-3">
                                <span class="icon text-white-50">
                                    <i class="fas fa-camera"></i>
                                </span>
                                <span class="text">Lihat Paket Fotografi</span>
                            </a>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <i class="fas fa-images fa-5x text-gray-700"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pesanan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0 Pesanan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pesanan Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Pengaturan Akun — Fokuskesini')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-5 border-bottom border-dark pb-4">
            <h2 class="fw-bold text-uppercase" style="letter-spacing: 5px; color: #000;">PENGATURAN PROFIL</h2>
            <p class="text-muted small mt-2">Kelola data diri dan keamanan akun Fokuskesini Anda secara mandiri.</p>
        </div>

        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="card border-dark shadow-none">
                    <div class="card-header bg-black text-black text-uppercase small fw-bold py-3 px-6" style="letter-spacing: 2px;">
                        <i class="fas fa-info-circle mr-2"></i> Informasi Dasar
                    </div>
                    <div class="card-body border border-dark border-top-0 p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="card border-dark shadow-none">
                    <div class="card-header bg-black text-black text-uppercase small fw-bold py-3 px-6" style="letter-spacing: 2px;">
                        <i class="fas fa-key mr-2"></i> Kata Sandi
                    </div>
                    <div class="card-body border border-dark border-top-0 p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-danger shadow-none" style="border-style: dashed !important; border-width: 2px !important;">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold text-danger text-uppercase m-0" style="letter-spacing: 1px;">Hapus Akun Permanen</h6>
                            <p class="small text-muted m-0">Seluruh data Anda akan dihapus selamanya dari sistem Fokuskesini.</p>
                        </div>
                        <div class="ml-auto">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
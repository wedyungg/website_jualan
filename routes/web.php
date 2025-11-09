<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah kamu mendaftarkan rute web untuk aplikasimu.
| Rute-rute ini dimuat oleh RouteServiceProvider dan semuanya akan
| dimasukkan ke dalam grup middleware "web".
|
*/

// Halaman awal (Welcome page)
Route::get('/', function () {
    return view('welcome');
});

// Halaman Dashboard (Bisa diakses oleh SEMUA user yang sudah login & verifikasi email)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup rute untuk profil user (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================================
//           RUTE TAMBAHAN UNTUK TUGAS E-BUSINESS
// ==========================================================

// GRUP 1: Rute untuk SEMUA USER (Admin & Customer)
// Syarat: Harus login ('auth') dan email terverifikasi ('verified')
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Contoh: Halaman lihat pesanan saya
    // URL: http://127.0.0.1:8000/my-orders
    Route::get('/my-orders', function () {
        // Nanti kamu bisa ganti ini dengan: return view('customer.orders');
        return 'Halo! Ini adalah halaman pesanan Anda. (Bisa diakses Admin & Customer)';
    })->name('orders.my');

});


// GRUP 2: Rute KHUSUS ADMIN
// Syarat: Harus login ('auth'), email terverifikasi ('verified'), DAN role-nya admin ('is_admin')
Route::middleware(['auth', 'verified', 'is_admin'])->group(function () {
    
    // Contoh: Dashboard khusus Admin
    // URL: http://127.0.0.1:8000/admin/dashboard
    Route::get('/admin/dashboard', function () {
        // Nanti kamu bisa ganti ini dengan: return view('admin.dashboard');
        return 'SELAMAT DATANG, ADMIN! Ini halaman rahasia Anda.';
    })->name('admin.dashboard');

    // Contoh: Halaman kelola produk
    // URL: http://127.0.0.1:8000/admin/products
    Route::get('/admin/products', function () {
        return 'Halaman Admin untuk mengelola produk.';
    })->name('admin.products');

});

// Memuat file rute autentikasi bawaan Breeze (login, register, dll)
require __DIR__.'/auth.php';
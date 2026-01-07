<?php

use App\Models\Package;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Customer\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes - Fokuskesini Luxury Photography
|--------------------------------------------------------------------------
*/

// --- HALAMAN PUBLIK (CLIENT SIDE) ---

/**
 * 1. Halaman Utama: Menampilkan Daftar Kategori
 * Menampilkan pilihan: Wedding, Wisuda, Engagement, dll.
 */
Route::get('/', function () {
    // Jupuk kategori sing unik, aktif, LAN ora kosong (NotNull & Not Empty)
    $categories = Package::select('category')
        ->distinct()
        ->where('is_active', true)
        ->whereNotNull('category') // Mesthike ora null
        ->where('category', '!=', '') // Mesthike dudu string kosong
        ->get();

    return view('welcome', compact('categories'));
})->name('home');

// --- FITUR BOOKING / CHECKOUT (Kudu Login) ---
Route::middleware(['auth'])->group(function () {
    // Menampilkan halaman form pemesanan
    Route::get('/checkout/{package}', [App\Http\Controllers\BookingController::class, 'checkout'])->name('checkout');
    
    // Proses menyimpan data pemesanan
    Route::post('/checkout', [App\Http\Controllers\BookingController::class, 'store'])->name('checkout.store');
});

/**
 * 2. Daftar Paket per Kategori
 * Menampilkan semua paket yang ada di dalam kategori tertentu.
 */
Route::get('/kategori/{category}', function ($category) {
    $packages = Package::where('category', $category)->where('is_active', true)->get();
    return view('category_show', compact('packages', 'category'));
})->name('category.show');

/**
 * 3. Detail Paket
 * Menampilkan informasi lengkap satu paket saat kartu diklik.
 */
Route::get('/paket/{package}', [PackageController::class, 'show'])->name('package.show');


// --- PORTAL DASHBOARD (PENGALIHAN ROLE) ---

Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    
    $user = auth()->user();
    
    // 🎮 TELEPORT BERDASARKAN ROLE
    if ($user->role === 'admin') {
        // Nek Admin, tetep neng dapur (Admin Dashboard)
        return redirect()->route('admin.dashboard');
    } else {
        // Nek Customer, langsung neng "Toko" (Halaman Utama Kategori)
        return redirect()->route('home'); // <--- GANTI NENG KENE, LE!
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// --- AREA ADMINISTRATOR (KERAJAAN ADMIN) ---

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Manajemen Paket (CRUD: Create, Read, Update, Delete)
    Route::resource('packages', PackageController::class);
    
    // Manajemen Profil Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rencana Fitur Mendatang:
    // Route::resource('bookings', BookingController::class);
    // Route::resource('portfolio', PortfolioController::class);
});


// --- AREA PELANGGAN (DESA CUSTOMER) ---

Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    
    // Dashboard Utama Pelanggan
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    
    // Manajemen Profil Pelanggan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rencana Fitur Mendatang:
    // Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [App\Http\Controllers\BookingController::class, 'index'])->name('customer.orders');
});


// --- SISTEM AUTENTIKASI ---
require __DIR__.'/auth.php';
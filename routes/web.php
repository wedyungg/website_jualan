<?php

use Illuminate\Support\Facades\Route;
use App\Models\Package;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;

// --- HALAMAN PUBLIK ---
Route::get('/', function () {
    $categories = Package::select('category')->distinct()->where('is_active', true)->whereNotNull('category')->get();
    return view('welcome', compact('categories'));
})->name('home');

Route::get('/category/{category}', function ($category) {
    $packages = Package::where('category', $category)->where('is_active', true)->get();
    return view('category_show', compact('packages', 'category'));
})->name('category.show');

Route::get('/package/{id}', function ($id) {
    $package = Package::findOrFail($id);
    return view('package_show', compact('package'));
})->name('package.show');

// --- AREA TERPROTEKSI (Kudu Login) ---
Route::middleware(['auth'])->group(function () {
    
    // Portal Dashboard Otomatis
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('customer.orders');
    })->name('dashboard');

    // Rute Profil (Universal)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // GRUP RUTE ADMIN
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('packages', PackageController::class);
        Route::get('/bookings', [BookingAdminController::class, 'index'])->name('bookings.index');
        Route::patch('/bookings/{booking}/status', [BookingAdminController::class, 'updateStatus'])->name('bookings.updateStatus');
    });

    // GRUP RUTE CUSTOMER (Fitur Pesen & Riwayat)
    Route::prefix('customer')->name('customer.')->group(function () {
        // Halaman Checkout (Formulir Pesen)
        Route::get('/checkout/{package}', [BookingController::class, 'checkout'])->name('checkout');
        
        // Proses simpen booking neng database
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        
        // Riwayat pesanan
        Route::get('/orders', [BookingController::class, 'index'])->name('orders');
        Route::get('/orders/{booking}', [BookingController::class, 'show'])->name('orders.show');
        Route::post('/orders/{booking}/cancel', [BookingController::class, 'cancel'])->name('orders.cancel');
    });
});

require __DIR__.'/auth.php';
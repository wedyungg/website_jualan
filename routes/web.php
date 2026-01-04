<?php
// 🗺️ PETA DUNIA FOKUSKESINI

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\ProfileController;

// 🏠 HOME BASE
Route::get('/', function () {
    return view('welcome');
});

// ⚡ PORTAL DASHBOARD (Auto-Detect Role)
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    
    $user = auth()->user();
    
    // 🎮 TELEPORT BERDASARKAN ROLE
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// ==================== 🏰 KERAJAAN ADMIN ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // 🎮 DASHBOARD ADMIN
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // ⚙️ PROFILE ADMIN
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // 🎯 NANTI TAMBAHKAN QUEST ADMIN LAINNYA:
    // - Route::get('/users', 'UserController@index')->name('users');
    // - Route::get('/reservations', 'ReservationController@index')->name('reservations');
});

// ==================== 🏡 DESA CUSTOMER ====================
Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    // 🎮 DASHBOARD CUSTOMER
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    
    // ⚙️ PROFILE CUSTOMER
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // 🎯 NANTI TAMBAHKAN QUEST CUSTOMER:
    // - Route::get('/booking', 'BookingController@create')->name('booking.create');
    // - Route::get('/history', 'HistoryController@index')->name('history');
});

//packages
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // 📦 PASTIKAN INI ADA:
    Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);
    // ... lainnya
});

// ==================== 🔐 PORTAL AUTH ====================
require __DIR__.'/auth.php';
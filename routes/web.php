<?php

use Illuminate\Support\Facades\Route;
use App\Models\Package;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentCallbackController;

// Webhook Midtrans (Otomatis ganti status dadi Confirmed)
Route::post('/payment-callback', [PaymentCallbackController::class, 'receive']);

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

    // GRUP RUTE CUSTOMER
    Route::prefix('customer')->name('customer.')->group(function () {
        // Checkout
        Route::get('/checkout/{package}', [BookingController::class, 'checkout'])->name('checkout');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        
        // Orders
        Route::get('/orders', [BookingController::class, 'index'])->name('orders');
        Route::get('/orders/{booking}', [BookingController::class, 'show'])->name('orders.show');
        Route::delete('/orders/{booking}/cancel', [BookingController::class, 'cancel'])->name('orders.cancel');
        
        // DP Payment Routes
        Route::get('/orders/{booking}/dp-payment', [BookingController::class, 'dpPaymentPage'])->name('orders.dp_payment');
        Route::post('/orders/{booking}/upload-dp', [BookingController::class, 'uploadDpProof'])->name('orders.upload_dp');
        
        // Full Payment Routes
        Route::get('/orders/{booking}/full-payment', [BookingController::class, 'fullPaymentPage'])->name('orders.full_payment');
        Route::post('/orders/{booking}/upload-full', [BookingController::class, 'uploadFullProof'])->name('orders.upload_full');
        
        // Check Status (AJAX)
        Route::get('/orders/{booking}/check-status', [BookingController::class, 'checkStatus'])->name('orders.check_status');
    });
    
    // Debug route
    Route::get('/debug-booking/{id}', function($id) {
        $booking = \App\Models\Booking::find($id);
        
        if (!$booking) {
            return "Booking not found";
        }
        
        return response()->json([
            'id' => $booking->id,
            'status' => $booking->status,
            'user_id' => $booking->user_id,
            'total_price' => $booking->total_price,
            'down_payment' => $booking->down_payment,
            'remaining_payment' => $booking->remaining_payment,
            'created_at' => $booking->created_at,
            'is_pending' => $booking->status === 'pending',
            'auth_user' => auth()->check() ? auth()->id() : 'not logged in'
        ]);
    });
});

require __DIR__.'/auth.php';
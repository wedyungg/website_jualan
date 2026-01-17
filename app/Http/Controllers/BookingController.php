<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    // ==================== INDEX ====================
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
                          ->with('package')
                          ->latest()
                          ->get();
        
        $bankAccount = Booking::getBankAccount();
        
        return view('customer.orders', compact('bookings', 'bankAccount'));
    }

    // ==================== CHECKOUT ====================
    public function checkout(Package $package)
    {
        if (!$package->is_active) {
            return redirect()->route('home')
                           ->with('error', 'Paket tidak tersedia untuk dipesan.');
        }
        
        // Hitung DP 40%
        $downPayment = $package->price * 0.4;
        $remaining = $package->price * 0.6;
        
        return view('customer.checkout', compact('package', 'downPayment', 'remaining'));
    }

    // ==================== DP PAYMENT PAGE ====================
    public function dpPaymentPage(Booking $booking)
    {
        // 1. Authorization
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Booking ini bukan milik Anda.');
        }
        
        // 2. Status validation
        if (!$booking->canPayDp()) {
            if ($booking->isPaymentExpired()) {
                $booking->update(['status' => Booking::STATUS_EXPIRED]);
                return redirect()->route('customer.orders')
                               ->with('error', 'Waktu pembayaran DP telah kadaluarsa.');
            }
            
            return redirect()->route('customer.orders')
                           ->with('error', 'Tidak dapat membayar DP. Status: ' . strtoupper($booking->status));
        }
        
        // 3. Jika belum ada deadline, set deadline 24 jam dari sekarang
        if (!$booking->payment_deadline) {
            $booking->update([
                'payment_deadline' => Carbon::now()->addHours(24)
            ]);
        }
        
        // 4. Load relation
        $booking->load('package');
        
        // 5. Data pembayaran
        $bankAccount = Booking::getBankAccount();
        
        return view('customer.dp_payment', compact('booking', 'bankAccount'));
    }

    // ==================== FULL PAYMENT PAGE ====================
    public function fullPaymentPage(Booking $booking)
    {
        // 1. Authorization
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Unauthorized.');
        }
        
        // 2. Cek apakah bisa bayar full
        if (!$booking->canPayFull()) {
            return redirect()->route('customer.orders')
                           ->with('error', 'Belum bisa melakukan pelunasan. Status: ' . strtoupper($booking->status));
        }
        
        // 3. Load relation
        $booking->load('package');
        
        // 4. Data pembayaran
        $bankAccount = Booking::getBankAccount();
        
        return view('customer.full_payment', compact('booking', 'bankAccount'));
    }

    // ==================== UPLOAD DP PROOF ====================
    public function uploadDpProof(Request $request, Booking $booking)
    {
        // Authorization
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Unauthorized.');
        }
        
        // Validation
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_method' => 'required|in:transfer,cash'
        ]);
        
        // Check if still can pay DP
        if (!$booking->canPayDp()) {
            return back()->with('error', 'Pembayaran DP sudah kadaluarsa atau status tidak valid.');
        }
        
        // Upload image
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs/dp', 'public');
            
            $booking->update([
                'payment_proof' => $path,
                'payment_method' => $request->payment_method,
                'status' => Booking::STATUS_DP_PAID, // Menunggu verifikasi admin
                'dp_paid_at' => now()
            ]);
            
            return redirect()->route('customer.orders')
                           ->with('success', 'Bukti DP 40% berhasil diupload! Menunggu verifikasi admin.');
        }
        
        return back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }

    // ==================== UPLOAD FULL PAYMENT PROOF ====================
    public function uploadFullProof(Request $request, Booking $booking)
    {
        // Authorization
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Unauthorized.');
        }
        
        // Validation
        $request->validate([
            'full_payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        // Check if can pay full
        if (!$booking->canPayFull()) {
            return back()->with('error', 'Belum bisa melakukan pelunasan.');
        }
        
        // Upload image
        if ($request->hasFile('full_payment_proof')) {
            $path = $request->file('full_payment_proof')->store('payment_proofs/full', 'public');
            
            $booking->update([
                'full_payment_proof' => $path,
                'status' => Booking::STATUS_FULL_PAID,
                'is_full_paid' => true,
                'full_paid_at' => now()
            ]);
            
            return redirect()->route('customer.orders')
                           ->with('success', 'Bukti pelunasan berhasil diupload! Menunggu konfirmasi admin.');
        }
        
        return back()->with('error', 'Gagal mengupload bukti pelunasan.');
    }

    // ==================== STORE (CREATE BOOKING) ====================
    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'package_id'   => 'required|exists:packages,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
            'location'     => 'required|string|max:500',
            'notes'        => 'nullable|string|max:1000',
        ]);

        // 2. Get package
        $package = Package::findOrFail($validated['package_id']);
        
        // 3. Create booking dengan perhitungan DP otomatis
        $booking = Booking::create([
            'user_id'         => auth()->id(),
            'package_id'      => $package->id,
            'booking_date'    => $validated['booking_date'],
            'booking_time'    => $validated['booking_time'],
            'location'        => $validated['location'],
            'notes'           => $validated['notes'] ?? null,
            'total_price'     => $package->price,
            'status'          => Booking::STATUS_PENDING,
            'payment_deadline' => Carbon::now()->addHours(24)
        ]);

        // 4. Redirect ke halaman DP
        return redirect()->route('customer.orders.dp_payment', $booking->id)
                       ->with('success', 'Booking berhasil dibuat! Silakan bayar DP 40% dalam 24 jam.');
    }

    // ==================== CANCEL ====================
    public function cancel(Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Unauthorized.');
        }
        
        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }
        
        $booking->update(['status' => Booking::STATUS_CANCELLED]);
        
        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // ==================== SHOW DETAIL ====================
    public function show(Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Unauthorized.');
        }
        
        $booking->load('package', 'user');
        $bankAccount = Booking::getBankAccount();
        
        return view('customer.order_detail', compact('booking', 'bankAccount'));
    }

    // ==================== CHECK PAYMENT STATUS (AJAX) ====================
    public function checkStatus(Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Auto-update status jika expired
        if ($booking->isPaymentExpired() && $booking->status === Booking::STATUS_PENDING) {
            $booking->update(['status' => Booking::STATUS_EXPIRED]);
        }
        
        return response()->json([
            'status' => $booking->status,
            'remaining_time' => $booking->getRemainingTime(),
            'is_expired' => $booking->isPaymentExpired(),
            'payment_deadline' => $booking->payment_deadline?->format('Y-m-d H:i:s'),
            'badge' => $booking->getPaymentStatusBadge()
        ]);
    }
}
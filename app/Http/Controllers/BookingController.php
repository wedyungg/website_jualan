<?php

namespace App\Http\Controllers; // 🛠️ Iki alamate, ojo nganti ilang

use App\Models\Package;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller // 🛠️ Iki jeneng kelase
{
    /**
     * Menampilkan daftar pesanan milik user yang sedang login
     */
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
                           ->with('package')
                           ->latest()
                           ->get();
        
        return view('customer.orders', compact('bookings'));
    }

    /**
     * Menampilkan halaman checkout untuk paket yang dipilih
     */
    public function checkout(Package $package)
    {
        // 🛠️ Cek nek paket ora aktif, balekke wae
        if (!$package->is_active) {
            return redirect()->route('home')->with('error', 'Paket tidak tersedia.');
        }
        
        // Mlayu neng view customer.checkout
        return view('customer.checkout', compact('package'));
    }

    /**
     * Menyimpan data booking baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id'   => 'required|exists:packages,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'location'     => 'required|string|max:500',
            'notes'        => 'nullable|string|max:1000',
        ]);

        $package = Package::findOrFail($validated['package_id']);

        $booking = Booking::create([
            'user_id'      => auth()->id(),
            'package_id'   => $package->id,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'location'     => $validated['location'],
            'notes'        => $validated['notes'] ?? null,
            'total_price'  => $package->price,
            'status'       => 'pending',
        ]);

        return redirect()->route('customer.orders')
                         ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi admin.');
    }

    /**
     * Membatalkan pesanan (status: cancelled)
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }
        
        $booking->update(['status' => 'cancelled']);
        
        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
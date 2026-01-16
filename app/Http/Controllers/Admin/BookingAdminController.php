<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    /**
     * Menampilkan semua daftar pesanan untuk admin
     */
    public function index()
    {
        // Njupuk data booking soko sing paling anyar
        $bookings = Booking::with(['user', 'package'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Ngupdate status pesanan (Pending -> Confirmed -> Cancelled)
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan #' . $booking->id . ' sukses diupdate!');
    }
}
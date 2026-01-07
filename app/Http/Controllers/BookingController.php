<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * 1. MENAMPILKAN DAFTAR PESANAN SAYA (SHOPEE STYLE)
     * Halaman ini akan menampilkan riwayat pesanan user yang sedang login.
     */
    public function index()
    {
        // Jupuk data booking duweke user sing lagi login wae, urut soko sing paling anyar
        $bookings = Booking::where('user_id', auth()->user()->id)
                            ->latest()
                            ->get();

        // Nampilke view 'customer.orders' (Mengko awake dhewe gawe file iki)
        return view('customer.orders', compact('bookings'));
    }

    /**
     * 2. HALAMAN FORM CHECKOUT
     * Menampilkan formulir checkout untuk paket yang dipilih.
     */
    public function checkout(Package $package)
    {
        return view('checkout', compact('package'));
    }

    /**
     * 3. PROSES PENYIMPANAN DATA (EKSEKUSI)
     * Menyimpan data booking baru ke database.
     */
    public function store(Request $request)
    {
        // A. Validasi inputan ben ora diisi sembarangan
        $request->validate([
            'package_id'   => 'required|exists:packages,id',
            'booking_date' => 'required|date|after:today', // Anti tanggal wingi
            'booking_time' => 'required',
            'location'     => 'required|string|max:500',
            'notes'        => 'nullable|string',
        ]);

        // B. Jupuk data paket ben ngerti regane saiki
        $package = Package::findOrFail($request->package_id);

        // C. Simpen neng database (SOLUSI FOREIGN KEY ERROR WINGI)
        Booking::create([
            'user_id'      => auth()->user()->id, // Iki wis bener, njupuk ID angka (1,2,3)
            'package_id'   => $package->id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'location'     => $request->location,
            'notes'        => $request->notes,
            'total_price'  => $package->price, // Kunci rega pas transaksi
            'status'       => 'pending',       // Status awal: Menunggu Konfirmasi
        ]);

        // D. Redirect neng halaman "Pesanan Saya" (Shopee Style)
        // Dudu neng dashboard meneh, ben ora bingung ndelok angka 0.
        return redirect()->route('customer.orders')
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi admin.');
    }
}
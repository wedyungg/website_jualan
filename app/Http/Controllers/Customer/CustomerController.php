<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class CustomerController extends Controller
{
    // Menampilkan halaman dashboard customer
    public function dashboard()
    {
        return view('customer.dashboard');
    }

    // Menampilkan halaman daftar pesanan milik customer yang sedang login
    public function orders()
    {
        $bookings = Booking::where('user_id', auth()->id())->get();
        return view('customer.orders', compact('bookings'));
    }
}
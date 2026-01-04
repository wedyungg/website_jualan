<?php
// 🏡 RUMAH CUSTOMER CONTROLLER

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * 🎮 Tampilkan Dashboard Customer
     */
    public function dashboard()
    {
        return view('customer.dashboard', [
            'title' => 'Selamat Datang di Fokuskesini!',
            'user' => auth()->user(),
            'role' => 'VIP Customer',
            'welcome_message' => 'Siap untuk sesi foto yang epic?'
        ]);
    }
    
    /**
     * 📅 Booking Session (nanti)
     */
    public function booking()
    {
        return "Coming soon: Booking system!";
    }
}
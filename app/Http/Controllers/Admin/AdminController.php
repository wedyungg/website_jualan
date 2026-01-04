<?php
// 🏰 ISTANA ADMIN CONTROLLER

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * 🎮 Tampilkan Tahta Admin
     */
    public function dashboard()
    {
        return view('admin.dashboard', [
            'title' => 'Admin Dashboard - Fokuskesini',
            'user' => auth()->user(),
            'role' => 'Admin Supreme',
            'power_level' => '9000+'
        ]);
    }
    
    /**
     * 📊 Stats Kerajaan (nanti bisa ditambah)
     */
    public function stats()
    {
        // Akan diisi nanti
        return "Coming soon: Stats dashboard!";
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Ngitung Statistik nggo Card Dashboard
        $totalPackages = Package::count();
        $totalBookings = Booking::where('status', 'confirmed')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price') ?? 0;

        // 2. Data Grafik: Revenue saben sasi (Tahun Iki)
        $revenueData = Booking::select(
                DB::raw('MONTH(booking_date) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('status', 'confirmed')
            ->whereYear('booking_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Nyiapke array 12 sasi (Jan-Des) diisi angka 0 dhisik
        $monthlyRevenue = array_fill(1, 12, 0);
        foreach ($revenueData as $data) {
            $monthlyRevenue[(int)$data->month] = (int)$data->total;
        }

        // Ngirim kabeh variabel neng View
        return view('admin.dashboard', [
            'totalPackages'  => $totalPackages,
            'totalBookings'  => $totalBookings,
            'totalCustomers' => $totalCustomers,
            'totalRevenue'   => $totalRevenue,
            'chartData'      => array_values($monthlyRevenue)
        ]);
    }
}
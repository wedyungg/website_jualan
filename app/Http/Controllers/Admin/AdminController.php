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
        // 1. Statistik Utama nggo Cards
        $totalPackages = Package::count();
        $totalBookings = Booking::count(); // Kabeh booking nggo statistik
        $totalCustomers = User::where('role', 'customer')->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price') ?? 0;
        $pendingBookings = Booking::where('status', 'pending')->count();

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

        // Nyiapke array 12 sasi (Jan-Des) diisi angka 0
        $monthlyRevenue = array_fill(1, 12, 0);
        foreach ($revenueData as $data) {
            $monthlyRevenue[(int)$data->month] = (int)$data->total;
        }

        // 3. Data Grafik: Package Popularity (Pie Chart)
        $topPackages = Package::withCount(['bookings' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalPackages'  => $totalPackages,
            'totalBookings'  => $totalBookings,
            'totalCustomers' => $totalCustomers,
            'totalRevenue'   => $totalRevenue,
            'pendingBookings'=> $pendingBookings,
            'chartData'      => array_values($monthlyRevenue),
            'pieLabels'      => $topPackages->pluck('name'),
            'pieData'        => $topPackages->pluck('bookings_count'),
        ]);
    }
}
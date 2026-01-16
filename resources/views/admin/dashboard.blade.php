@extends('admin.layouts.master')
@section('title', 'Dashboard — Fokuskesini')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-dark font-weight-bold text-uppercase" style="letter-spacing: 2px;">Admin Dashboard</h1>
        <span class="badge badge-dark p-2 px-3" style="border-radius: 0; font-size: 0.6rem; letter-spacing: 1px;">SYSTEM ADMINISTRATOR</span>
    </div>
    
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100 shadow-none" style="background: #000; border-radius: 0;">
                <div class="card-body text-white">
                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-50">Total Revenue</div>
                    <div class="h4 mb-0 font-weight-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100 shadow-none border" style="border: 1px solid #eee !important; border-radius: 0;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Bookings</div>
                    <div class="h4 mb-0 font-weight-bold">{{ $totalBookings }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100 shadow-none border" style="border: 1px solid #eee !important; border-radius: 0;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pending Request</div>
                    <div class="h4 mb-0 font-weight-bold">{{ $pendingBookings }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100 shadow-none border" style="border: 1px solid #eee !important; border-radius: 0;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Customers</div>
                    <div class="h4 mb-0 font-weight-bold">{{ $totalCustomers }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card border-0 mb-4" style="border: 1px solid #eee !important; border-radius: 0;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark text-uppercase small">Revenue Trends {{ date('Y') }}</h6>
                </div>
                <div class="card-body">
                    <div style="height: 320px;"><canvas id="revenueChart"></canvas></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card border-0 mb-4" style="border: 1px solid #eee !important; border-radius: 0;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 font-weight-bold text-dark text-uppercase small">Package Popularity</h6>
                </div>
                <div class="card-body">
                    <div style="height: 320px;"><canvas id="packageChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 📊 Line Chart - Revenue
    new Chart(document.getElementById("revenueChart"), {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: "Revenue",
                backgroundColor: "rgba(0, 0, 0, 0.02)",
                borderColor: "#000",
                pointBackgroundColor: "#000",
                borderWidth: 2,
                data: @json($chartData),
            }],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { callback: (v) => 'Rp ' + v.toLocaleString() } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // 🥧 Pie Chart - Popularity
    new Chart(document.getElementById("packageChart"), {
        type: 'doughnut',
        data: {
            labels: @json($pieLabels),
            datasets: [{
                data: @json($pieData),
                backgroundColor: ["#000000", "#333333", "#666666", "#999999", "#CCCCCC"],
                borderWidth: 0
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, usePointStyle: true } } }
        }
    });
</script>
@endsection
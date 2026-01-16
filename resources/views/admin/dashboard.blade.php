@extends('admin.layouts.master')
@section('title', 'Dashboard — Fokuskesini')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-dark font-weight-bold text-uppercase" style="letter-spacing: 2px;">Admin Dashboard</h1>
        <span class="badge badge-dark p-2 px-3" style="font-size: 0.6rem; letter-spacing: 1px;">SUPER ADMIN</span>
    </div>
    
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100 py-2" style="border-left: 4px solid #000 !important; background: #fdfdfd;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Packages</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $totalPackages }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-box-open fa-2x text-muted opacity-25"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 h-100 py-2" style="border-left: 4px solid #000 !important; background: #000;">
                <div class="card-body text-white">
                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-50">Total Revenue</div>
                    <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4" style="border: 1px solid #eeeeee !important;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark text-uppercase small">Laporan Pemasukan {{ date('Y') }}</h6>
                </div>
                <div class="card-body">
                    <div style="height: 320px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('sb-admin/vendor/chart.js/Chart.min.js') }}"></script>
<script>
    // Konfigurasi Grafik Pemasukan Monokrom
    var ctx = document.getElementById("revenueChart");
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: "Pemasukan",
                lineTension: 0.3,
                backgroundColor: "rgba(0, 0, 0, 0.05)",
                borderColor: "#000",
                borderWidth: 3,
                pointBackgroundColor: "#000",
                pointBorderColor: "#fff",
                pointHoverRadius: 5,
                pointRadius: 3,
                data: @json($chartData), // Ngambil data soko Controller
            }],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }]
            },
            legend: { display: false },
            tooltips: {
                backgroundColor: "#000",
                bodyFontColor: "#fff",
                displayColors: false
            }
        }
    });
</script>
@endsection
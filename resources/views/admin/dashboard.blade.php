@extends('admin.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="page-title mb-1">Dashboard Admin Keraton Kasepuhan</h3>
        <p class="text-muted mb-0">Ringkasan data sistem terbaru</p>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent p-0 m-0">
            <li class="breadcrumb-item active" aria-current="page">Overview</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 col-sm-6 grid-margin stretch-card">
        <div class="card shadow-sm border-0 rounded-3 hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted">Total Tiket Terjual</h6>
                    <div class="icon icon-box-primary icon-box-sm">
                        <span class="mdi mdi-ticket icon-item"></span>
                    </div>
                </div>
                <h2 class="fw-bold mb-1">{{ $totalTickets }}</h2>
                <small class="text-muted">Jumlah transaksi tiket</small>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 col-sm-6 grid-margin stretch-card">
        <div class="card shadow-sm border-0 rounded-3 hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted">Pendapatan Merchandise</h6>
                    <div class="icon icon-box-success icon-box-sm">
                        <span class="mdi mdi-cash-multiple icon-item"></span>
                    </div>
                </div>
                <h2 class="fw-bold mb-1">
                    Rp{{ number_format($merchRevenue, 0, ',', '.') }}
                </h2>
                <small class="text-muted">Total penjualan merchandise</small>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 col-sm-6 grid-margin stretch-card">
        <div class="card shadow-sm border-0 rounded-3 hover-scale">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted">Total Pengguna</h6>
                    <div class="icon icon-box-info icon-box-sm">
                        <span class="mdi mdi-account-multiple icon-item"></span>
                    </div>
                </div>
                <h2 class="fw-bold mb-1">{{ $totalUsers }}</h2>
                <small class="text-muted">Pengguna terdaftar</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Grafik Kunjungan Bulanan</h5>
                    <span class="badge badge-outline-primary">2026</span>
                </div>
                <canvas id="visitorChart" height="110"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-primary text-white shadow-lg rounded-4 hover-scale">
            <div class="card-body">
                <h5 class="mb-2">
                    <i class="mdi mdi-castle me-1"></i> Kelola Museum
                </h5>
                <p class="small mb-3">Manajemen data museum</p>
                <a href="{{ route('admin.museum.index') }}" class="btn btn-light btn-sm fw-semibold">
                    Kelola <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-success text-white shadow-lg rounded-4 hover-scale">
            <div class="card-body">
                <h5 class="mb-2">
                    <i class="mdi mdi-ticket me-1"></i> Kelola Tiket
                </h5>
                <p class="small mb-3">Kategori & harga tiket</p>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-light btn-sm fw-semibold">
                    Kelola <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-info text-white shadow-lg rounded-4 hover-scale">
            <div class="card-body">
                <h5 class="mb-2">
                    <i class="mdi mdi-shopping me-1"></i> Kelola Shop
                </h5>
                <p class="small mb-3">Produk merchandise</p>
                <a href="{{ route('admin.shop.index') }}" class="btn btn-light btn-sm fw-semibold">
                    Kelola <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-warning text-white shadow-lg rounded-4 hover-scale">
            <div class="card-body">
                <h5 class="mb-2">
                    <i class="mdi mdi-file-document me-1"></i> Laporan
                </h5>
                <p class="small mb-3">Rekap penjualan</p>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-light btn-sm fw-semibold">
                    Lihat <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('visitorChart').getContext('1d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Jumlah Kunjungan',
            data: @json($chartData),
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        }
    }
});
</script>

<style>
.hover-scale {
    transition: 0.25s ease-in-out;
}
.hover-scale:hover {
    transform: translateY(-4px);
}
</style>

@endsection

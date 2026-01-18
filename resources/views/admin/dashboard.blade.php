@extends('admin.layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="page-header">
    <h3 class="page-title">Dashboard Admin Keraton Kasepuhan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Overview</li>
        </ol>
    </nav>
</div>

{{-- Statistics Cards --}}
<div class="row">
    <div class="col-xl-4 col-md-6 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5>Total Tiket Terjual</h5>
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $totalTickets }}</h3>
                        </div>
                        <h6 class="text-muted font-weight-normal">Transaksi tiket</h6>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-primary">
                            <span class="mdi mdi-ticket icon-item"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5>Pendapatan Merchandise</h5>
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">Rp{{ number_format($merchRevenue, 0, ',', '.') }}</h3>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total penjualan</h6>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-cash-multiple icon-item"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h5>Total Pengguna</h5>
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $totalUsers }}</h3>
                        </div>
                        <h6 class="text-muted font-weight-normal">Pengguna terdaftar</h6>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-info">
                            <span class="mdi mdi-account-multiple icon-item"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart Kunjungan --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Grafik Kunjungan Bulanan</h4>
               <canvas id="visitorChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Quick Access Menu --}}
<div class="row">
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <h4 class="card-title mb-3">
                    <i class="mdi mdi-castle"></i> Kelola Museum
                </h4>
                <p class="card-text mb-3">Tambah, edit, atau hapus data museum</p>
                <a href="{{ route('admin.museum.index') }}" class="btn btn-light btn-sm">
                    Kelola <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                <h4 class="card-title mb-3">
                    <i class="mdi mdi-ticket"></i> Kelola Tiket
                </h4>
                <p class="card-text mb-3">Atur kategori dan harga tiket</p>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-light btn-sm">
                    Kelola <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-info text-white">
            <div class="card-body">
                <h4 class="card-title mb-3">
                    <i class="mdi mdi-shopping"></i> Kelola Shop
                </h4>
                <p class="card-text mb-3">Kelola produk merchandise</p>
                <a href="{{ route('admin.shop.index') }}" class="btn btn-light btn-sm">
                    Kelola <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 grid-margin stretch-card">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                <h4 class="card-title mb-3">
                    <i class="mdi mdi-file-document"></i> Laporan
                </h4>
                <p class="card-text mb-3">Lihat laporan penjualan</p>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-light btn-sm">
                    Lihat <i class="mdi mdi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Chart Script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('visitorChart').getContext('2d');
    const visitorChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: @json($chartData),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endsection
@extends('admin.layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-6 col-xl-3 grid-margin">
        <div class="card shadow-sm border-0 bg-gradient-primary text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-sm">Total Tiket Terjual</p>
                    <h3 class="mb-0 font-weight-bold">{{ $totalTickets }}</h3>
                </div>
                <i class="mdi mdi-ticket-confirmation mdi-36px opacity-75"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3 grid-margin">
        <div class="card shadow-sm border-0 bg-gradient-success text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-sm">Pendapatan Merchandise</p>
                    <h3 class="mb-0 font-weight-bold">
                        Rp {{ number_format($merchRevenue) }}
                    </h3>
                </div>
                <i class="mdi mdi-cash-multiple mdi-36px opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">
                        Grafik Kunjungan Bulanan
                    </h4>
                    <span class="text-muted text-sm">
                        Tahun {{ now()->year }}
                    </span>
                </div>

                <canvas id="grafikKunjungan" height="90"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikKunjungan');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Jumlah Wisatawan',
            data: {!! json_encode($chartData) !!},
            borderColor: '#d4af37',
            backgroundColor: 'rgba(212, 175, 55, 0.15)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#d4af37'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                labels: {
                    color: '#6c757d'
                }
            }
        },
        scales: {
            x: {
                ticks: { color: '#6c757d' },
                grid: { display: false }
            },
            y: {
                ticks: { color: '#6c757d' },
                grid: { color: 'rgba(0,0,0,0.05)' }
            }
        }
    }
});
</script>

@endsection
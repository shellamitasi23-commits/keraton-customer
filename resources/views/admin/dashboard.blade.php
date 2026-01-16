@extends('admin.layouts.admin')

@section('title', 'Dashboard Penjualan')

@section('content')
<div class="row">
    <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted font-weight-normal">Total Penjualan Tiket</h6>
                <h3 class="mb-0">Rp {{ number_format($ticketSales->sum('total_price'), 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted font-weight-normal">Total Penjualan Shop</h6>
                <h3 class="mb-0">Rp {{ number_format($shopSales->sum('total_amount'), 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Laporan Penjualan Tiket Terbaru</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th> Customer </th>
                                <th> Tiket </th>
                                <th> Harga </th>
                                <th> Tanggal </th>
                                <th> Status </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ticketSales as $sale)
                            <tr>
                                <td>{{ $sale->user->name }}</td>
                                <td>{{ $sale->ticketCategory->name }}</td>
                                <td>Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                <td>{{ $sale->created_at->format('d M Y') }}</td>
                                <td><div class="badge badge-outline-success">Selesai</div></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
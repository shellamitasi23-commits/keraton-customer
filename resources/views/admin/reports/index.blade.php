@extends('admin.layouts.admin')

@section('content')
<div class="content-wrapper">
<div class="page-header d-flex justify-content-between align-items-center">
    <h3 class="page-title text-gold"> Laporan Penjualan Keraton </h3>
    <a href="{{ route('admin.reports.download') }}" class="btn btn-danger">
        <i class="mdi mdi-file-pdf"></i> Download PDF
    </a>
</div>

    <div class="row mb-4">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h4 class="card-title text-warning">Laporan Transaksi Tiket</h4>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Nama Pengunjung </th>
                                    <th> Kategori Tiket </th>
                                    <th> Tanggal </th>
                                    <th> Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ticketTransactions as $index => $trx)
                                <tr>
                                    <td> {{ $index + 1 }} </td>
                                    <td> {{ $trx->user->name ?? 'Guest' }} </td>
                                    <td> {{ $trx->ticketCategory->name ?? '-' }} </td>
                                    <td> {{ $trx->created_at->format('d/m/Y') }} </td>
                                    <td> <label class="badge badge-success">{{ $trx->status }}</label> </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h4 class="card-title text-warning">Laporan Penjualan Merchandise</h4>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Pembeli </th>
                                    <th> Total Bayar </th>
                                    <th> Tanggal </th>
                                    <th> Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($merchandiseOrders as $index => $order)
                                <tr>
                                    <td> {{ $index + 1 }} </td>
                                    <td> {{ $order->user->name ?? 'Customer' }} </td>
                                    <td> Rp {{ number_format($order->total_price, 0, ',', '.') }} </td>
                                    <td> {{ $order->created_at->format('d/m/Y') }} </td>
                                    <td> <label class="badge badge-info">{{ $order->status }}</label> </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
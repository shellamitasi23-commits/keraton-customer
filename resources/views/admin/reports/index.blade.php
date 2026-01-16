  @extends('admin.layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Laporan Penjualan Tiket</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Total Bayar</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ticketSales as $sale)
                            <tr>
                                <td>{{ $sale->user->name }}</td>
                                <td>{{ $sale->ticketCategory->name }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td class="text-success">Rp {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Laporan Penjualan Merchandise</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Total Belanja</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shopSales as $order)
                            <tr>
                                <td>{{ $order->user->name }}</td>
                                <td class="text-info">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td><label class="badge badge-success">Selesai</label></td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
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
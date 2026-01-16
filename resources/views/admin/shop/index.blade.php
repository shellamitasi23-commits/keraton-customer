@extends('admin.layouts.admin')

@section('title', 'Manajemen Merchandise')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Kelola Merchandise Keraton </h3>
</div>

<div class="row">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $products->where('stock', '<', 10)->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-danger">
                            <span class="mdi mdi-alert-circle icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Produk Stok Menipis</h6>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">Rp{{ number_format($shopSales->sum('total_amount'), 0, ',', '.') }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-cash-multiple icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Total Penjualan Merchandise</h6>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Produk Merchandise</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-contextual">
                        <thead>
                            <tr>
                                <th> Foto </th>
                                <th> Nama Barang </th>
                                <th> Harga </th>
                                <th> Stok </th>
                                <th> Status </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="image" style="width: 50px; height: 50px; border-radius: 5px;" />
                                </td>
                                <td> {{ $product->name }} </td>
                                <td> Rp{{ number_format($product->price, 0, ',', '.') }} </td>
                                <td> {{ $product->stock }} unit </td>
                                <td>
                                    @if($product->stock > 0)
                                        <div class="badge badge-success">Tersedia</div>
                                    @else
                                        <div class="badge badge-danger">Habis</div>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-outline-warning btn-sm">Edit Stok</button>
                                </td>
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
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Riwayat Transaksi Shop</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th> Client </th>
                                <th> Order ID </th>
                                <th> Total Belanja </th>
                                <th> Tanggal </th>
                                <th> Status </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shopSales as $order)
                            <tr>
                                <td> {{ $order->user->name }} </td>
                                <td> #ORD-{{ $order->id }} </td>
                                <td> Rp{{ number_format($order->total_amount, 0, ',', '.') }} </td>
                                <td> {{ $order->created_at->format('d M Y') }} </td>
                                <td> <label class="badge badge-success">Paid</label> </td>
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
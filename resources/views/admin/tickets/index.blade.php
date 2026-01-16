@extends('admin.layouts.admin')

@section('title', 'Manajemen Tiket')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Kelola Tiket Keraton </h3>
</div>

<div class="row">
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5>Total Tiket Terjual</h5>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0">{{ $ticketSales->sum('quantity') }}</h2>
                        </div>
                        <h6 class="text-muted font-weight-normal"> Lembar tiket terjual</h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-ticket text-primary ml-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5>Pendapatan Tiket</h5>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0">Rp{{ number_format($ticketSales->sum('total_price'), 0, ',', '.') }}</h2>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total omzet dari tiket</h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-cash-multiple text-success ml-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pengaturan Kategori Tiket</h4>
                <p class="card-description"> Perubahan di sini akan langsung tampil di halaman customer </p>
                <div class="table-responsive">
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th> Kategori </th>
                                <th> Deskripsi </th>
                                <th> Harga Saat Ini </th>
                                <th> Update Harga </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td> {{ $category->name }} </td>
                                <td> {{ Str::limit($category->description, 30) }} </td>
                                <td> Rp{{ number_format($category->price, 0, ',', '.') }} </td>
                                <form action="{{ route('admin.tickets.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <td>
                                        <input type="number" name="price" class="form-control text-white bg-dark border-secondary" value="{{ $category->price }}" style="width: 150px;">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-icon-text">
                                            <i class="mdi mdi-file-check btn-icon-prepend"></i> Simpan </button>
                                    </td>
                                </form>
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
                <h4 class="card-title">Riwayat Transaksi Tiket</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th> Customer </th>
                                <th> Order No </th>
                                <th> Kategori </th>
                                <th> Qty </th>
                                <th> Total </th>
                                <th> Tanggal </th>
                                <th> Status </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ticketSales as $sale)
                            <tr>
                                <td> {{ $sale->user->name }} </td>
                                <td> #TK-{{ $sale->id }} </td>
                                <td> {{ $sale->ticketCategory->name }} </td>
                                <td> {{ $sale->quantity }} </td>
                                <td> Rp{{ number_format($sale->total_price, 0, ',', '.') }} </td>
                                <td> {{ $sale->created_at->format('d M Y H:i') }} </td>
                                <td>
                                    <div class="badge badge-outline-success">Lunas</div>
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
@endsection
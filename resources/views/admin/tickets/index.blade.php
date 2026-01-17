@extends('admin.layouts.admin')

@section('title', 'Manajemen Tiket')

@section('content')
<div class="page-header">
    <h3 class="page-title">Kelola Tiket Keraton</h3>
</div>

{{-- Statistics Cards --}}
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
                        <h6 class="text-muted font-weight-normal">Lembar tiket terjual</h6>
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

    <div class="col-sm-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5>Kategori Tiket</h5>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0">{{ $categories->count() }}</h2>
                        </div>
                        <h6 class="text-muted font-weight-normal">Jenis tiket tersedia</h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-tag-multiple text-info ml-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Kategori Tiket Table --}}
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-0">Pengaturan Kategori Tiket</h4>
                        <p class="card-description mb-0">Perubahan akan langsung tampil di halaman customer</p>
                    </div>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTicketModal">
                        <i class="mdi mdi-plus"></i> Tambah Kategori
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="font-weight-bold">{{ $category->name }}</td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td class="text-primary font-weight-bold">Rp{{ number_format($category->price, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning" 
                                            data-toggle="modal" 
                                            data-target="#editModal{{ $category->id }}"
                                            title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.tickets.destroy', $category->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Edit Modal --}}
                            <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Kategori Tiket</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.tickets.update', $category->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name">Nama Kategori</label>
                                                    <input type="text" 
                                                           id="name"
                                                           name="name" 
                                                           class="form-control @error('name') is-invalid @enderror" 
                                                           value="{{ old('name', $category->name) }}" 
                                                           required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">Deskripsi</label>
                                                    <textarea id="description"
                                                              name="description" 
                                                              class="form-control @error('description') is-invalid @enderror" 
                                                              rows="3" 
                                                              required>{{ old('description', $category->description) }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="price">Harga (Rp)</label>
                                                    <input type="number" 
                                                           id="price"
                                                           name="price" 
                                                           class="form-control @error('price') is-invalid @enderror" 
                                                           value="{{ old('price', $category->price) }}" 
                                                           min="0"
                                                           step="1000"
                                                           required>
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="mdi mdi-content-save"></i> Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="mdi mdi-ticket-outline" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p class="mt-2">Belum ada kategori tiket</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Ticket Modal --}}
<div class="modal fade" id="addTicketModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori Tiket Baru</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.tickets.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_name">Nama Kategori</label>
                        <input type="text" 
                               id="new_name"
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Contoh: Tiket Dewasa Weekday"
                               value="{{ old('name') }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_description">Deskripsi</label>
                        <textarea id="new_description"
                                  name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" 
                                  placeholder="Jelaskan tentang tiket ini..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_price">Harga (Rp)</label>
                        <input type="number" 
                               id="new_price"
                               name="price" 
                               class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price') }}" 
                               min="0"
                               step="1000"
                               placeholder="50000"
                               required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Tambah Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Transaction History --}}
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Riwayat Transaksi Tiket</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Order No</th>
                                <th>Kategori</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ticketSales as $sale)
                            <tr>
                                <td>{{ $sale->user->name }}</td>
                                <td class="font-weight-bold">#TK-{{ $sale->id }}</td>
                                <td>{{ $sale->ticketCategory->name }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td class="text-success font-weight-bold">Rp{{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                <td>{{ $sale->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge badge-success">Lunas</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="mdi mdi-clipboard-text-outline" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p class="mt-2">Belum ada transaksi tiket</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
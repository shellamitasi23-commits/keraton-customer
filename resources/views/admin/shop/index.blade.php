@extends('admin.layouts.admin')

@section('title', 'Manajemen Merchandise')

@section('content')
<div class="page-header">
    <h3 class="page-title">Kelola Merchandise Keraton</h3>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-circle mr-2"></i>{{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="mdi mdi-alert-circle mr-2"></i>{{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Terjadi kesalahan:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $products->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-primary">
                            <span class="mdi mdi-package-variant icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Total Produk</h6>
            </div>
        </div>
    </div>

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
                <h6 class="text-muted font-weight-normal">Stok Menipis</h6>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{ $shopSales->count() }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-info">
                            <span class="mdi mdi-cart icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Total Transaksi</h6>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">Rp{{ number_format($shopSales->sum('total_price'), 0, ',', '.') }}</h3>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-cash-multiple icon-item"></span>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted font-weight-normal">Total Penjualan</h6>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title mb-0">Daftar Produk Merchandise</h4>
                        <p class="card-description mb-0">Kelola produk yang dijual di toko</p>
                    </div>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProductModal">
                        <i class="mdi mdi-plus"></i> Tambah Produk
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">Foto</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="product-thumbnail"
                                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'no-image-placeholder\'><i class=\'mdi mdi-image-off\'></i></div>';">
                                    @else
                                        <div class="no-image-placeholder">
                                            <i class="mdi mdi-image-off"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="font-weight-bold">{{ $product->name }}</td>
                                <td class="text-primary font-weight-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="{{ $product->stock < 10 ? 'text-danger font-weight-bold' : '' }}">
                                        {{ $product->stock }} unit
                                    </span>
                                </td>
                                <td>
                                    @if($product->stock > 10)
                                        <span class="badge badge-success">Tersedia</span>
                                    @elseif($product->stock > 0)
                                        <span class="badge badge-warning">Stok Sedikit</span>
                                    @else
                                        <span class="badge badge-danger">Habis</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning" 
                                            data-toggle="modal" 
                                            data-target="#editModal{{ $product->id }}"
                                            title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.shop.destroy', $product->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus produk \'{{ $product->name }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="mdi mdi-pencil mr-2"></i>Edit Produk
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.shop.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nama Produk <span class="text-danger">*</span></label>
                                                            <input type="text" 
                                                                   name="name" 
                                                                   class="form-control @error('name') is-invalid @enderror" 
                                                                   value="{{ old('name', $product->name) }}" 
                                                                   required>
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Harga (Rp) <span class="text-danger">*</span></label>
                                                            <input type="number" 
                                                                   name="price" 
                                                                   class="form-control @error('price') is-invalid @enderror" 
                                                                   value="{{ old('price', $product->price) }}" 
                                                                   min="0"
                                                                   step="1000"
                                                                   required>
                                                            @error('price')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Deskripsi <span class="text-danger">*</span></label>
                                                    <textarea name="description" 
                                                              class="form-control @error('description') is-invalid @enderror" 
                                                              rows="3" 
                                                              required>{{ old('description', $product->description) }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Stok <span class="text-danger">*</span></label>
                                                            <input type="number" 
                                                                   name="stock" 
                                                                   class="form-control @error('stock') is-invalid @enderror" 
                                                                   value="{{ old('stock', $product->stock) }}" 
                                                                   min="0"
                                                                   required>
                                                            @error('stock')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Foto Produk</label>
                                                            <input type="file" 
                                                                   name="image" 
                                                                   class="form-control-file @error('image') is-invalid @enderror" 
                                                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                                            @error('image')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($product->image)
                                                    <div class="form-group">
                                                        <label>Foto Saat Ini:</label><br>
                                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                                             alt="{{ $product->name }}"
                                                             style="max-width: 200px; border-radius: 8px; border: 2px solid #ddd;"
                                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                        <div style="display:none;" class="alert alert-warning mt-2">
                                                            <i class="mdi mdi-alert"></i> Gambar tidak dapat dimuat
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="mdi mdi-close"></i> Batal
                                                </button>
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
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="mdi mdi-package-variant-closed" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p class="mt-2">Belum ada produk merchandise</p>
                                    <button class="btn btn-sm btn-primary mt-2" data-toggle="modal" data-target="#addProductModal">
                                        <i class="mdi mdi-plus"></i> Tambah Produk Pertama
                                    </button>
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

<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-plus-circle mr-2"></i>Tambah Produk Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.shop.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Contoh: Kaos Keraton"
                                       value="{{ old('name') }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="price" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price') }}" 
                                       min="0"
                                       step="1000"
                                       placeholder="75000"
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="description" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" 
                                  placeholder="Jelaskan tentang produk ini..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stok Awal <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="stock" 
                                       class="form-control @error('stock') is-invalid @enderror" 
                                       value="{{ old('stock', 0) }}" 
                                       min="0"
                                       required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Foto Produk <span class="text-danger">*</span></label>
                                <input type="file" 
                                       name="image" 
                                       class="form-control-file @error('image') is-invalid @enderror" 
                                       accept="image/jpeg,image/png,image/jpg,image/gif"
                                       required
                                       id="imageInput">
                                <small class="form-text text-muted">Format: JPG, PNG, JPEG, GIF (Max: 2MB)</small>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="previewImg" src="" style="max-width: 200px; border-radius: 8px; border: 2px solid #ddd;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="mdi mdi-close"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="mdi mdi-plus"></i> Tambah Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Riwayat Transaksi Shop</h4>
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Order No</th>
                                <th>Item</th>
                                <th>Total Belanja</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shopSales as $order)
                            <tr>
                                <td>{{ $order->user->name ?? 'Unknown' }}</td>
                                <td class="font-weight-bold">{{ $order->order_number }}</td>
                                <td>{{ $order->items->count() }} item</td>
                                <td class="text-success font-weight-bold">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge badge-success">Lunas</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="mdi mdi-cart-outline" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p class="mt-2">Belum ada transaksi shop</p>
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

<style>
.product-thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
}

.no-image-placeholder {
    width: 60px;
    height: 60px;
    background: #e9ecef;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 24px;
}

.modal-header.bg-primary,
.modal-header.bg-success {
    border-radius: 0;
}
</style>

<script>
// Image preview for add product
document.getElementById('imageInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

// Auto close alerts after 5 seconds
setTimeout(function() {
    $('.alert').fadeOut('slow');
}, 5000);

// Re-open modal if validation errors exist
@if($errors->any())
    @if(old('_method') === 'PUT')
        // This is an edit form submission
        @foreach($products as $product)
            @if(old('name') == $product->name || old('price') == $product->price)
                $('#editModal{{ $product->id }}').modal('show');
            @endif
        @endforeach
    @else
        // This is an add form submission
        $('#addProductModal').modal('show');
    @endif
@endif
</script>
@endsection
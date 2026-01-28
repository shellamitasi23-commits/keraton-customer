@extends('admin.layouts.admin')

@section('title', 'Manajemen Tiket')

@section('content')

<div class="page-header">
    <h3 class="page-title">Kelola Tiket Keraton</h3>
</div>

{{-- ================= ALERT MESSAGES ================= --}}
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

{{-- ================= STATISTIK ================= --}}
<div class="row">
    <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6>Total Tiket Terjual</h6>
                <h3>{{ $ticketSales->sum('total_ticket') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6>Pendapatan</h6>
                <h3>Rp{{ number_format($ticketSales->sum('total_price'),0,',','.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6>Kategori Tiket</h6>
                <h3>{{ $categories->count() }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- ================= KATEGORI TIKET ================= --}}
<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
            <div>
                <h4>Pengaturan Kategori Tiket</h4>
                <small class="text-muted">Data ini tampil di halaman customer</small>
            </div>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                <i class="mdi mdi-plus"></i> Tambah Kategori
            </button>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/'.$category->image) }}"
                                     class="product-thumbnail"
                                     alt="{{ $category->name }}"
                                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'no-image-placeholder\'><i class=\'mdi mdi-image-off\'></i></div>';">
                            @else
                                <div class="no-image-placeholder">
                                    <i class="mdi mdi-image-off"></i>
                                </div>
                            @endif
                        </td>

                        <td>{{ $category->name }}</td>

                        <td>{{ Str::limit($category->description, 60) }}</td>

                        <td class="text-warning">
                            Rp{{ number_format($category->price,0,',','.') }}
                        </td>

                        <td>
                            <button class="btn btn-sm btn-outline-warning"
                                    data-toggle="modal"
                                    data-target="#editModal{{ $category->id }}"
                                    title="Edit">
                                <i class="mdi mdi-pencil"></i>
                            </button>

                            <form action="{{ route('admin.tickets.destroy',$category->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus kategori \'{{ $category->name }}\'?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- ================= EDIT MODAL ================= --}}
                    <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('admin.tickets.update',$category->id) }}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">
                                            <i class="mdi mdi-pencil mr-2"></i>Edit Kategori Tiket
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Kategori <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           name="name"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           value="{{ old('name', $category->name) }}" 
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
                                                           value="{{ old('price', $category->price) }}"
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
                                                      required>{{ old('description', $category->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Foto Tiket</label>
                                            <input type="file" 
                                                   name="image" 
                                                   class="form-control-file @error('image') is-invalid @enderror"
                                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                            @error('image')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @if($category->image)
                                            <div class="form-group">
                                                <label>Foto Saat Ini:</label><br>
                                                <img src="{{ asset('storage/'.$category->image) }}"
                                                     alt="{{ $category->name }}"
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
                    {{-- =============== END EDIT MODAL ================= --}}

                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="mdi mdi-ticket-outline" style="font-size: 48px; opacity: 0.3;"></i>
                            <p class="mt-2">Belum ada kategori tiket</p>
                            <button class="btn btn-sm btn-primary mt-2" data-toggle="modal" data-target="#addModal">
                                <i class="mdi mdi-plus"></i> Tambah Kategori Pertama
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ================= TAMBAH MODAL ================= --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.tickets.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="addCategoryForm">
                @csrf

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="mdi mdi-plus-circle mr-2"></i>Tambah Kategori Tiket Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Contoh: Tiket Dewasa"
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
                                       placeholder="50000"
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
                                  placeholder="Jelaskan tentang kategori tiket ini..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Foto Tiket <span class="text-danger">*</span></label>
                        <input type="file" 
                               name="image" 
                               class="form-control-file @error('image') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               required
                               id="imageInputAdd">
                        <small class="form-text text-muted">Format: JPG, PNG, JPEG, GIF (Max: 2MB)</small>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="imagePreviewAdd" class="mt-2" style="display: none;">
                        <label>Preview:</label><br>
                        <img id="previewImgAdd" src="" style="max-width: 200px; border-radius: 8px; border: 2px solid #ddd;">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="mdi mdi-close"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="mdi mdi-plus"></i> Tambah Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= STYLING ================= --}}
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

{{-- ================= JAVASCRIPT ================= --}}
<script>
// Image preview for add category
document.getElementById('imageInputAdd')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImgAdd').src = e.target.result;
            document.getElementById('imagePreviewAdd').style.display = 'block';
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
        @foreach($categories as $category)
            @if(old('name') == $category->name || old('price') == $category->price)
                $('#editModal{{ $category->id }}').modal('show');
            @endif
        @endforeach
    @else
        // This is an add form submission
        $('#addModal').modal('show');
    @endif
@endif
</script>

@endsection
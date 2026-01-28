@extends('admin.layouts.admin')

@section('title', 'Kelola Museum')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-circle mr-2"></i><strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-alert-circle mr-2"></i><strong>Error!</strong> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="card-title mb-1 text-white">
                            <i class="mdi mdi-plus-circle text-white mr-2"></i>Tambah Koleksi Museum
                        </h4>
                        <p class="card-description mb-0" style="color: #6c757d;">Lengkapi form di bawah untuk menambah benda koleksi baru</p>
                    </div>
                </div>

                <form action="{{ route('admin.museum.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama" class="font-weight-bold text-white">
                                    Nama Benda Museum <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       id="nama"
                                       name="nama" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       placeholder="Contoh: Keris Pusaka"
                                       value="{{ old('nama') }}" 
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="deskripsi" class="font-weight-bold text-white">
                                    Deskripsi <span class="text-danger">*</span>
                                </label>
                                <textarea id="deskripsi"
                                          name="deskripsi" 
                                          class="form-control @error('deskripsi') is-invalid @enderror" 
                                          rows="3" 
                                          placeholder="Jelaskan sejarah dan detail benda koleksi..."
                                          required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="foto" class="font-weight-bold text-white">
                                    Foto Benda Koleksi
                                </label>
                                <div class="custom-file">
                                    <input type="file" 
                                           id="foto"
                                           name="foto" 
                                           class="custom-file-input @error('foto') is-invalid @enderror" 
                                           accept="image/jpeg,image/png,image/jpg,image/gif">
                                    <label class="custom-file-label" for="foto" style="background-color: #2c3e50; border-color: #34495e; color: #ecf0f1;">Pilih file...</label>
                                </div>
                                <small class="form-text" style="color: #6c757d;">Format: JPG, PNG, JPEG, GIF (Max: 2MB)</small>
                                @error('foto')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="previewImg" src="" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <hr class="my-3">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-outline-secondary mr-2">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="mdi mdi-content-save mr-2"></i> Simpan Koleksi Baru
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="card-title mb-1 text-white">
                            <i class="mdi mdi-format-list-bulleted text-white mr-2"></i>Daftar Benda Koleksi Museum
                        </h4>
                        <p class="card-description mb-0" style="color: #6c757d;">Kelola dan pantau semua koleksi museum</p>
                    </div>
                    <div>
                        <span class="badge badge-primary badge-pill px-3 py-2" style="font-size: 14px;">
                            <i class="mdi mdi-cube-outline mr-1"></i>{{ $museums->count() }} Benda
                        </span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th style="width: 60px;" class="text-center text-white">#</th>
                                <th style="width: 120px;" class="text-white">Foto</th>
                                <th class="text-white">Nama Benda Koleksi</th>
                                <th style="width: 40%;" class="text-white">Deskripsi</th>
                                <th style="width: 180px;" class="text-center text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($museums as $index => $museum)
                            <tr>
                                <td class="text-center font-weight-bold text-muted">{{ $index + 1 }}</td>
                                <td>
                                    @if($museum->foto)
                                        <img src="{{ asset('storage/'.$museum->foto) }}" 
                                             alt="{{ $museum->nama }}"
                                             class="museum-thumbnail shadow-sm"
                                             style="width: 90px; height: 90px; object-fit: cover; border-radius: 12px; border: 2px solid #fdfdfd;"
                                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'no-image-placeholder\' style=\'width:90px;height:90px;background:#f8f9fa;border-radius:12px;display:flex;align-items:center;justify-content:center;border:2px dashed #dee2e6;\'><i class=\'mdi mdi-image-off text-muted\' style=\'font-size:32px;\'></i></div>';">
                                    @else
                                        <div class="no-image-placeholder" style="width: 90px; height: 90px; background: #fdfdfd; border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 2px dashed #fdfdfd;">
                                            <i class="mdi mdi-image-off text-muted" style="font-size: 32px;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-weight-bold text-white mb-1">{{ $museum->nama }}</div>
                                    <small style="color: #fdfdfd;">
                                        <i class="mdi mdi-clock-outline mr-1"></i>
                                        {{ $museum->created_at->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <p class="mb-0" style="line-height: 2; color: #fdfdfd;">
                                        {{ Str::limit($museum->deskripsi, 120) }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info" 
                                                data-toggle="modal" 
                                                data-target="#viewModal{{ $museum->id }}"
                                                title="Lihat Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                        
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-warning" 
                                                data-toggle="modal" 
                                                data-target="#editModal{{ $museum->id }}"
                                                title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        
                                        <form action="{{ route('admin.museum.destroy', $museum->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus benda koleksi \'{{ $museum->nama }}\'?')">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Hapus">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ $museum->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.museum.update', $museum->id) }}" 
                                              method="POST" 
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="modal-header bg-dark text-white">
                                                <h5 class="modal-title">
                                                    <i class="mdi mdi-pencil mr-2"></i>Edit Benda Koleksi
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-white">Nama Benda Koleksi <span class="text-danger">*</span></label>
                                                            <input type="text" 
                                                                   name="nama" 
                                                                   class="form-control" 
                                                                   value="{{ $museum->nama }}" 
                                                                   required>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold text-white">Foto Benda Koleksi</label>
                                                            <div class="custom-file">
                                                                <input type="file" 
                                                                       name="foto" 
                                                                       class="custom-file-input" 
                                                                       accept="image/*"
                                                                       id="editFoto{{ $museum->id }}">
                                                                <label class="custom-file-label" for="editFoto{{ $museum->id }}" style="background-color: #2c3e50; border-color: #34495e; color: #ecf0f1;">Pilih file baru...</label>
                                                            </div>
                                                            <small class="form-text" style="color: #6c757d;">
                                                                Kosongkan jika tidak ingin mengubah foto
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="font-weight-bold text-white">Deskripsi <span class="text-danger">*</span></label>
                                                    <textarea name="deskripsi" 
                                                              class="form-control" 
                                                              rows="4" 
                                                              required>{{ $museum->deskripsi }}</textarea>
                                                </div>

                                                @if($museum->foto)
                                                    <div class="form-group">
                                                        <label class="font-weight-bold text-white">Foto Saat Ini:</label>
                                                        <div class="border rounded p-2 bg-dark">
                                                            <img src="{{ asset('storage/'.$museum->foto) }}" 
                                                                 class="img-fluid" 
                                                                 style="max-height: 200px; "
                                                                 alt="Current">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="mdi mdi-close"></i> Batal
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="mdi mdi-content-save mr-1"></i> Update Data
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="viewModal{{ $museum->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-muted text-white">
                                            <h5 class="modal-title">
                                                <i class="mdi mdi-information mr-2"></i>Detail Benda Koleksi
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if($museum->foto)
                                                <div class="text-center mb-4">
                                                    <img src="{{ asset('storage/'.$museum->foto) }}" 
                                                         class="img-fluid rounded shadow" 
                                                         style="max-height: 400px;"
                                                         alt="{{ $museum->nama }}">
                                                </div>
                                            @endif
                                            
                                            <div class="bg-light p-3 rounded mb-3">
                                                <h5 class="font-weight-bold text-dark mb-0">{{ $museum->nama }}</h5>
                                            </div>

                                            <div class="mb-3">
                                                <label class="font-weight-bold text-white mb-2">
                                                    <i class="mdi mdi-text-box-outline mr-1"></i>Deskripsi:
                                                </label>
                                                <p class="text-white" style="line-height: 1.8; text-align: justify;">
                                                    {{ $museum->deskripsi }}
                                                </p>
                                            </div>

                                            <div class="border-top pt-3">
                                                <small style="color: #fdfdfd;">
                                                    <i class="mdi mdi-calendar mr-1"></i>
                                                    Ditambahkan: {{ $museum->created_at->format('d F Y, H:i') }} WIB
                                                </small>
                                                @if($museum->updated_at != $museum->created_at)
                                                    <br>
                                                    <small style="color: #fdfdfd;">
                                                        <i class="mdi mdi-update mr-1"></i>
                                                        Terakhir diupdate: {{ $museum->updated_at->format('d F Y, H:i') }} WIB
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                <i class="mdi mdi-close"></i> Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="mdi mdi-folder-open-outline" style="font-size: 64px; opacity: 0.3; color: #6c757d;"></i>
                                        <h5 class="mt-3" style="color: #6c757d;">Belum Ada Benda Koleksi</h5>
                                        <p class="mb-0" style="color: #6c757d;">Silakan tambahkan koleksi museum menggunakan form di atas</p>
                                    </div>
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
.btn-group .btn {
    border-radius: 4px !important;
    margin: 0 2px;
}

.custom-file-label::after {
    content: "Browse";
}

.badge-pill {
    border-radius: 50rem;
}
</style>

<script>
document.getElementById('foto')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const label = document.querySelector('label[for="foto"]');
    
    if (file) {
        label.textContent = file.name;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        label.textContent = 'Pilih file...';
        document.getElementById('imagePreview').style.display = 'none';
    }
});

document.querySelectorAll('.custom-file-input').forEach(function(input) {
    input.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih file baru...';
        const label = e.target.nextElementSibling;
        label.textContent = fileName;
    });
});
</script>
@endsection
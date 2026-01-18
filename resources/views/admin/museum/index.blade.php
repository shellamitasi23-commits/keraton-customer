@extends('admin.layouts.admin')

@section('title', 'Kelola Museum')

@section('content')
<div class="row">
    {{-- FORM CREATE (sudah ada, tidak perlu diubah) --}}
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Tambah Museum Baru</h4>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('admin.museum.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label for="nama">Nama Museum</label>
                        <input type="text" 
                               id="nama"
                               name="nama" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               placeholder="Masukkan nama museum"
                               value="{{ old('nama') }}" 
                               required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi"
                                  name="deskripsi" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="5" 
                                  placeholder="Jelaskan tentang museum..."
                                  required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Museum</label>
                        <input type="file" 
                               id="foto"
                               name="foto" 
                               class="form-control-file @error('foto') is-invalid @enderror" 
                               accept="image/*">
                        <small class="form-text text-muted">Format: JPG, PNG, JPEG (Max: 2MB)</small>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-fw">
                        <i class="mdi mdi-content-save mr-1"></i> Simpan Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- TABLE LIST --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Daftar Museum</h4>
                    <span class="badge badge-info">{{ $museums->count() }} Museum</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Foto</th>
                                <th>Nama Museum</th>
                                <th>Deskripsi</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($museums as $museum)
                            <tr>
                                <td>
                                    @if($museum->foto)
                                        <img src="{{ asset('storage/'.$museum->foto) }}" 
                                             alt="{{ $museum->nama }}"
                                             class="museum-thumbnail"
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div class="no-image-placeholder" style="width: 80px; height: 80px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="mdi mdi-image-off"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="font-weight-bold">{{ $museum->nama }}</td>
                                <td>{{ Str::limit($museum->deskripsi, 80) }}</td>
                                <td>
                                    {{-- ✅ TOMBOL EDIT (TAMBAHAN BARU) --}}
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-warning mr-1" 
                                            data-toggle="modal" 
                                            data-target="#editModal{{ $museum->id }}"
                                            title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-info mr-1" 
                                            data-toggle="modal" 
                                            data-target="#viewModal{{ $museum->id }}"
                                            title="Lihat Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.museum.destroy', $museum->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus museum ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- ✅ MODAL EDIT (TAMBAHAN BARU) --}}
                            <div class="modal fade" id="editModal{{ $museum->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.museum.update', $museum->id) }}" 
                                              method="POST" 
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Museum</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nama Museum</label>
                                                    <input type="text" 
                                                           name="nama" 
                                                           class="form-control" 
                                                           value="{{ $museum->nama }}" 
                                                           required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Deskripsi</label>
                                                    <textarea name="deskripsi" 
                                                              class="form-control" 
                                                              rows="5" 
                                                              required>{{ $museum->deskripsi }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Foto Museum</label>
                                                    @if($museum->foto)
                                                        <div class="mb-2">
                                                            <img src="{{ asset('storage/'.$museum->foto) }}" 
                                                                 class="img-thumbnail" 
                                                                 style="max-height: 150px;"
                                                                 alt="Current">
                                                            <p class="text-muted small mt-1">Foto saat ini</p>
                                                        </div>
                                                    @endif
                                                    <input type="file" 
                                                           name="foto" 
                                                           class="form-control-file" 
                                                           accept="image/*">
                                                    <small class="form-text text-muted">
                                                        Kosongkan jika tidak ingin mengubah foto
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="mdi mdi-content-save mr-1"></i> Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal View (tidak perlu diubah) --}}
                            <div class="modal fade" id="viewModal{{ $museum->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $museum->nama }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if($museum->foto)
                                                <img src="{{ asset('storage/'.$museum->foto) }}" 
                                                     class="img-fluid rounded mb-3" 
                                                     alt="{{ $museum->nama }}">
                                            @endif
                                            <p class="text-muted mb-2"><strong>Deskripsi:</strong></p>
                                            <p>{{ $museum->deskripsi }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="mdi mdi-folder-open-outline" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p class="mt-2">Belum ada data museum</p>
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
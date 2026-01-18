@extends('admin.layouts.admin')

@section('title', 'Detail Museum')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">{{ $museum->nama }}</h4>
                    <a href="{{ route('admin.museum.index') }}" class="btn btn-sm btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>

                @if($museum->foto)
                    <img src="{{ asset('storage/'.$museum->foto) }}" 
                         class="img-fluid rounded mb-4" 
                         alt="{{ $museum->nama }}">
                @endif

                <div class="mb-3">
                    <strong>Deskripsi:</strong>
                    <p class="mt-2">{{ $museum->deskripsi }}</p>
                </div>

                <div class="mt-4">
                    <button class="btn btn-warning" 
                            data-toggle="modal" 
                            data-target="#editModal{{ $museum->id }}">
                        <i class="mdi mdi-pencil"></i> Edit
                    </button>
                    
                    <form action="{{ route('admin.museum.destroy', $museum->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="mdi mdi-delete"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
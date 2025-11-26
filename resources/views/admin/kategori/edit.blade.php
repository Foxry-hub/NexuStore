@extends('layouts.admin')
@section('title', 'Edit Kategori - NEXUSTORE')
@section('page-title', 'Edit Kategori')

@section('content')
<style>
.form-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); max-width: 700px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
.form-group label .required { color: #dc3545; }
.form-control { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 14px; transition: border-color 0.3s; }
.form-control:focus { outline: none; border-color: #5B4AB3; box-shadow: 0 0 0 3px rgba(91, 74, 179, 0.1); }
.form-control.is-invalid { border-color: #dc3545; }
.invalid-feedback { color: #dc3545; font-size: 12px; margin-top: 5px; }
textarea.form-control { min-height: 120px; resize: vertical; }
.form-actions { display: flex; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; }
.btn { padding: 12px 30px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-block; }
.btn-primary { background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%); color: white; border: none; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(91, 74, 179, 0.3); }
.btn-secondary { background: #6c757d; color: white; border: none; }
.btn-secondary:hover { background: #5a6268; }
</style>

<div class="form-card">
    <form action="{{ route('admin.kategori.update', $category->id_kategori) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nama_kategori">Nama Kategori <span class="required">*</span></label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" value="{{ old('nama_kategori', $category->nama_kategori) }}" required>
            @error('nama_kategori')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $category->deskripsi) }}</textarea>
            @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

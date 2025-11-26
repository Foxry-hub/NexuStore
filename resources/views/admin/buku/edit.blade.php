@extends('layouts.admin')

@section('title', 'Edit Buku - NEXUSTORE')
@section('page-title', 'Edit Buku')

@section('content')
<style>
.form-card {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

.form-group label .required {
    color: #dc3545;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    transition: border-color 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #5B4AB3;
    box-shadow: 0 0 0 3px rgba(91, 74, 179, 0.1);
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.current-image {
    margin-top: 10px;
    max-width: 200px;
}

.current-image img {
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.image-preview {
    margin-top: 10px;
    max-width: 200px;
}

.image-preview img {
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.btn {
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%);
    color: white;
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(91, 74, 179, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
}

.btn-secondary:hover {
    background: #5a6268;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="form-card">
    <form action="{{ route('admin.buku.update', $book->id_buku) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <div class="form-group">
                <label for="judul">Judul Buku <span class="required">*</span></label>
                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $book->judul) }}" required>
                @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="penulis">Penulis <span class="required">*</span></label>
                <input type="text" name="penulis" id="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis', $book->penulis) }}" required>
                @error('penulis')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="penerbit">Penerbit <span class="required">*</span></label>
                <input type="text" name="penerbit" id="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit', $book->penerbit) }}" required>
                @error('penerbit')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tahun_terbit">Tahun Terbit <span class="required">*</span></label>
                <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', $book->tahun_terbit) }}" min="1900" max="{{ date('Y') }}" required>
                @error('tahun_terbit')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $book->isbn) }}">
                @error('isbn')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="jumlah_halaman">Jumlah Halaman <span class="required">*</span></label>
                <input type="number" name="jumlah_halaman" id="jumlah_halaman" class="form-control @error('jumlah_halaman') is-invalid @enderror" value="{{ old('jumlah_halaman', $book->jumlah_halaman) }}" min="1" required>
                @error('jumlah_halaman')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="id_kategori">Kategori <span class="required">*</span></label>
                <select name="id_kategori" id="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id_kategori }}" {{ old('id_kategori', $book->id_kategori) == $category->id_kategori ? 'selected' : '' }}>
                        {{ $category->nama_kategori }}
                    </option>
                    @endforeach
                </select>
                @error('id_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="harga">Harga <span class="required">*</span></label>
                <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $book->harga) }}" min="0" step="1000" required>
                @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stok">Stok <span class="required">*</span></label>
                <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $book->stok) }}" min="0" required>
                @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $book->deskripsi) }}</textarea>
                @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="gambar_cover">Cover Buku</label>
                @if($book->gambar_cover)
                <div class="current-image">
                    <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Cover Saat Ini:</p>
                    <img src="{{ asset('storage/' . $book->gambar_cover) }}" alt="Current Cover">
                </div>
                @endif
                <input type="file" name="gambar_cover" id="gambar_cover" class="form-control @error('gambar_cover') is-invalid @enderror" accept="image/*" onchange="previewImage(event)" style="margin-top: 10px;">
                <small style="color: #666;">Kosongkan jika tidak ingin mengubah cover</small>
                @error('gambar_cover')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="image-preview" id="imagePreview" style="display: none;">
                    <p style="font-size: 12px; color: #666; margin-bottom: 5px; margin-top: 10px;">Preview Cover Baru:</p>
                    <img src="" alt="Preview" id="preview">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection

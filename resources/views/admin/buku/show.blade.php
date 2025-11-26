@extends('layouts.admin')

@section('title', 'Detail Buku - NEXUSTORE')
@section('page-title', 'Detail Buku')

@section('content')
<style>
.detail-card {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.book-detail {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 40px;
}

.book-cover img {
    width: 100%;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.book-info h2 {
    color: #5B4AB3;
    margin-bottom: 10px;
}

.book-info .author {
    color: #666;
    font-size: 16px;
    margin-bottom: 20px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-top: 30px;
}

.info-item {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.info-item label {
    display: block;
    font-weight: 600;
    color: #666;
    font-size: 12px;
    margin-bottom: 5px;
    text-transform: uppercase;
}

.info-item .value {
    font-size: 16px;
    color: #333;
    font-weight: 600;
}

.description {
    margin-top: 30px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.description h3 {
    margin-bottom: 10px;
    color: #333;
}

.actions {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 15px;
}

.btn {
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
}

.btn-warning {
    background: #ffc107;
    color: #000;
}

.btn-warning:hover {
    background: #e0a800;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-category {
    background-color: #E8E6F8;
    color: #5B4AB3;
}

@media (max-width: 768px) {
    .book-detail {
        grid-template-columns: 1fr;
    }
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="detail-card">
    <div class="book-detail">
        <div class="book-cover">
            <img src="{{ $book->gambar_cover ? asset('storage/' . $book->gambar_cover) : 'https://via.placeholder.com/250x350/5B4AB3/ffffff?text=No+Image' }}" alt="{{ $book->judul }}">
        </div>
        
        <div class="book-info">
            <h2>{{ $book->judul }}</h2>
            <p class="author">oleh {{ $book->penulis }}</p>
            
            <span class="badge badge-category">{{ $book->kategori->nama_kategori }}</span>
            
            <div class="info-grid">
                <div class="info-item">
                    <label>Penerbit</label>
                    <div class="value">{{ $book->penerbit }}</div>
                </div>
                
                <div class="info-item">
                    <label>Tahun Terbit</label>
                    <div class="value">{{ $book->tahun_terbit }}</div>
                </div>
                
                <div class="info-item">
                    <label>ISBN</label>
                    <div class="value">{{ $book->isbn ?? '-' }}</div>
                </div>
                
                <div class="info-item">
                    <label>Jumlah Halaman</label>
                    <div class="value">{{ $book->jumlah_halaman }} halaman</div>
                </div>
                
                <div class="info-item">
                    <label>Harga</label>
                    <div class="value" style="color: #5B4AB3;">Rp {{ number_format($book->harga, 0, ',', '.') }}</div>
                </div>
                
                <div class="info-item">
                    <label>Stok</label>
                    <div class="value">{{ $book->stok }} unit</div>
                </div>
            </div>
            
            @if($book->deskripsi)
            <div class="description">
                <h3>Deskripsi</h3>
                <p>{{ $book->deskripsi }}</p>
            </div>
            @endif
            
            <div class="actions">
                <a href="{{ route('admin.buku.edit', $book->id_buku) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

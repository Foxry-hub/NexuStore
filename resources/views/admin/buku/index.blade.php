@extends('layouts.admin')

@section('title', 'Kelola Buku - NEXUSTORE')
@section('page-title', 'Kelola Buku')

@section('content')
<style>
.admin-buku {
    padding: 0;
}

.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.page-actions {
    margin-bottom: 20px;
}

.btn-add {
    background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(91, 74, 179, 0.3);
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(91, 74, 179, 0.4);
}

.table-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    overflow: hidden;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%);
    color: white;
}

.data-table th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
    font-size: 14px;
}

.data-table td {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background-color: #f8f9fa;
}

.book-thumbnail {
    width: 50px;
    height: 70px;
    object-fit: cover;
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.badge-category {
    background-color: #E8E6F8;
    color: #5B4AB3;
}

.badge-success {
    background-color: #d4edda;
    color: #155724;
}

.badge-warning {
    background-color: #fff3cd;
    color: #856404;
}

.badge-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-action {
    width: 35px;
    height: 35px;
    border-radius: 6px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    color: white;
}

.btn-info {
    background-color: #17a2b8;
}

.btn-info:hover {
    background-color: #138496;
}

.btn-warning {
    background-color: #ffc107;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-danger {
    background-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
}

/* ======================= */
/* PAGINATION CUSTOM STYLE */
/* ======================= */

.pagination-wrapper {
    padding: 30px 20px;
    display: flex;
    justify-content: center;
    background: #f5f5f5;
    border-radius: 0 0 10px 10px;
}

.custom-pagination {
    display: flex;
    align-items: center;
    gap: 8px;
}

.custom-pagination .arrow {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    font-size: 20px;
    color: #333;
    text-decoration: none;
    transition: all 0.3s;
}

.custom-pagination .arrow:hover:not(.disabled) {
    color: #000;
    transform: scale(1.1);
}

.custom-pagination .arrow.disabled {
    color: #ccc;
    cursor: not-allowed;
}

.custom-pagination .page {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 15px;
    font-weight: 500;
    color: #333;
    text-decoration: none;
    transition: all 0.3s;
}

.custom-pagination .page:hover:not(.active) {
    background: #e0e0e0;
}

.custom-pagination .page.active {
    background: #5B4AB3;
    color: white;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(91, 74, 179, 0.3);
}

.custom-pagination .dots {
    color: #999;
    padding: 0 5px;
}
</style>


<div class="admin-buku">
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <div class="page-actions">
        <a href="{{ route('admin.buku.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Buku Baru
        </a>
    </div>

    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Cover</th>
                    <th width="20%">Judul</th>
                    <th width="15%">Penulis</th>
                    <th width="12%">Kategori</th>
                    <th width="12%">Harga</th>
                    <th width="8%">Stok</th>
                    <th width="18%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $index => $book)
                <tr>
                    <td>{{ $books->firstItem() + $index }}</td>
                    <td>
                        <img src="{{ $book->gambar_cover ? asset('storage/' . $book->gambar_cover) : 'https://via.placeholder.com/50x70/5B4AB3/ffffff?text=No+Image' }}" 
                             alt="{{ $book->judul }}" 
                             class="book-thumbnail">
                    </td>
                    <td><strong>{{ $book->judul }}</strong></td>
                    <td>{{ $book->penulis }}</td>
                    <td>
                        <span class="badge badge-category">{{ $book->kategori->nama_kategori }}</span>
                    </td>
                    <td><strong>Rp {{ number_format($book->harga, 0, ',', '.') }}</strong></td>
                    <td>
                        <span class="badge {{ $book->stok > 10 ? 'badge-success' : ($book->stok > 0 ? 'badge-warning' : 'badge-danger') }}">
                            {{ $book->stok }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.buku.show', $book->id_buku) }}" class="btn-action btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.buku.edit', $book->id_buku) }}" class="btn-action btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.buku.destroy', $book->id_buku) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px;">
                        <i class="fas fa-book" style="font-size: 48px; color: #ccc; margin-bottom: 10px;"></i>
                        <p style="color: #999;">Belum ada data buku</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($books->hasPages())
        <div class="pagination-wrapper">
            {{ $books->links('vendor.pagination.custom') }}
        </div>
        @endif
    </div>
</div>
@endsection

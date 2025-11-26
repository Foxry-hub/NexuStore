@extends('layouts.admin')
@section('title', 'Kelola Kategori - NEXUSTORE')
@section('page-title', 'Kelola Kategori')

@section('content')
<style>
.alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.page-actions { margin-bottom: 20px; }
.btn-add { background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; transition: all 0.3s; box-shadow: 0 4px 15px rgba(91, 74, 179, 0.3); }
.btn-add:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(91, 74, 179, 0.4); }
.table-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead { background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%); color: white; }
.data-table th { padding: 15px; text-align: left; font-weight: 600; font-size: 14px; }
.data-table td { padding: 15px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
.data-table tbody tr:hover { background-color: #f8f9fa; }
.badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
.badge-info { background-color: #d1ecf1; color: #0c5460; }
.action-buttons { display: flex; gap: 8px; }
.btn-action { width: 35px; height: 35px; border-radius: 6px; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; text-decoration: none; color: white; }
.btn-info { background-color: #17a2b8; }
.btn-info:hover { background-color: #138496; }
.btn-warning { background-color: #ffc107; }
.btn-warning:hover { background-color: #e0a800; }
.btn-danger { background-color: #dc3545; }
.btn-danger:hover { background-color: #c82333; }
.pagination-wrapper { padding: 20px; display: flex; justify-content: center; }
</style>

<div>
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
        <a href="{{ route('admin.kategori.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Kategori Baru
        </a>
    </div>

    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="30%">Nama Kategori</th>
                    <th width="40%">Deskripsi</th>
                    <th width="10%">Jumlah Buku</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $category)
                <tr>
                    <td>{{ $categories->firstItem() + $index }}</td>
                    <td><strong>{{ $category->nama_kategori }}</strong></td>
                    <td>{{ Str::limit($category->deskripsi ?? '-', 80) }}</td>
                    <td><span class="badge badge-info">{{ $category->buku_count }} buku</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.kategori.edit', $category->id_kategori) }}" class="btn-action btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.kategori.destroy', $category->id_kategori) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                    <td colspan="5" style="text-align: center; padding: 40px;">
                        <i class="fas fa-folder" style="font-size: 48px; color: #ccc; margin-bottom: 10px;"></i>
                        <p style="color: #999;">Belum ada data kategori</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($categories->hasPages())
        <div class="pagination-wrapper">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Kelola Pelanggan - NEXUSTORE')
@section('page-title', 'Kelola Pelanggan')

@section('content')
<style>
.alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.table-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead { background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%); color: white; }
.data-table th { padding: 15px; text-align: left; font-weight: 600; font-size: 14px; }
.data-table td { padding: 15px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
.data-table tbody tr:hover { background-color: #f8f9fa; }
.user-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
.badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
.badge-info { background-color: #d1ecf1; color: #0c5460; }
.action-buttons { display: flex; gap: 8px; }
.btn-action { width: 35px; height: 35px; border-radius: 6px; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; text-decoration: none; color: white; }
.btn-info { background-color: #17a2b8; }
.btn-info:hover { background-color: #138496; }
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

    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="8%">No</th>
                    <th width="10%">Avatar</th>
                    <th width="20%">Nama Lengkap</th>
                    <th width="15%">Username</th>
                    <th width="20%">Email</th>
                    <th width="12%">Total Pesanan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $index => $customer)
                <tr>
                    <td>{{ $customers->firstItem() + $index }}</td>
                    <td>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->nama_lengkap) }}&background=5B4AB3&color=fff" alt="{{ $customer->nama_lengkap }}" class="user-avatar">
                    </td>
                    <td><strong>{{ $customer->nama_lengkap }}</strong></td>
                    <td>{{ $customer->username }}</td>
                    <td>{{ $customer->email }}</td>
                    <td><span class="badge badge-info">{{ $customer->pesanan_count }} pesanan</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.pelanggan.show', $customer->id_user) }}" class="btn-action btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.pelanggan.destroy', $customer->id_user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
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
                    <td colspan="7" style="text-align: center; padding: 40px;">
                        <i class="fas fa-users" style="font-size: 48px; color: #ccc; margin-bottom: 10px;"></i>
                        <p style="color: #999;">Belum ada data pelanggan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($customers->hasPages())
        <div class="pagination-wrapper">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Kelola Pesanan - NEXUSTORE')
@section('page-title', 'Kelola Pesanan')

@section('content')
<style>
.alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.filter-section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
.filter-form { display: flex; gap: 15px; align-items: end; }
.form-group { flex: 1; }
.form-group label { display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px; }
.form-control { width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; }
.btn-filter { padding: 10px 20px; background: #5B4AB3; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
.table-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead { background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%); color: white; }
.data-table th { padding: 15px; text-align: left; font-weight: 600; font-size: 14px; }
.data-table td { padding: 15px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
.data-table tbody tr:hover { background-color: #f8f9fa; }
.badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
.badge-pending { background-color: #fff3cd; color: #856404; }
.badge-diproses { background-color: #d1ecf1; color: #0c5460; }
.badge-dikirim { background-color: #cce5ff; color: #004085; }
.badge-selesai { background-color: #d4edda; color: #155724; }
.badge-dibatalkan { background-color: #f8d7da; color: #721c24; }
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

    <div class="filter-section">
        <form action="{{ route('admin.pesanan.index') }}" method="GET" class="filter-form">
            <div class="form-group">
                <label for="status">Filter Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="search">Cari Pelanggan</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="Nama pelanggan..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn-filter">
                <i class="fas fa-search"></i> Filter
            </button>
        </form>
    </div>

    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="8%">No</th>
                    <th width="20%">Pelanggan</th>
                    <th width="15%">Tanggal</th>
                    <th width="15%">Total</th>
                    <th width="12%">Status</th>
                    <th width="15%">Pembayaran</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr>
                    <td>{{ $orders->firstItem() + $index }}</td>
                    <td><strong>{{ $order->user->nama_lengkap }}</strong></td>
                    <td>{{ $order->tanggal_pesanan->format('d M Y H:i') }}</td>
                    <td><strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                    <td>
                        <span class="badge badge-{{ $order->status_pesanan }}">{{ ucfirst($order->status_pesanan) }}</span>
                    </td>
                    <td>{{ ucfirst($order->metode_pembayaran) }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.pesanan.show', $order->id_pesanan) }}" class="btn-action btn-info" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($order->status_pesanan == 'dibatalkan')
                            <form action="{{ route('admin.pesanan.destroy', $order->id_pesanan) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px;">
                        <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc; margin-bottom: 10px;"></i>
                        <p style="color: #999;">Belum ada data pesanan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($orders->hasPages())
        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Detail Pelanggan - NEXUSTORE')
@section('page-title', 'Detail Pelanggan')

@section('content')
<style>
.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    color: #333;
    text-decoration: none;
    font-weight: 600;
    margin-bottom: 25px;
    transition: all 0.3s;
}
.back-btn:hover {
    background: #f5f5f5;
    border-color: #5B4AB3;
    color: #5B4AB3;
}
.customer-profile {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 25px;
}
.profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}
.profile-header {
    background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%);
    padding: 40px 30px;
    text-align: center;
    color: white;
}
.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,0.3);
    margin: 0 auto 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}
.profile-name {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 5px;
}
.profile-role {
    background: rgba(255,255,255,0.2);
    padding: 5px 20px;
    border-radius: 20px;
    font-size: 13px;
    display: inline-block;
}
.profile-body {
    padding: 30px;
}
.info-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
}
.info-item:last-child {
    border-bottom: none;
}
.info-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #5B4AB3 0%, #322684 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}
.info-content {
    flex: 1;
}
.info-label {
    font-size: 12px;
    color: #888;
    text-transform: uppercase;
    margin-bottom: 3px;
}
.info-value {
    font-size: 15px;
    font-weight: 600;
    color: #333;
}
.stats-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    padding: 20px 30px;
    background: #f8f9fa;
    border-top: 1px solid #eee;
}
.stat-item {
    text-align: center;
}
.stat-value {
    font-size: 16px;
    font-weight: 700;
    color: #5B4AB3;
}
.stat-label {
    font-size: 12px;
    color: #888;
    margin-top: 3px;
}
.orders-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}
.orders-header {
    padding: 20px 25px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.orders-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}
.orders-header h3 i {
    color: #5B4AB3;
}
.orders-body {
    max-height: 500px;
    overflow-y: auto;
}
.order-item {
    padding: 20px 25px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.3s;
}
.order-item:hover {
    background: #f8f9fa;
}
.order-item:last-child {
    border-bottom: none;
}
.order-info h4 {
    font-size: 15px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}
.order-info h4 a {
    color: #5B4AB3;
    text-decoration: none;
}
.order-info h4 a:hover {
    text-decoration: underline;
}
.order-meta {
    font-size: 13px;
    color: #888;
    display: flex;
    gap: 15px;
}
.order-right {
    text-align: right;
}
.order-total {
    font-size: 16px;
    font-weight: 700;
    color: #5B4AB3;
    margin-bottom: 5px;
}
.badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
.badge-success { background: #d4edda; color: #155724; }
.badge-warning { background: #fff3cd; color: #856404; }
.badge-info { background: #d1ecf1; color: #0c5460; }
.badge-danger { background: #f8d7da; color: #721c24; }
.badge-primary { background: #cce5ff; color: #004085; }
.empty-orders {
    padding: 50px 25px;
    text-align: center;
    color: #888;
}
.empty-orders i {
    font-size: 48px;
    color: #ddd;
    margin-bottom: 15px;
}
.delete-section {
    padding: 20px 30px;
    border-top: 1px solid #eee;
    background: #fff5f5;
}
.delete-section p {
    font-size: 13px;
    color: #721c24;
    margin-bottom: 15px;
}
.btn-delete {
    padding: 12px 25px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}
.btn-delete:hover {
    background: #c82333;
}
.btn-delete:disabled {
    background: #ccc;
    cursor: not-allowed;
}
@media (max-width: 992px) {
    .customer-profile {
        grid-template-columns: 1fr;
    }
}
</style>

<a href="{{ route('admin.pelanggan.index') }}" class="back-btn">
    <i class="fas fa-arrow-left"></i> Kembali
</a>

<div class="customer-profile">
    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->nama_lengkap) }}&size=150&background=ffffff&color=5B4AB3&bold=true" alt="{{ $customer->nama_lengkap }}" class="profile-avatar">
            <h2 class="profile-name">{{ $customer->nama_lengkap }}</h2>
            <span class="profile-role"><i class="fas fa-user"></i> Pelanggan</span>
        </div>
        
        <div class="profile-body">
            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-at"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Username</div>
                    <div class="info-value">{{ $customer->username }}</div>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $customer->email }}</div>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $customer->no_telp ?? 'Belum diisi' }}</div>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $customer->alamat ?? 'Belum diisi' }}</div>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="info-content">
                    <div class="info-label">Bergabung Sejak</div>
                    <div class="info-value">{{ $customer->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
        
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-value">{{ $customer->pesanan->count() }}</div>
                <div class="stat-label">Total Pesanan</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">Rp {{ number_format($customer->pesanan->sum('total_harga'), 0, ',', '.') }}</div>
                <div class="stat-label">Total Belanja</div>
            </div>
        </div>
        
        @if($customer->pesanan->count() == 0)
        <div class="delete-section">
            <p><i class="fas fa-exclamation-triangle"></i> Pelanggan ini belum memiliki pesanan. Anda dapat menghapus akun ini.</p>
            <form action="{{ route('admin.pelanggan.destroy', $customer->id_user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">
                    <i class="fas fa-trash"></i> Hapus Pelanggan
                </button>
            </form>
        </div>
        @endif
    </div>
    
    <!-- Orders Card -->
    <div class="orders-card">
        <div class="orders-header">
            <h3><i class="fas fa-shopping-bag"></i> Riwayat Pesanan</h3>
            <span>{{ $customer->pesanan->count() }} pesanan</span>
        </div>
        
        <div class="orders-body">
            @forelse($customer->pesanan->sortByDesc('created_at') as $order)
            <div class="order-item">
                <div class="order-info">
                    <h4><a href="{{ route('admin.pesanan.show', $order->id_pesanan) }}">{{ $order->kode_pesanan }}</a></h4>
                    <div class="order-meta">
                        <span><i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y') }}</span>
                        <span><i class="fas fa-box"></i> {{ $order->detailPesanan->count() }} item</span>
                    </div>
                </div>
                <div class="order-right">
                    <div class="order-total">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                    @php
                        $badgeClass = match($order->status_pengiriman) {
                            'selesai' => 'badge-success',
                            'dikirim' => 'badge-info',
                            'diproses' => 'badge-primary',
                            'dibatalkan' => 'badge-danger',
                            default => 'badge-warning'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status_pengiriman) }}</span>
                </div>
            </div>
            @empty
            <div class="empty-orders">
                <i class="fas fa-shopping-bag"></i>
                <p>Pelanggan belum memiliki pesanan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

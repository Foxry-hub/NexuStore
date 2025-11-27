@extends('layouts.admin')

@section('title', 'Dashboard Admin - NEXUSTORE')
@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #5B4AB3;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalUsers) }}</h3>
                <p>Total Pelanggan</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #322684;">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalBuku) }}</h3>
                <p>Total Buku</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #17a2b8;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($totalPesanan) }}</h3>
                <p>Total Pesanan</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #28a745;">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <p>Total Pendapatan</p>
            </div>
        </div>
    </div>

    <!-- Order Status Cards -->
    <div class="order-status-grid">
        <div class="status-card status-pending">
            <div class="status-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="status-info">
                <h4>{{ $pesananBaru }}</h4>
                <p>Menunggu Pembayaran</p>
            </div>
        </div>
        <div class="status-card status-processing">
            <div class="status-icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="status-info">
                <h4>{{ $pesananDiproses }}</h4>
                <p>Diproses</p>
            </div>
        </div>
        <div class="status-card status-shipping">
            <div class="status-icon">
                <i class="fas fa-truck"></i>
            </div>
            <div class="status-info">
                <h4>{{ $pesananDikirim }}</h4>
                <p>Sedang Dikirim</p>
            </div>
        </div>
        <div class="status-card status-completed">
            <div class="status-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="status-info">
                <h4>{{ $pesananSelesai }}</h4>
                <p>Selesai</p>
            </div>
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-card">
            <div class="welcome-text">
                <h2>Selamat Datang, {{ Auth::user()->nama_lengkap }}! 👋</h2>
                <p>Anda login sebagai <strong>Administrator</strong>. Kelola toko buku online Anda dengan mudah.</p>
            </div>
            <div class="welcome-stats">
                <div class="welcome-stat-item">
                    <span class="number">{{ $pesananHariIni }}</span>
                    <span class="label">Pesanan Hari Ini</span>
                </div>
                <div class="welcome-stat-item">
                    <span class="number">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</span>
                    <span class="label">Pendapatan Bulan Ini</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3>Quick Actions</h3>
        <div class="action-grid">
            <a href="{{ route('admin.buku.create') }}" class="action-card">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Buku Baru</span>
            </a>
            <a href="{{ route('admin.kategori.create') }}" class="action-card">
                <i class="fas fa-folder-plus"></i>
                <span>Tambah Kategori</span>
            </a>
            <a href="{{ route('admin.pesanan.index') }}" class="action-card">
                <i class="fas fa-list"></i>
                <span>Lihat Pesanan</span>
            </a>
            <a href="{{ route('admin.pelanggan.index') }}" class="action-card">
                <i class="fas fa-users"></i>
                <span>Lihat Pelanggan</span>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Recent Orders -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-shopping-bag"></i> Pesanan Terbaru</h3>
                <a href="{{ route('admin.pesanan.index') }}" class="view-all-link">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td><strong>{{ $order->kode_pesanan }}</strong></td>
                                    <td>{{ $order->user->nama_lengkap ?? 'N/A' }}</td>
                                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $order->status_pengiriman }}">
                                            {{ $order->status_pengiriman_label }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="empty-state">
                        <i class="fas fa-inbox"></i><br>
                        Belum ada pesanan
                    </p>
                @endif
            </div>
        </div>

        <!-- Recent Customers -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-user-plus"></i> Pelanggan Baru</h3>
                <a href="{{ route('admin.pelanggan.index') }}" class="view-all-link">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($recentUsers->count() > 0)
                    <ul class="user-list">
                        @foreach($recentUsers as $user)
                        <li class="user-item">
                            <div class="user-avatar">
                                {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <strong>{{ $user->nama_lengkap }}</strong>
                                <span>{{ $user->email }}</span>
                            </div>
                            <div class="user-date">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="empty-state">
                        <i class="fas fa-users"></i><br>
                        Belum ada pelanggan
                    </p>
                @endif
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Stok Menipis</h3>
                <a href="{{ route('admin.buku.index') }}" class="view-all-link">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($lowStockBooks->count() > 0)
                    <ul class="stock-list">
                        @foreach($lowStockBooks as $book)
                        <li class="stock-item">
                            <div class="book-info">
                                <strong>{{ Str::limit($book->judul, 30) }}</strong>
                                <span>{{ $book->penulis }}</span>
                            </div>
                            <div class="stock-badge {{ $book->stok == 0 ? 'out-of-stock' : 'low-stock' }}">
                                {{ $book->stok }} sisa
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="empty-state success">
                        <i class="fas fa-check-circle"></i><br>
                        Semua stok aman
                    </p>
                @endif
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Ringkasan</h3>
            </div>
            <div class="card-body">
                <ul class="summary-list">
                    <li>
                        <span class="summary-label">Total Kategori</span>
                        <span class="summary-value">{{ $totalKategori }}</span>
                    </li>
                    <li>
                        <span class="summary-label">Total Buku</span>
                        <span class="summary-value">{{ $totalBuku }}</span>
                    </li>
                    <li>
                        <span class="summary-label">Total Pelanggan</span>
                        <span class="summary-value">{{ $totalUsers }}</span>
                    </li>
                    <li>
                        <span class="summary-label">Total Pesanan</span>
                        <span class="summary-value">{{ $totalPesanan }}</span>
                    </li>
                    <li>
                        <span class="summary-label">Pesanan Selesai</span>
                        <span class="summary-value text-success">{{ $pesananSelesai }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.dashboard-container {
    max-width: 1400px;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.stat-card {
    background-color: white;
    border-radius: 15px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.stat-content h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.stat-content p {
    font-size: 14px;
    color: var(--text-gray);
    margin: 0;
}

/* Order Status Grid */
.order-status-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.status-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border-left: 4px solid;
}

.status-card.status-pending {
    border-left-color: #ffc107;
}

.status-card.status-processing {
    border-left-color: #17a2b8;
}

.status-card.status-shipping {
    border-left-color: #007bff;
}

.status-card.status-completed {
    border-left-color: #28a745;
}

.status-icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.status-pending .status-icon {
    background: #fff3cd;
    color: #856404;
}

.status-processing .status-icon {
    background: #d1ecf1;
    color: #0c5460;
}

.status-shipping .status-icon {
    background: #cce5ff;
    color: #004085;
}

.status-completed .status-icon {
    background: #d4edda;
    color: #155724;
}

.status-info h4 {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
    color: var(--text-dark);
}

.status-info p {
    font-size: 12px;
    color: var(--text-gray);
    margin: 0;
}

/* Welcome Section */
.welcome-section {
    margin-bottom: 25px;
}

.welcome-card {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(91, 74, 179, 0.3);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.welcome-text h2 {
    font-size: 24px;
    margin-bottom: 8px;
}

.welcome-text p {
    font-size: 14px;
    opacity: 0.9;
    margin: 0;
}

.welcome-stats {
    display: flex;
    gap: 30px;
}

.welcome-stat-item {
    text-align: center;
    padding: 15px 25px;
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
}

.welcome-stat-item .number {
    display: block;
    font-size: 22px;
    font-weight: 700;
}

.welcome-stat-item .label {
    font-size: 11px;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Quick Actions */
.quick-actions {
    margin-bottom: 25px;
}

.quick-actions h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 15px;
    color: var(--text-dark);
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
}

.action-card {
    background-color: white;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    text-decoration: none;
    color: var(--text-dark);
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s;
}

.action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    color: var(--primary-color);
}

.action-card i {
    font-size: 28px;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.action-card span {
    display: block;
    font-weight: 600;
    font-size: 13px;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

.dashboard-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.card-header {
    padding: 18px 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-header h3 i {
    color: var(--primary-color);
}

.view-all-link {
    font-size: 13px;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.view-all-link:hover {
    text-decoration: underline;
}

.card-body {
    padding: 20px;
}

/* Mini Table */
.table-responsive {
    overflow-x: auto;
}

.mini-table {
    width: 100%;
    border-collapse: collapse;
}

.mini-table th,
.mini-table td {
    padding: 12px 10px;
    text-align: left;
    font-size: 13px;
}

.mini-table th {
    background: #f8f9fa;
    font-weight: 600;
    color: var(--text-gray);
    text-transform: uppercase;
    font-size: 11px;
}

.mini-table tr:not(:last-child) td {
    border-bottom: 1px solid #eee;
}

.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-diproses {
    background: #fff3cd;
    color: #856404;
}

.badge-dikirim {
    background: #cce5ff;
    color: #004085;
}

.badge-selesai {
    background: #d4edda;
    color: #155724;
}

.badge-dibatalkan {
    background: #f8d7da;
    color: #721c24;
}

/* User List */
.user-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.user-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.user-item:last-child {
    border-bottom: none;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
}

.user-info {
    flex: 1;
}

.user-info strong {
    display: block;
    font-size: 14px;
    color: var(--text-dark);
}

.user-info span {
    font-size: 12px;
    color: var(--text-gray);
}

.user-date {
    font-size: 11px;
    color: var(--text-gray);
}

/* Stock List */
.stock-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.stock-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.stock-item:last-child {
    border-bottom: none;
}

.stock-item .book-info strong {
    display: block;
    font-size: 14px;
    color: var(--text-dark);
}

.stock-item .book-info span {
    font-size: 12px;
    color: var(--text-gray);
}

.stock-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.stock-badge.low-stock {
    background: #fff3cd;
    color: #856404;
}

.stock-badge.out-of-stock {
    background: #f8d7da;
    color: #721c24;
}

/* Summary List */
.summary-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.summary-list li {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.summary-list li:last-child {
    border-bottom: none;
}

.summary-label {
    color: var(--text-gray);
    font-size: 14px;
}

.summary-value {
    font-weight: 700;
    font-size: 16px;
    color: var(--text-dark);
}

.summary-value.text-success {
    color: #28a745;
}

/* Empty State */
.empty-state {
    text-align: center;
    color: var(--text-gray);
    padding: 30px;
}

.empty-state i {
    font-size: 40px;
    margin-bottom: 10px;
    opacity: 0.5;
}

.empty-state.success {
    color: #28a745;
}

.empty-state.success i {
    opacity: 1;
}

@media (max-width: 768px) {
    .welcome-card {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-stats {
        width: 100%;
        justify-content: center;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .stat-content h3 {
        font-size: 22px;
    }
}
</style>
@endpush
@endsection

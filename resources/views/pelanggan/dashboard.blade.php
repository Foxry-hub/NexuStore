@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - NEXUSTORE')

@section('content')
<section class="pelanggan-dashboard">
    <div class="container">
        <!-- Welcome Header -->
        <div class="welcome-header">
            <div class="welcome-text">
                <h1>Halo, {{ Auth::user()->nama_lengkap }}! 👋</h1>
                <p>Selamat datang kembali di NEXUSTORE. Kelola pesanan dan aktivitas belanja Anda di sini.</p>
            </div>
            <div class="welcome-stats">
                <div class="welcome-stat">
                    <span class="stat-value">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span>
                    <span class="stat-label">Total Belanja</span>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon" style="background-color: #5B4AB3;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $totalPesanan }}</h3>
                    <p>Total Pesanan</p>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background-color: #ffc107;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $pesananMenunggu }}</h3>
                    <p>Menunggu Pembayaran</p>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background-color: #17a2b8;">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $pesananDiproses }}</h3>
                    <p>Sedang Diproses</p>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background-color: #007bff;">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $pesananDikirim }}</h3>
                    <p>Dalam Pengiriman</p>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background-color: #28a745;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $pesananSelesai }}</h3>
                    <p>Pesanan Selesai</p>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background-color: #6f42c1;">
                    <i class="fas fa-star"></i>
                </div>
                <div class="card-content">
                    <h3>{{ $totalReview }}</h3>
                    <p>Review Saya</p>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Quick Links -->
        <div class="dashboard-content">
            <!-- Recent Orders -->
            <div class="recent-orders-section">
                <div class="section-header">
                    <h2><i class="fas fa-history"></i> Pesanan Terbaru</h2>
                    <a href="{{ route('pesanan.index') }}" class="view-all-link">Lihat Semua</a>
                </div>
                <div class="orders-list">
                    @if($recentOrders->count() > 0)
                        @foreach($recentOrders as $order)
                        <div class="order-item">
                            <div class="order-info">
                                <span class="order-code">{{ $order->kode_pesanan }}</span>
                                <span class="order-date">{{ $order->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="order-total">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </div>
                            <div class="order-status">
                                <span class="status-badge status-{{ $order->status_pengiriman }}">
                                    {{ $order->status_pengiriman_label }}
                                </span>
                            </div>
                            <a href="{{ route('pesanan.show', $order->id_pesanan) }}" class="order-detail-btn">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-orders">
                            <i class="fas fa-shopping-bag"></i>
                            <p>Belum ada pesanan</p>
                            <a href="{{ route('shop.index') }}" class="btn-shop">Mulai Belanja</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="quick-links-section">
                <h2><i class="fas fa-link"></i> Menu Cepat</h2>
                <div class="quick-links-grid">
                    <a href="{{ route('pelanggan.profile') }}" class="quick-link-card">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil Saya</span>
                    </a>
                    <a href="{{ route('shop.index') }}" class="quick-link-card">
                        <i class="fas fa-store"></i>
                        <span>Toko Buku</span>
                    </a>
                    <a href="{{ route('keranjang.index') }}" class="quick-link-card">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Keranjang ({{ $itemKeranjang }})</span>
                    </a>
                    <a href="{{ route('pesanan.index') }}" class="quick-link-card">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Pesanan Saya</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-section">
            <a href="{{ route('shop.index') }}" class="btn-primary">
                <i class="fas fa-shopping-bag"></i> Belanja Sekarang
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-secondary">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
</section>

@push('styles')
<style>
.pelanggan-dashboard {
    padding: 40px 0 80px;
    min-height: calc(100vh - 200px);
    background-color: #f8f9fa;
}

/* Welcome Header */
.welcome-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 35px;
    border-radius: 20px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    box-shadow: 0 10px 30px rgba(91, 74, 179, 0.3);
}

.welcome-text h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
}

.welcome-text p {
    font-size: 14px;
    opacity: 0.9;
    margin: 0;
}

.welcome-stats {
    display: flex;
    gap: 20px;
}

.welcome-stat {
    background: rgba(255,255,255,0.15);
    padding: 15px 25px;
    border-radius: 12px;
    text-align: center;
}

.welcome-stat .stat-value {
    display: block;
    font-size: 22px;
    font-weight: 700;
}

.welcome-stat .stat-label {
    font-size: 12px;
    opacity: 0.9;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
}

.dashboard-card {
    background-color: white;
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.3s, box-shadow 0.3s;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.card-content h3 {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 3px;
}

.card-content p {
    font-size: 12px;
    color: var(--text-gray);
    margin: 0;
}

/* Dashboard Content */
.dashboard-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 25px;
    margin-bottom: 30px;
}

@media (max-width: 992px) {
    .dashboard-content {
        grid-template-columns: 1fr;
    }
}

/* Recent Orders */
.recent-orders-section {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-header h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
}

.section-header h2 i {
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

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    transition: background 0.3s;
}

.order-item:hover {
    background: #f0f0f0;
}

.order-info {
    flex: 1;
}

.order-code {
    display: block;
    font-weight: 700;
    color: var(--text-dark);
    font-size: 14px;
}

.order-date {
    font-size: 12px;
    color: var(--text-gray);
}

.order-total {
    font-weight: 600;
    color: var(--primary-color);
    font-size: 14px;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.status-diproses {
    background: #fff3cd;
    color: #856404;
}

.status-dikirim {
    background: #cce5ff;
    color: #004085;
}

.status-selesai {
    background: #d4edda;
    color: #155724;
}

.status-dibatalkan {
    background: #f8d7da;
    color: #721c24;
}

.order-detail-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: background 0.3s;
}

.order-detail-btn:hover {
    background: var(--secondary-color);
}

.empty-orders {
    text-align: center;
    padding: 40px;
    color: var(--text-gray);
}

.empty-orders i {
    font-size: 50px;
    opacity: 0.3;
    margin-bottom: 15px;
}

.empty-orders p {
    margin-bottom: 15px;
}

.btn-shop {
    display: inline-block;
    padding: 10px 25px;
    background: var(--primary-color);
    color: white;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
}

.btn-shop:hover {
    background: var(--secondary-color);
}

/* Quick Links */
.quick-links-section {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.quick-links-section h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.quick-links-section h2 i {
    color: var(--primary-color);
}

.quick-links-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.quick-link-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px 15px;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.quick-link-card:hover {
    background: var(--primary-color);
    transform: translateY(-3px);
}

.quick-link-card:hover i,
.quick-link-card:hover span {
    color: white;
}

.quick-link-card i {
    font-size: 28px;
    color: var(--primary-color);
    transition: color 0.3s;
}

.quick-link-card span {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 13px;
    transition: color 0.3s;
}

/* Action Section */
.action-section {
    text-align: center;
    display: flex;
    gap: 15px;
    justify-content: center;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.btn-primary:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-family: 'Montserrat', sans-serif;
}

.btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .welcome-header {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-text h1 {
        font-size: 22px;
    }
    
    .dashboard-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .quick-links-grid {
        grid-template-columns: 1fr;
    }
    
    .action-section {
        flex-direction: column;
    }
}
</style>
@endpush
@endsection

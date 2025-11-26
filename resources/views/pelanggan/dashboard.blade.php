@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - NEXUSTORE')

@section('content')
<section class="pelanggan-dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>Dashboard Pelanggan</h1>
            <p>Selamat datang, <strong>{{ Auth::user()->nama_lengkap }}</strong>!</p>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon" style="background-color: #5B4AB3;">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-content">
                    <h3>0</h3>
                    <p>Pesanan Saya</p>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background-color: #322684;">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="card-content">
                    <h3>0</h3>
                    <p>Wishlist</p>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon" style="background-color: #E8E6F8; color: #5B4AB3;">
                    <i class="fas fa-box"></i>
                </div>
                <div class="card-content">
                    <h3>0</h3>
                    <p>Dalam Pengiriman</p>
                </div>
            </div>
        </div>

        <div class="quick-links-section">
            <h2>Quick Links</h2>
            <div class="quick-links-grid">
                <a href="{{ route('pelanggan.profile') }}" class="quick-link-card">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil Saya</span>
                </a>
                <a href="{{ route('shop.index') }}" class="quick-link-card">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Belanja Sekarang</span>
                </a>
                <a href="#" class="quick-link-card">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Pesanan</span>
                </a>
                <a href="#" class="quick-link-card">
                    <i class="fas fa-heart"></i>
                    <span>Wishlist</span>
                </a>
            </div>
        </div>

        <div class="action-section">
            <a href="{{ route('shop.index') }}" class="btn-primary">
                <i class="fas fa-shopping-bag"></i> Mulai Belanja
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
    padding: 80px 0;
    min-height: calc(100vh - 200px);
}

.dashboard-header {
    text-align: center;
    margin-bottom: 40px;
}

.dashboard-header h1 {
    font-size: 36px;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.dashboard-header p {
    font-size: 18px;
    color: var(--text-gray);
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.dashboard-card {
    background-color: white;
    border-radius: 15px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.3s;
}

.dashboard-card:hover {
    transform: translateY(-5px);
}

.card-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.card-content h3 {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.card-content p {
    font-size: 14px;
    color: var(--text-gray);
    margin: 0;
}

.quick-links-section {
    margin-bottom: 40px;
}

.quick-links-section h2 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 20px;
}

.quick-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.quick-link-card {
    background-color: white;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    text-decoration: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.quick-link-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.quick-link-card i {
    font-size: 40px;
    color: var(--primary-color);
}

.quick-link-card span {
    font-weight: 600;
    color: var(--text-dark);
    font-size: 16px;
}

.action-section {
    text-align: center;
    display: flex;
    gap: 15px;
    justify-content: center;
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
</style>
@endpush
@endsection

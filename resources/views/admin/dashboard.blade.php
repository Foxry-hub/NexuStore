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
                <h3>{{ $totalUsers }}</h3>
                <p>Total Pelanggan</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #322684;">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <h3>0</h3>
                <p>Total Buku</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #E8E6F8; color: #5B4AB3;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <h3>0</h3>
                <p>Total Pesanan</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: #28a745;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <h3>Rp 0</h3>
                <p>Total Pendapatan</p>
            </div>
        </div>
    </div>

    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-card">
            <h2>Selamat Datang, {{ Auth::user()->nama_lengkap }}! 👋</h2>
            <p>Anda login sebagai <strong>Administrator</strong>. Kelola toko buku online Anda dengan mudah.</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3>Quick Actions</h3>
        <div class="action-grid">
            <a href="#" class="action-card">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Buku Baru</span>
            </a>
            <a href="#" class="action-card">
                <i class="fas fa-folder-plus"></i>
                <span>Tambah Kategori</span>
            </a>
            <a href="#" class="action-card">
                <i class="fas fa-list"></i>
                <span>Lihat Pesanan</span>
            </a>
            <a href="#" class="action-card">
                <i class="fas fa-chart-line"></i>
                <span>Lihat Laporan</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-section">
        <h3>Recent Activity</h3>
        <div class="activity-card">
            <p class="empty-state">
                <i class="fas fa-inbox"></i><br>
                Belum ada aktivitas terbaru
            </p>
        </div>
    </div>
</div>

@push('styles')
<style>
.admin-body {
    background-color: #f5f5f5;
    margin: 0;
}

.admin-wrapper {
    display: flex;
    min-height: 100vh;
}

/* Sidebar */
.admin-sidebar {
    width: 260px;
    background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
}

.sidebar-header {
    padding: 25px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 22px;
    font-weight: 700;
}

.sidebar-nav {
    padding: 20px 0;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 25px;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: all 0.3s;
}

.nav-item:hover,
.nav-item.active {
    background-color: rgba(255,255,255,0.1);
    color: white;
}

.nav-item i {
    width: 20px;
    font-size: 18px;
}

/* Sidebar Footer */
.sidebar-footer {
    margin-top: auto;
    padding: 20px 0;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.logout-form {
    width: 100%;
}

.logout-btn {
    width: 100%;
    background: none;
    border: none;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
    font-size: 16px;
    text-align: left;
}

.logout-btn:hover {
    background-color: rgba(255,59,59,0.2);
}

/* Main Content */
.admin-main {
    flex: 1;
    margin-left: 260px;
}

/* Topbar */
.admin-topbar {
    background-color: white;
    padding: 20px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 0;
    z-index: 100;
}

.topbar-left h1 {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
}

.user-menu {
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    cursor: pointer;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid var(--primary-color);
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    font-size: 14px;
    color: var(--text-dark);
}

.user-role {
    font-size: 12px;
    color: var(--text-gray);
}

.user-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    margin-top: 10px;
    min-width: 200px;
    overflow: hidden;
}

.user-menu:hover .user-dropdown {
    display: block;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    color: var(--text-dark);
    text-decoration: none;
    transition: background-color 0.3s;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
}

.dropdown-item:hover {
    background-color: #f5f5f5;
}

/* Content */
.admin-content {
    padding: 30px;
}

.dashboard-container {
    max-width: 1400px;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
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
    font-size: 32px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.stat-content p {
    font-size: 14px;
    color: var(--text-gray);
    margin: 0;
}

/* Welcome Section */
.welcome-section {
    margin-bottom: 30px;
}

.welcome-card {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(91, 74, 179, 0.3);
}

.welcome-card h2 {
    font-size: 28px;
    margin-bottom: 10px;
}

.welcome-card p {
    font-size: 16px;
    opacity: 0.9;
}

/* Quick Actions */
.quick-actions {
    margin-bottom: 30px;
}

.quick-actions h3 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 15px;
    color: var(--text-dark);
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.action-card {
    background-color: white;
    padding: 25px;
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
    font-size: 32px;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.action-card span {
    display: block;
    font-weight: 600;
    font-size: 14px;
}

/* Recent Section */
.recent-section h3 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 15px;
    color: var(--text-dark);
}

.activity-card {
    background-color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.empty-state {
    text-align: center;
    color: var(--text-gray);
    padding: 40px;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 10px;
    opacity: 0.5;
}
</style>
@endpush
@endsection

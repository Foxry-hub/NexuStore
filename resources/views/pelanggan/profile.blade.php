@extends('layouts.app')

@section('title', 'Profil Saya - NEXUSTORE')

@section('content')
<section class="profile-page">
    <div class="container">
        <div class="page-header">
            <h1>Profil Saya</h1>
            <p>Kelola informasi profil Anda</p>
        </div>

        <div class="profile-content">
            <!-- Profile Card -->
            <div class="profile-main-card">
                <div class="profile-avatar-section">
                    <div class="avatar-large">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap) }}&size=150&background=5B4AB3&color=fff" alt="{{ Auth::user()->nama_lengkap }}">
                    </div>
                    <h2>{{ Auth::user()->nama_lengkap }}</h2>
                    <p class="user-role">Pelanggan</p>
                </div>

                <div class="profile-info-section">
                    <h3>Informasi Akun</h3>
                    
                    <div class="info-group">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-user"></i>
                                <span>Username</span>
                            </div>
                            <div class="info-value">{{ Auth::user()->username }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-signature"></i>
                                <span>Nama Lengkap</span>
                            </div>
                            <div class="info-value">{{ Auth::user()->nama_lengkap }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i>
                                <span>Email</span>
                            </div>
                            <div class="info-value">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Alamat</span>
                            </div>
                            <div class="info-value">{{ Auth::user()->alamat ?? 'Belum diisi' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Bergabung Sejak</span>
                            </div>
                            <div class="info-value">{{ Auth::user()->created_at->format('d M Y') }}</div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn-edit">
                            <i class="fas fa-edit"></i> Edit Profil
                        </button>
                        <button class="btn-password">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="profile-stats">
                <div class="stat-card-profile">
                    <i class="fas fa-shopping-bag"></i>
                    <div class="stat-info">
                        <h4>0</h4>
                        <p>Total Pesanan</p>
                    </div>
                </div>

                <div class="stat-card-profile">
                    <i class="fas fa-heart"></i>
                    <div class="stat-info">
                        <h4>0</h4>
                        <p>Wishlist</p>
                    </div>
                </div>

                <div class="stat-card-profile">
                    <i class="fas fa-star"></i>
                    <div class="stat-info">
                        <h4>0</h4>
                        <p>Review Diberikan</p>
                    </div>
                </div>
            </div>

            <!-- Back to Dashboard -->
            <div class="back-section">
                <a href="{{ route('pelanggan.dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.profile-page {
    padding: 80px 0;
    min-height: calc(100vh - 200px);
    background-color: #f8f8f8;
}

.page-header {
    text-align: center;
    margin-bottom: 50px;
}

.page-header h1 {
    font-size: 36px;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.page-header p {
    font-size: 16px;
    color: var(--text-gray);
}

.profile-content {
    max-width: 900px;
    margin: 0 auto;
}

.profile-main-card {
    background-color: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.profile-avatar-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    padding: 50px 30px 40px;
    text-align: center;
    color: white;
}

.avatar-large {
    width: 150px;
    height: 150px;
    margin: 0 auto 20px;
    border-radius: 50%;
    overflow: hidden;
    border: 5px solid rgba(255,255,255,0.3);
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

.avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-avatar-section h2 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 5px;
}

.user-role {
    font-size: 14px;
    opacity: 0.9;
    background-color: rgba(255,255,255,0.2);
    display: inline-block;
    padding: 5px 20px;
    border-radius: 20px;
    margin-top: 10px;
}

.profile-info-section {
    padding: 40px;
}

.profile-info-section h3 {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.info-group {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 30px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 10px;
    transition: background-color 0.3s;
}

.info-item:hover {
    background-color: #e9ecef;
}

.info-label {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 600;
    color: var(--text-dark);
}

.info-label i {
    width: 20px;
    color: var(--primary-color);
    font-size: 16px;
}

.info-value {
    color: var(--text-gray);
    font-size: 15px;
    text-align: right;
}

.action-buttons {
    display: flex;
    gap: 15px;
}

.btn-edit,
.btn-password {
    flex: 1;
    padding: 12px 24px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-family: 'Montserrat', sans-serif;
}

.btn-edit {
    background-color: var(--primary-color);
    color: white;
}

.btn-edit:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(91, 74, 179, 0.3);
}

.btn-password {
    background-color: #6c757d;
    color: white;
}

.btn-password:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
}

.profile-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card-profile {
    background-color: white;
    border-radius: 15px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.3s;
}

.stat-card-profile:hover {
    transform: translateY(-5px);
}

.stat-card-profile i {
    font-size: 40px;
    color: var(--primary-color);
}

.stat-info h4 {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.stat-info p {
    font-size: 14px;
    color: var(--text-gray);
    margin: 0;
}

.back-section {
    text-align: center;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 30px;
    background-color: white;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-back:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(91, 74, 179, 0.3);
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .profile-stats {
        grid-template-columns: 1fr;
    }
    
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .info-value {
        text-align: left;
    }
}
</style>
@endpush
@endsection

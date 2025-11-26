@extends('layouts.app')

@section('title', 'Profil Saya - NEXUSTORE')

@section('content')
<section class="profile-page">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-user-circle"></i> Profil Saya</h1>
            <p>Kelola informasi profil Anda</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="profile-content">
            <!-- Profile Card -->
            <div class="profile-main-card">
                <div class="profile-avatar-section">
                    <div class="avatar-large">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap) }}&size=150&background=667eea&color=fff&bold=true" alt="{{ Auth::user()->nama_lengkap }}">
                    </div>
                    <h2>{{ Auth::user()->nama_lengkap }}</h2>
                    <p class="user-role"><i class="fas fa-star"></i> Pelanggan</p>
                </div>

                <div class="profile-info-section">
                    <h3><i class="fas fa-id-card"></i> Informasi Akun</h3>
                    
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
                        <button class="btn-edit" onclick="openModal('editProfileModal')">
                            <i class="fas fa-edit"></i> Edit Profil
                        </button>
                        <button class="btn-password" onclick="openModal('changePasswordModal')">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="profile-stats">
                <div class="stat-card-profile">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-info">
                        <h4>{{ $totalPesanan ?? 0 }}</h4>
                        <p>Total Pesanan</p>
                    </div>
                </div>

                <div class="stat-card-profile">
                    <div class="stat-icon pink">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="stat-info">
                        <h4>0</h4>
                        <p>Wishlist</p>
                    </div>
                </div>

                <div class="stat-card-profile">
                    <div class="stat-icon gold">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-info">
                        <h4>{{ $totalReview ?? 0 }}</h4>
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

<!-- Edit Profile Modal -->
<div class="modal-overlay" id="editProfileModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-user-edit"></i> Edit Profil</h3>
            <button class="modal-close" onclick="closeModal('editProfileModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('pelanggan.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ Auth::user()->username }}" required>
                </div>

                <div class="form-group">
                    <label for="nama_lengkap"><i class="fas fa-signature"></i> Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="{{ Auth::user()->nama_lengkap }}" required>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                </div>

                <div class="form-group">
                    <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap...">{{ Auth::user()->alamat }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editProfileModal')">Batal</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal-overlay" id="changePasswordModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-lock"></i> Ubah Password</h3>
            <button class="modal-close" onclick="closeModal('changePasswordModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('pelanggan.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="current_password"><i class="fas fa-key"></i> Password Saat Ini</label>
                    <div class="password-wrapper">
                        <input type="password" id="current_password" name="current_password" class="form-control" required placeholder="Masukkan password saat ini">
                        <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                            <i class="fas fa-eye" id="current_password-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password Baru</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation"><i class="fas fa-shield-alt"></i> Konfirmasi Password Baru</label>
                    <div class="password-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="Ulangi password baru">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="password-requirements">
                    <p><i class="fas fa-info-circle"></i> Password harus minimal 6 karakter</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('changePasswordModal')">Batal</button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-key"></i> Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.profile-page {
    padding: 80px 0;
    min-height: calc(100vh - 200px);
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
}

.page-header {
    text-align: center;
    margin-bottom: 50px;
}

.page-header h1 {
    font-size: 36px;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
    display: inline-flex;
    align-items: center;
    gap: 15px;
}

.page-header h1 i {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.page-header p {
    font-size: 16px;
    color: var(--text-gray);
}

.alert {
    max-width: 900px;
    margin: 0 auto 25px;
    padding: 15px 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border: 1px solid #b8dacc;
}

.alert-error {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-error ul {
    margin: 0;
    padding-left: 20px;
}

.profile-content {
    max-width: 900px;
    margin: 0 auto;
}

.profile-main-card {
    background-color: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.profile-avatar-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 50px 30px 40px;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.profile-avatar-section::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
    animation: pulse-bg 4s ease-in-out infinite;
}

@keyframes pulse-bg {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.3; }
}

.avatar-large {
    width: 150px;
    height: 150px;
    margin: 0 auto 20px;
    border-radius: 50%;
    overflow: hidden;
    border: 5px solid rgba(255,255,255,0.3);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    position: relative;
    z-index: 1;
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
    position: relative;
    z-index: 1;
}

.user-role {
    font-size: 14px;
    background-color: rgba(255,255,255,0.2);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 24px;
    border-radius: 25px;
    margin-top: 10px;
    position: relative;
    z-index: 1;
    backdrop-filter: blur(10px);
}

.profile-info-section {
    padding: 40px;
}

.profile-info-section h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.profile-info-section h3 i {
    color: #667eea;
}

.info-group {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 30px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
    border-radius: 12px;
    border: 1px solid #e9ecef;
    transition: all 0.3s;
}

.info-item:hover {
    transform: translateX(5px);
    border-color: #667eea;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.1);
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
    color: #667eea;
    font-size: 16px;
}

.info-value {
    color: var(--text-gray);
    font-size: 15px;
    text-align: right;
    max-width: 60%;
}

.action-buttons {
    display: flex;
    gap: 15px;
}

.btn-edit,
.btn-password {
    flex: 1;
    padding: 14px 24px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-family: 'Montserrat', sans-serif;
}

.btn-edit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
}

.btn-edit:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
}

.btn-password {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
    box-shadow: 0 5px 20px rgba(108, 117, 125, 0.3);
}

.btn-password:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(108, 117, 125, 0.4);
}

.profile-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card-profile {
    background-color: white;
    border-radius: 16px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: all 0.3s;
}

.stat-card-profile:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon.pink {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-icon.gold {
    background: linear-gradient(135deg, #f5af19 0%, #f12711 100%);
}

.stat-icon i {
    font-size: 24px;
    color: white;
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
    padding: 14px 35px;
    background-color: white;
    color: #667eea;
    border: 2px solid #667eea;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.btn-back:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(5px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.modal-overlay.active {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 20px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 80px rgba(0,0,0,0.3);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-header {
    padding: 25px 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    font-size: 20px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
}

.modal-close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close:hover {
    background: rgba(255,255,255,0.3);
    transform: rotate(90deg);
}

.modal-body {
    padding: 30px;
}

.modal-body .form-group {
    margin-bottom: 20px;
}

.modal-body .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.modal-body .form-group label i {
    margin-right: 8px;
    color: #667eea;
}

.modal-body .form-control {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    transition: all 0.3s;
}

.modal-body .form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.15);
}

.modal-body textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

/* Password Toggle */
.password-wrapper {
    position: relative;
}

.password-wrapper .form-control {
    padding-right: 50px;
}

.password-toggle {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    padding: 10px;
    cursor: pointer;
    color: #888;
    transition: all 0.3s;
}

.password-toggle:hover {
    color: #667eea;
}

.password-requirements {
    padding: 12px 15px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.password-requirements p {
    margin: 0;
    font-size: 13px;
    color: #666;
}

.password-requirements i {
    margin-right: 8px;
    color: #667eea;
}

.modal-footer {
    padding: 20px 30px;
    background: #f8f9fa;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

.btn-cancel,
.btn-save {
    padding: 12px 25px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    font-family: 'Montserrat', sans-serif;
}

.btn-cancel {
    background: #e9ecef;
    color: #495057;
}

.btn-cancel:hover {
    background: #dee2e6;
}

.btn-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
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
        max-width: 100%;
    }
    
    .modal-content {
        margin: 15px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function openModal(modalId) {
    document.getElementById(modalId).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
    document.body.style.overflow = 'auto';
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Close modal when clicking outside
document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    });
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.active').forEach(modal => {
            modal.classList.remove('active');
        });
        document.body.style.overflow = 'auto';
    }
});
</script>
@endpush
@endsection

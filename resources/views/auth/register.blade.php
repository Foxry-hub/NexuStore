@extends('layouts.app')

@section('title', 'Register - NEXUSTORE')

@section('content')
<section class="auth-section">
    <!-- Stars Background -->
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>
    
    <!-- Floating Planets -->
    <div class="planet planet-1"></div>
    <div class="planet planet-2"></div>
    <div class="planet planet-3"></div>
    <div class="planet planet-4"></div>
    
    <!-- Shooting Stars -->
    <div class="shooting-star"></div>
    <div class="shooting-star delay-1"></div>
    <div class="shooting-star delay-2"></div>
    
    <!-- Nebula Effect -->
    <div class="nebula"></div>

    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="logo-space">
                        <i class="fas fa-user-astronaut"></i>
                    </div>
                    <h2>Join The Galaxy</h2>
                    <p>Buat akun dan mulai petualangan Anda</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="username"><i class="fas fa-at"></i> Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required class="form-control" placeholder="space_explorer">
                        </div>

                        <div class="form-group">
                            <label for="nama_lengkap"><i class="fas fa-user"></i> Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="form-control" placeholder="John Doe">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control" placeholder="astronaut@galaxy.com">
                    </div>

                    <div class="form-group">
                        <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                        <textarea id="alamat" name="alamat" required class="form-control" rows="3" placeholder="Masukkan alamat lengkap untuk pengiriman...">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password"><i class="fas fa-lock"></i> Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="password" name="password" required class="form-control" placeholder="••••••••">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation"><i class="fas fa-shield-alt"></i> Konfirmasi</label>
                            <div class="password-wrapper">
                                <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control" placeholder="••••••••">
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary btn-full">
                        <i class="fas fa-rocket"></i> Launch Account
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Sudah punya akun? <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.auth-section {
    position: relative;
    padding: 60px 0;
    background: linear-gradient(135deg, #0c0d13 0%, #1a1b2e 50%, #16213e 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

/* Stars Animation */
.stars, .stars2, .stars3 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.stars {
    background: transparent url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="white"/></svg>') repeat;
    background-size: 50px 50px;
    animation: twinkle 3s ease-in-out infinite;
}

.stars2 {
    background: transparent url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="30" cy="70" r="0.8" fill="rgba(255,255,255,0.8)"/></svg>') repeat;
    background-size: 70px 70px;
    animation: twinkle 4s ease-in-out infinite 1s;
}

.stars3 {
    background: transparent url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="70" cy="30" r="0.6" fill="rgba(255,255,255,0.6)"/></svg>') repeat;
    background-size: 90px 90px;
    animation: twinkle 5s ease-in-out infinite 2s;
}

@keyframes twinkle {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 1; }
}

/* Nebula Effect */
.nebula {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 800px;
    height: 800px;
    background: radial-gradient(ellipse at center, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.1) 30%, transparent 70%);
    pointer-events: none;
    animation: nebulaPulse 8s ease-in-out infinite;
}

@keyframes nebulaPulse {
    0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
    50% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.1); }
}

/* Floating Planets */
.planet {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.planet-1 {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    top: 8%;
    right: 15%;
    box-shadow: 0 0 60px rgba(102, 126, 234, 0.5), inset -20px -20px 40px rgba(0,0,0,0.3);
    animation: float 8s ease-in-out infinite;
}

.planet-2 {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    bottom: 15%;
    left: 8%;
    box-shadow: 0 0 40px rgba(240, 147, 251, 0.4), inset -10px -10px 20px rgba(0,0,0,0.3);
    animation: float 6s ease-in-out infinite 1s;
}

.planet-3 {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    top: 70%;
    right: 8%;
    box-shadow: 0 0 30px rgba(79, 172, 254, 0.4), inset -8px -8px 15px rgba(0,0,0,0.3);
    animation: float 7s ease-in-out infinite 2s;
}

.planet-4 {
    width: 25px;
    height: 25px;
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    top: 20%;
    left: 10%;
    box-shadow: 0 0 25px rgba(252, 182, 159, 0.4), inset -5px -5px 10px rgba(0,0,0,0.2);
    animation: float 5s ease-in-out infinite 0.5s;
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(10deg); }
}

/* Shooting Stars */
.shooting-star {
    position: absolute;
    width: 100px;
    height: 2px;
    background: linear-gradient(90deg, transparent, #fff, transparent);
    top: 15%;
    left: -100px;
    animation: shoot 3s linear infinite;
}

.shooting-star.delay-1 {
    top: 45%;
    animation-delay: 1s;
}

.shooting-star.delay-2 {
    top: 75%;
    animation-delay: 2s;
}

@keyframes shoot {
    0% { left: -100px; opacity: 1; }
    70% { opacity: 1; }
    100% { left: 110%; opacity: 0; }
}

.auth-container {
    max-width: 520px;
    margin: 0 auto;
    position: relative;
    z-index: 10;
}

.auth-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 35px 40px;
    box-shadow: 0 25px 80px rgba(0,0,0,0.5), 0 0 40px rgba(102, 126, 234, 0.2);
    border: 1px solid rgba(255,255,255,0.2);
    animation: cardFloat 6s ease-in-out infinite;
}

@keyframes cardFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.auth-header {
    text-align: center;
    margin-bottom: 25px;
}

.logo-space {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    animation: pulse 2s ease-in-out infinite;
}

.logo-space i {
    font-size: 30px;
    color: white;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4); }
    50% { box-shadow: 0 10px 50px rgba(102, 126, 234, 0.6); }
}

.auth-header h2 {
    font-size: 28px;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
}

.auth-header p {
    color: #666;
    font-size: 14px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #333;
    font-size: 13px;
}

.form-group label i {
    margin-right: 6px;
    color: #667eea;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    transition: all 0.3s;
    background: rgba(255,255,255,0.9);
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.form-control::placeholder {
    color: #aaa;
}

/* Password Toggle */
.password-wrapper {
    position: relative;
}

.password-wrapper .form-control {
    padding-right: 45px;
}

.password-toggle {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    color: #888;
    transition: all 0.3s;
}

.password-toggle:hover {
    color: #667eea;
}

.password-toggle i {
    font-size: 14px;
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

.btn-primary.btn-full {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    color: white;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.btn-primary.btn-full:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
}

.btn-primary.btn-full i {
    animation: rocketShake 1s ease-in-out infinite;
}

@keyframes rocketShake {
    0%, 100% { transform: rotate(-5deg); }
    50% { transform: rotate(5deg); }
}

.auth-footer {
    text-align: center;
    margin-top: 20px;
}

.auth-footer p {
    color: #666;
    font-size: 14px;
}

.auth-footer a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.auth-footer a:hover {
    color: #764ba2;
}

.auth-footer a i {
    margin-right: 5px;
    transition: transform 0.3s;
}

.auth-footer a:hover i {
    transform: translateX(-5px);
}

.alert {
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 13px;
}

.alert-error {
    background: linear-gradient(135deg, #fee 0%, #fdd 100%);
    color: #c33;
    border: 1px solid #fcc;
}

.alert-error ul {
    margin: 5px 0 0 20px;
    padding: 0;
}

.alert-error i {
    margin-right: 8px;
}

@media (max-width: 576px) {
    .auth-card {
        margin: 0 15px;
        padding: 25px 20px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .planet-1 { width: 70px; height: 70px; }
    .planet-2 { width: 35px; height: 35px; }
    .planet-3 { width: 25px; height: 25px; }
    .planet-4 { display: none; }
}
</style>
@endpush

@push('scripts')
<script>
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
</script>
@endpush
@endsection

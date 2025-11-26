@extends('layouts.app')

@section('title', 'Login - NEXUSTORE')

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
    
    <!-- Shooting Stars -->
    <div class="shooting-star"></div>
    <div class="shooting-star delay-1"></div>
    <div class="shooting-star delay-2"></div>

    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="logo-space">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h2>Welcome Back</h2>
                    <p>Masuk ke NEXUSTORE</p>
                </div>

                <!-- Demo Login Buttons -->
                <div class="demo-login-section">
                    <p class="demo-title"><i class="fas fa-bolt"></i> Quick Demo Login</p>
                    <div class="demo-buttons">
                        <button type="button" onclick="loginAsAdmin()" class="btn-demo btn-admin">
                            <i class="fas fa-user-astronaut"></i> Admin
                        </button>
                        <button type="button" onclick="loginAsCustomer()" class="btn-demo btn-customer">
                            <i class="fas fa-user"></i> Customer
                        </button>
                    </div>
                </div>

                <div class="divider">
                    <span><i class="fas fa-star"></i></span>
                </div>

                <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="astronaut@space.com">
                    </div>

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
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span>Ingat Saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary btn-full">
                        <i class="fas fa-sign-in-alt"></i> Launch Login
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang <i class="fas fa-arrow-right"></i></a></p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.auth-section {
    position: relative;
    padding: 80px 0;
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

/* Floating Planets */
.planet {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.planet-1 {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    top: 10%;
    right: 10%;
    box-shadow: 0 0 60px rgba(102, 126, 234, 0.5), inset -20px -20px 40px rgba(0,0,0,0.3);
    animation: float 8s ease-in-out infinite;
}

.planet-2 {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    bottom: 20%;
    left: 5%;
    box-shadow: 0 0 40px rgba(240, 147, 251, 0.4), inset -10px -10px 20px rgba(0,0,0,0.3);
    animation: float 6s ease-in-out infinite 1s;
}

.planet-3 {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    top: 60%;
    right: 5%;
    box-shadow: 0 0 30px rgba(79, 172, 254, 0.4), inset -8px -8px 15px rgba(0,0,0,0.3);
    animation: float 7s ease-in-out infinite 2s;
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
    top: 20%;
    left: -100px;
    animation: shoot 3s linear infinite;
}

.shooting-star.delay-1 {
    top: 40%;
    animation-delay: 1s;
}

.shooting-star.delay-2 {
    top: 70%;
    animation-delay: 2s;
}

@keyframes shoot {
    0% { left: -100px; opacity: 1; }
    70% { opacity: 1; }
    100% { left: 110%; opacity: 0; }
}

.auth-container {
    max-width: 450px;
    margin: 0 auto;
    position: relative;
    z-index: 10;
}

.auth-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 25px 80px rgba(0,0,0,0.5), 0 0 40px rgba(102, 126, 234, 0.2);
    border: 1px solid rgba(255,255,255,0.2);
    animation: cardFloat 6s ease-in-out infinite;
}

@keyframes cardFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.auth-header {
    text-align: center;
    margin-bottom: 30px;
}

.logo-space {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    animation: pulse 2s ease-in-out infinite;
}

.logo-space i {
    font-size: 36px;
    color: white;
    animation: rocketShake 1s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4); }
    50% { box-shadow: 0 10px 50px rgba(102, 126, 234, 0.6); }
}

@keyframes rocketShake {
    0%, 100% { transform: rotate(-5deg); }
    50% { transform: rotate(5deg); }
}

.auth-header h2 {
    font-size: 32px;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
}

.auth-header p {
    color: #666;
    font-size: 14px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.form-group label i {
    margin-right: 8px;
    color: #667eea;
}

.form-control {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
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

.password-toggle i {
    font-size: 16px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-size: 14px;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #667eea;
}

.btn-primary.btn-full {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    color: white;
    font-weight: 700;
    font-size: 16px;
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

.auth-footer {
    text-align: center;
    margin-top: 25px;
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
    margin-left: 5px;
    transition: transform 0.3s;
}

.auth-footer a:hover i {
    transform: translateX(5px);
}

.alert {
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-error {
    background: linear-gradient(135deg, #fee 0%, #fdd 100%);
    color: #c33;
    border: 1px solid #fcc;
}

/* Demo Login Section */
.demo-login-section {
    margin-bottom: 25px;
    padding: 20px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 16px;
    border: 1px solid rgba(102, 126, 234, 0.2);
}

.demo-title {
    font-size: 14px;
    font-weight: 600;
    color: #667eea;
    margin-bottom: 15px;
    text-align: center;
}

.demo-title i {
    margin-right: 5px;
}

.demo-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.btn-demo {
    padding: 12px 18px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-family: 'Montserrat', sans-serif;
}

.btn-admin {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    box-shadow: 0 5px 20px rgba(240, 147, 251, 0.3);
}

.btn-admin:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(240, 147, 251, 0.5);
}

.btn-customer {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    box-shadow: 0 5px 20px rgba(79, 172, 254, 0.3);
}

.btn-customer:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(79, 172, 254, 0.5);
}

.divider {
    position: relative;
    text-align: center;
    margin: 25px 0;
}

.divider::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 100%;
    height: 1px;
    background: linear-gradient(90deg, transparent, #ddd, transparent);
}

.divider span {
    position: relative;
    background-color: white;
    padding: 0 15px;
    color: #667eea;
    font-size: 14px;
}

@media (max-width: 576px) {
    .auth-card {
        margin: 0 15px;
        padding: 30px 25px;
    }
    
    .planet-1 { width: 80px; height: 80px; }
    .planet-2 { width: 40px; height: 40px; }
    .planet-3 { width: 30px; height: 30px; }
}
</style>
@endpush

@push('scripts')
<script>
function loginAsAdmin() {
    document.getElementById('email').value = 'admin@nexustore.com';
    document.getElementById('password').value = 'admin123';
    document.getElementById('loginForm').submit();
}

function loginAsCustomer() {
    document.getElementById('email').value = 'customer@nexustore.com';
    document.getElementById('password').value = 'customer123';
    document.getElementById('loginForm').submit();
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
</script>
@endpush
@endsection

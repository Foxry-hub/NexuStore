@extends('layouts.app')

@section('title', 'Login - NEXUSTORE')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Login</h2>
                    <p>Masuk ke akun Anda</p>
                </div>

                <!-- Demo Login Buttons -->
                <div class="demo-login-section">
                    <p class="demo-title">Quick Demo Login:</p>
                    <div class="demo-buttons">
                        <button type="button" onclick="loginAsAdmin()" class="btn-demo btn-admin">
                            <i class="fas fa-user-shield"></i> Login as Admin
                        </button>
                        <button type="button" onclick="loginAsCustomer()" class="btn-demo btn-customer">
                            <i class="fas fa-user"></i> Login as Customer
                        </button>
                    </div>
                </div>

                <div class="divider">
                    <span>OR</span>
                </div>

                <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-error">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span>Ingat Saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary btn-full">Login</button>
                </form>

                <div class="auth-footer">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.auth-section {
    padding: 80px 0;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
}

.auth-container {
    max-width: 450px;
    margin: 0 auto;
}

.auth-card {
    background-color: var(--white);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.auth-header {
    text-align: center;
    margin-bottom: 30px;
}

.auth-header h2 {
    font-size: 32px;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.auth-header p {
    color: var(--text-gray);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-dark);
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    transition: border-color 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    cursor: pointer;
}

.btn-full {
    width: 100%;
    margin-top: 10px;
}

.auth-footer {
    text-align: center;
    margin-top: 20px;
}

.auth-footer a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.auth-footer a:hover {
    text-decoration: underline;
}

.alert {
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-error {
    background-color: #fee;
    color: #c33;
    border: 1px solid #fcc;
}

/* Demo Login Section */
.demo-login-section {
    margin-bottom: 25px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    border: 1px solid #e0e0e0;
}

.demo-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 12px;
    text-align: center;
}

.demo-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.btn-demo {
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
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
    background-color: #dc3545;
    color: white;
}

.btn-admin:hover {
    background-color: #c82333;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.btn-customer {
    background-color: #28a745;
    color: white;
}

.btn-customer:hover {
    background-color: #218838;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
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
    background-color: #e0e0e0;
}

.divider span {
    position: relative;
    background-color: white;
    padding: 0 15px;
    color: var(--text-gray);
    font-size: 14px;
    font-weight: 600;
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
</script>
@endpush
@endsection

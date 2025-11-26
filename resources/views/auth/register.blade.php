@extends('layouts.app')

@section('title', 'Register - NEXUSTORE')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Daftar</h2>
                    <p>Buat akun baru Anda</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control">
                    </div>

                    <button type="submit" class="btn-primary btn-full">Daftar</button>
                </form>

                <div class="auth-footer">
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
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
</style>
@endpush
@endsection

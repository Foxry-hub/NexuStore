@extends('layouts.app')

@section('title', 'Checkout - NEXUSTORE')

@section('content')
<section class="checkout-section">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-credit-card"></i> Checkout</h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('keranjang.index') }}">Keranjang</a>
                <span>/</span>
                <span>Checkout</span>
            </nav>
        </div>

        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="checkout-content">
                <div class="checkout-form">
                    <div class="form-section">
                        <h3><i class="fas fa-user"></i> Informasi Penerima</h3>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" value="{{ $user->nama_lengkap }}" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="{{ $user->email }}" readonly class="form-control">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-map-marker-alt"></i> Alamat Pengiriman</h3>
                        <div class="form-group">
                            <label>Alamat Lengkap <span class="required">*</span></label>
                            <textarea name="alamat_kirim" rows="4" class="form-control @error('alamat_kirim') is-invalid @enderror" placeholder="Masukkan alamat lengkap (nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota, kode pos)" required>{{ old('alamat_kirim', $user->alamat) }}</textarea>
                            @error('alamat_kirim')
                            <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-box"></i> Pesanan Anda</h3>
                        <div class="order-items">
                            @foreach($cartItems as $item)
                            <div class="order-item">
                                <img src="{{ $item->buku->gambar_cover ? asset('storage/' . $item->buku->gambar_cover) : 'https://via.placeholder.com/60x80/5B4AB3/ffffff?text=Book' }}" alt="{{ $item->buku->judul }}">
                                <div class="item-details">
                                    <h4>{{ $item->buku->judul }}</h4>
                                    <p>{{ $item->buku->penulis }}</p>
                                </div>
                                <div class="item-qty">x{{ $item->jumlah }}</div>
                                <div class="item-price">Rp {{ number_format($item->buku->harga * $item->jumlah, 0, ',', '.') }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="checkout-summary">
                    <h3>Ringkasan Pesanan</h3>
                    
                    <div class="summary-items">
                        @foreach($cartItems as $item)
                        <div class="summary-item">
                            <span>{{ Str::limit($item->buku->judul, 25) }} x{{ $item->jumlah }}</span>
                            <span>Rp {{ number_format($item->buku->harga * $item->jumlah, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span class="free">GRATIS</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-row total">
                        <span>Total</span>
                        <span class="total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-place-order">
                        <i class="fas fa-lock"></i> Buat Pesanan
                    </button>

                    <p class="secure-note">
                        <i class="fas fa-shield-alt"></i>
                        Transaksi Anda aman dan terenkripsi
                    </p>
                </div>
            </div>
        </form>
    </div>
</section>

@push('styles')
<style>
.checkout-section {
    padding: 40px 0 80px;
    background: #f8f8f8;
    min-height: 70vh;
}

.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.page-header h1 i {
    color: var(--primary-color);
    margin-right: 10px;
}

.page-header .breadcrumb {
    display: flex;
    gap: 8px;
    font-size: 14px;
    color: var(--text-gray);
}

.page-header .breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
}

.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
}

.checkout-content {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 30px;
}

.checkout-form {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.form-section {
    background: white;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.form-section h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-section h3 i {
    color: var(--primary-color);
}

.form-group {
    margin-bottom: 20px;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-dark);
}

.form-group label .required {
    color: #dc3545;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
}

.form-control[readonly] {
    background: #f5f5f5;
    color: var(--text-gray);
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.error-text {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
    display: block;
}

/* Order Items */
.order-items {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f8f8;
    border-radius: 8px;
}

.order-item img {
    width: 60px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
}

.item-details {
    flex: 1;
}

.item-details h4 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 3px;
}

.item-details p {
    font-size: 12px;
    color: var(--text-gray);
}

.item-qty {
    font-weight: 600;
    color: var(--text-gray);
}

.item-price {
    font-weight: 700;
    color: var(--primary-color);
}

/* Checkout Summary */
.checkout-summary {
    background: white;
    border-radius: 10px;
    padding: 25px;
    height: fit-content;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 100px;
}

.checkout-summary h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.summary-items {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 15px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: var(--text-gray);
}

.summary-divider {
    height: 1px;
    background: #eee;
    margin: 15px 0;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 14px;
}

.summary-row .free {
    color: #28a745;
    font-weight: 600;
}

.summary-row.total {
    font-size: 18px;
    font-weight: 700;
    padding-top: 15px;
}

.total-price {
    color: var(--primary-color);
}

.btn-place-order {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 20px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.btn-place-order:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(91, 74, 179, 0.3);
}

.secure-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 15px;
    font-size: 12px;
    color: var(--text-gray);
}

.secure-note i {
    color: #28a745;
}

/* Responsive */
@media (max-width: 992px) {
    .checkout-content {
        grid-template-columns: 1fr;
    }
    
    .checkout-summary {
        position: static;
    }
}
</style>
@endpush
@endsection

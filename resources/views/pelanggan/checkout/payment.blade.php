@extends('layouts.app')

@section('title', 'Pembayaran - NEXUSTORE')

@section('content')
<section class="payment-section">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-wallet"></i> Pembayaran</h1>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        <div class="payment-content">
            <div class="payment-info">
                <div class="order-info-card">
                    <div class="order-header">
                        <h3>Detail Pesanan</h3>
                        <span class="order-id">#{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <div class="order-items">
                        @foreach($pesanan->detailPesanan as $detail)
                        <div class="order-item">
                            <img src="{{ $detail->buku->gambar_cover ? asset('storage/' . $detail->buku->gambar_cover) : 'https://via.placeholder.com/60x80/5B4AB3/ffffff?text=Book' }}" alt="{{ $detail->buku->judul }}">
                            <div class="item-details">
                                <h4>{{ $detail->buku->judul }}</h4>
                                <p>{{ $detail->buku->penulis }}</p>
                            </div>
                            <div class="item-qty">x{{ $detail->jumlah }}</div>
                            <div class="item-price">Rp {{ number_format($detail->total, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="order-total">
                        <span>Total Pembayaran</span>
                        <span class="total-amount">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="shipping-info-card">
                    <h3><i class="fas fa-truck"></i> Alamat Pengiriman</h3>
                    <p>{{ $pesanan->alamat_kirim }}</p>
                </div>
            </div>

            <div class="payment-methods">
                <h3>Pilih Metode Pembayaran</h3>
                
                <form action="{{ route('pembayaran.process', $pesanan->id_pesanan) }}" method="POST">
                    @csrf
                    
                    <div class="payment-options">
                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="transfer_bank" required>
                            <div class="option-content">
                                <div class="option-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="option-details">
                                    <h4>Transfer Bank</h4>
                                    <p>BCA, BNI, BRI, Mandiri</p>
                                </div>
                            </div>
                        </label>

                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="e_wallet" required>
                            <div class="option-content">
                                <div class="option-icon">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="option-details">
                                    <h4>E-Wallet</h4>
                                    <p>GoPay, OVO, DANA, ShopeePay</p>
                                </div>
                            </div>
                        </label>

                        <label class="payment-option">
                            <input type="radio" name="metode_pembayaran" value="cod" required>
                            <div class="option-content">
                                <div class="option-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="option-details">
                                    <h4>COD (Bayar di Tempat)</h4>
                                    <p>Bayar saat barang diterima</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="payment-actions">
                        <button type="submit" class="btn-pay">
                            <i class="fas fa-lock"></i> Bayar Sekarang
                        </button>
                        <a href="{{ route('pesanan.index') }}" class="btn-later">
                            Bayar Nanti
                        </a>
                    </div>
                </form>

                <div class="payment-note">
                    <i class="fas fa-info-circle"></i>
                    <p>Selesaikan pembayaran dalam waktu <strong>24 jam</strong> atau pesanan akan otomatis dibatalkan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.payment-section {
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
}

.page-header h1 i {
    color: var(--primary-color);
    margin-right: 10px;
}

.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
}

.payment-content {
    display: grid;
    grid-template-columns: 1fr 450px;
    gap: 30px;
}

.payment-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.order-info-card, .shipping-info-card {
    background: white;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.order-header h3 {
    font-size: 18px;
    font-weight: 700;
}

.order-id {
    font-family: monospace;
    background: var(--light-color);
    color: var(--primary-color);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.order-items {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 20px;
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

.order-total {
    display: flex;
    justify-content: space-between;
    padding-top: 20px;
    border-top: 2px solid #eee;
    font-size: 18px;
    font-weight: 700;
}

.total-amount {
    color: var(--primary-color);
}

.shipping-info-card h3 {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.shipping-info-card h3 i {
    color: var(--primary-color);
}

.shipping-info-card p {
    color: var(--text-gray);
    line-height: 1.6;
}

/* Payment Methods */
.payment-methods {
    background: white;
    border-radius: 10px;
    padding: 25px;
    height: fit-content;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.payment-methods h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
}

.payment-options {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 25px;
}

.payment-option {
    cursor: pointer;
}

.payment-option input {
    display: none;
}

.option-content {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 18px;
    border: 2px solid #eee;
    border-radius: 10px;
    transition: all 0.2s;
}

.payment-option input:checked + .option-content {
    border-color: var(--primary-color);
    background: var(--light-color);
}

.option-icon {
    width: 50px;
    height: 50px;
    background: #f5f5f5;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: var(--primary-color);
}

.payment-option input:checked + .option-content .option-icon {
    background: var(--primary-color);
    color: white;
}

.option-details h4 {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 3px;
}

.option-details p {
    font-size: 12px;
    color: var(--text-gray);
}

.payment-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.btn-pay {
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
    transition: transform 0.2s, box-shadow 0.2s;
}

.btn-pay:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(91, 74, 179, 0.3);
}

.btn-later {
    display: block;
    text-align: center;
    padding: 12px;
    color: var(--text-gray);
    text-decoration: none;
    font-size: 14px;
}

.btn-later:hover {
    color: var(--primary-color);
}

.payment-note {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    padding: 15px;
    background: #fff3cd;
    border-radius: 8px;
    font-size: 13px;
    color: #856404;
}

.payment-note i {
    font-size: 16px;
    margin-top: 2px;
}

/* Responsive */
@media (max-width: 992px) {
    .payment-content {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
@endsection

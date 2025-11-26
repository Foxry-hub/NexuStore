@extends('layouts.app')

@section('title', 'Pesanan Saya - NEXUSTORE')

@section('content')
<section class="orders-section">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-box"></i> Pesanan Saya</h1>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        @if($pesanans->count() > 0)
        <div class="orders-list">
            @foreach($pesanans as $pesanan)
            <div class="order-card {{ $pesanan->status_pengiriman === 'dikirim' ? 'shipping' : '' }}">
                <div class="order-header">
                    <div class="order-info">
                        <span class="order-id">{{ $pesanan->kode_pesanan }}</span>
                        <span class="order-date">{{ $pesanan->tanggal_pesanan->format('d M Y') }}</span>
                    </div>
                    <div class="order-status">
                        <span class="status-badge status-{{ $pesanan->status_pembayaran }}">
                            {{ $pesanan->status_pembayaran_label }}
                        </span>
                        <span class="status-badge status-{{ $pesanan->status_pengiriman }}">
                            {{ $pesanan->status_pengiriman_label }}
                        </span>
                    </div>
                </div>

                @if($pesanan->status_pengiriman === 'dikirim' && $pesanan->no_resi)
                <div class="shipping-notice">
                    <div class="notice-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="notice-content">
                        <span class="notice-title">Paket sedang dikirim!</span>
                        <span class="notice-resi">{{ strtoupper($pesanan->kurir) }}: {{ $pesanan->no_resi }}</span>
                    </div>
                    @if($pesanan->tracking_url)
                    <a href="{{ $pesanan->tracking_url }}" target="_blank" class="btn-track-mini">
                        <i class="fas fa-map-marker-alt"></i> Lacak
                    </a>
                    @endif
                </div>
                @endif

                <div class="order-items">
                    @foreach($pesanan->detailPesanan->take(2) as $detail)
                    <div class="order-item">
                        <img src="{{ $detail->buku->gambar_cover ? asset('storage/' . $detail->buku->gambar_cover) : 'https://via.placeholder.com/50x65/5B4AB3/ffffff?text=Book' }}" alt="">
                        <div class="item-info">
                            <h4>{{ $detail->buku->judul }}</h4>
                            <p>{{ $detail->jumlah }} x Rp {{ number_format($detail->total / $detail->jumlah, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                    @if($pesanan->detailPesanan->count() > 2)
                    <div class="more-items">
                        +{{ $pesanan->detailPesanan->count() - 2 }} produk lainnya
                    </div>
                    @endif
                </div>

                <div class="order-footer">
                    <div class="order-total">
                        <span>Total Pesanan:</span>
                        <span class="total-amount">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="order-actions">
                        @if($pesanan->status_pembayaran === 'belum_bayar')
                        <a href="{{ route('pembayaran.show', $pesanan->id_pesanan) }}" class="btn-pay-now">
                            <i class="fas fa-credit-card"></i> Bayar
                        </a>
                        <form action="{{ route('pesanan.cancel', $pesanan->id_pesanan) }}" method="POST" style="display: inline;" onsubmit="return confirm('Batalkan pesanan ini?')">
                            @csrf
                            <button type="submit" class="btn-cancel">Batalkan</button>
                        </form>
                        @endif
                        @if($pesanan->status_pengiriman === 'dikirim')
                        <form action="{{ route('pesanan.confirm', $pesanan->id_pesanan) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-confirm">
                                <i class="fas fa-check"></i> Terima Pesanan
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('pesanan.show', $pesanan->id_pesanan) }}" class="btn-detail">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($pesanans->hasPages())
        <div class="pagination-wrapper">
            {{ $pesanans->links('vendor.pagination.custom') }}
        </div>
        @endif
        @else
        <div class="empty-orders">
            <i class="fas fa-box-open"></i>
            <h2>Belum Ada Pesanan</h2>
            <p>Anda belum memiliki pesanan. Mulai belanja sekarang!</p>
            <a href="{{ route('shop.index') }}" class="btn-shop">
                <i class="fas fa-store"></i> Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
.orders-section {
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

.alert-error {
    background: #f8d7da;
    color: #721c24;
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.order-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.order-card.shipping {
    border: 2px solid #4caf50;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: #f8f8f8;
    border-bottom: 1px solid #eee;
}

/* Shipping Notice */
.shipping-notice {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 20px;
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border-bottom: 1px solid #a5d6a7;
}

.shipping-notice .notice-icon {
    width: 40px;
    height: 40px;
    background: #4caf50;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.shipping-notice .notice-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.shipping-notice .notice-title {
    font-weight: 600;
    color: #2e7d32;
    font-size: 14px;
}

.shipping-notice .notice-resi {
    font-family: monospace;
    font-size: 13px;
    color: #388e3c;
}

.btn-track-mini {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 8px 15px;
    background: #4caf50;
    color: white;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}

.btn-track-mini:hover {
    background: #388e3c;
}

.order-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.order-id {
    font-family: monospace;
    font-weight: 700;
    color: var(--primary-color);
}

.order-date {
    color: var(--text-gray);
    font-size: 14px;
}

.order-status {
    display: flex;
    gap: 10px;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-belum_bayar {
    background: #fff3cd;
    color: #856404;
}

.status-sudah_bayar {
    background: #d4edda;
    color: #155724;
}

.status-dibatalkan {
    background: #f8d7da;
    color: #721c24;
}

.status-diproses {
    background: #cce5ff;
    color: #004085;
}

.status-dikirim {
    background: #d4edda;
    color: #155724;
}

.status-selesai {
    background: #d4edda;
    color: #155724;
}

.order-items {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.order-item img {
    width: 50px;
    height: 65px;
    object-fit: cover;
    border-radius: 5px;
}

.item-info h4 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 3px;
}

.item-info p {
    font-size: 13px;
    color: var(--text-gray);
}

.more-items {
    font-size: 13px;
    color: var(--primary-color);
    font-weight: 500;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: #fafafa;
    border-top: 1px solid #eee;
}

.order-total {
    display: flex;
    align-items: center;
    gap: 10px;
}

.order-total span:first-child {
    color: var(--text-gray);
    font-size: 14px;
}

.total-amount {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-color);
}

.order-actions {
    display: flex;
    gap: 10px;
}

.btn-pay-now {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 10px 20px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}

.btn-pay-now:hover {
    background: var(--secondary-color);
}

.btn-cancel {
    padding: 10px 15px;
    background: transparent;
    color: #dc3545;
    border: 1px solid #dc3545;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #dc3545;
    color: white;
}

.btn-confirm {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 10px 15px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-confirm:hover {
    background: #218838;
}

.btn-detail {
    padding: 10px 20px;
    background: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
    border-radius: 8px;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-detail:hover {
    background: var(--light-color);
}

/* Pagination */
.pagination-wrapper {
    margin-top: 30px;
    padding: 20px;
    display: flex;
    justify-content: center;
    background: white;
    border-radius: 10px;
}

/* Empty Orders */
.empty-orders {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 10px;
}

.empty-orders i {
    font-size: 80px;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-orders h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.empty-orders p {
    color: var(--text-gray);
    margin-bottom: 25px;
}

.btn-shop {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
    .order-header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
    
    .order-footer {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .order-actions {
        flex-wrap: wrap;
    }
}
</style>
@endpush
@endsection

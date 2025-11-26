@extends('layouts.app')

@section('title', 'Detail Pesanan - NEXUSTORE')

@section('content')
<section class="order-detail-section">
    <div class="container">
        <div class="page-header">
            <a href="{{ route('pesanan.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Pesanan
            </a>
            <h1>Detail Pesanan {{ $pesanan->kode_pesanan }}</h1>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('info'))
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> {{ session('info') }}
        </div>
        @endif

        <div class="order-detail-content">
            <div class="order-main">
                <!-- Order Status -->
                <div class="status-card">
                    <h3>Status Pesanan</h3>
                    <div class="status-timeline">
                        <div class="timeline-item completed">
                            <div class="timeline-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Pesanan Dibuat</h4>
                                <p>{{ $pesanan->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="timeline-item {{ $pesanan->waktu_bayar ? 'completed' : ($pesanan->status_pembayaran === 'dibatalkan' ? 'cancelled' : 'pending') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Pembayaran</h4>
                                @if($pesanan->waktu_bayar)
                                    <p class="success-text">Dibayar pada {{ $pesanan->waktu_bayar->format('d M Y, H:i') }}</p>
                                @elseif($pesanan->status_pembayaran === 'dibatalkan')
                                    <p class="error-text">Dibatalkan</p>
                                @else
                                    <p class="warning-text">Menunggu pembayaran</p>
                                @endif
                            </div>
                        </div>

                        <div class="timeline-item {{ $pesanan->waktu_kirim ? 'completed' : ($pesanan->status_pengiriman === 'dibatalkan' ? 'cancelled' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Pengiriman</h4>
                                @if($pesanan->waktu_kirim)
                                    <p class="success-text">Dikirim pada {{ $pesanan->waktu_kirim->format('d M Y, H:i') }}</p>
                                    @if($pesanan->kurir && $pesanan->no_resi)
                                        <div class="resi-box">
                                            <span class="kurir">{{ strtoupper($pesanan->kurir) }}</span>
                                            <span class="resi-number">{{ $pesanan->no_resi }}</span>
                                            @if($pesanan->tracking_url)
                                                <a href="{{ $pesanan->tracking_url }}" target="_blank" class="track-btn">
                                                    <i class="fas fa-external-link-alt"></i> Lacak
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                @elseif($pesanan->status_pengiriman === 'dibatalkan')
                                    <p class="error-text">Dibatalkan</p>
                                @else
                                    <p>Menunggu pengiriman</p>
                                @endif
                            </div>
                        </div>

                        <div class="timeline-item {{ $pesanan->waktu_selesai ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h4>Selesai</h4>
                                @if($pesanan->waktu_selesai)
                                    <p class="success-text">Diterima pada {{ $pesanan->waktu_selesai->format('d M Y, H:i') }}</p>
                                @elseif($pesanan->status_pengiriman === 'dikirim')
                                    <p class="info-text">Paket sedang dalam perjalanan, silakan konfirmasi setelah menerima</p>
                                @else
                                    <p>Menunggu konfirmasi penerimaan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tracking Info (if shipped) -->
                @if($pesanan->status_pengiriman === 'dikirim' && $pesanan->no_resi)
                <div class="tracking-card">
                    <div class="tracking-header">
                        <i class="fas fa-shipping-fast"></i>
                        <div>
                            <h3>Paket Sedang Dikirim</h3>
                            <p>Pesanan Anda sedang dalam perjalanan menuju alamat tujuan</p>
                        </div>
                    </div>
                    <div class="tracking-details">
                        <div class="tracking-item">
                            <span class="label">Kurir</span>
                            <span class="value">{{ strtoupper($pesanan->kurir) }}</span>
                        </div>
                        <div class="tracking-item">
                            <span class="label">No. Resi</span>
                            <span class="value resi">{{ $pesanan->no_resi }}</span>
                        </div>
                        <div class="tracking-item">
                            <span class="label">Waktu Kirim</span>
                            <span class="value">{{ $pesanan->waktu_kirim->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    @if($pesanan->tracking_url)
                    <a href="{{ $pesanan->tracking_url }}" target="_blank" class="btn-track">
                        <i class="fas fa-map-marker-alt"></i> Lacak Paket di Website {{ strtoupper($pesanan->kurir) }}
                    </a>
                    @endif
                </div>
                @endif

                <!-- Order Items -->
                <div class="items-card">
                    <h3>Produk Dipesan</h3>
                    <div class="items-list">
                        @foreach($pesanan->detailPesanan as $detail)
                        <div class="item-row">
                            <img src="{{ $detail->buku->gambar_cover ? asset('storage/' . $detail->buku->gambar_cover) : 'https://via.placeholder.com/70x90/5B4AB3/ffffff?text=Book' }}" alt="{{ $detail->buku->judul }}">
                            <div class="item-info">
                                <h4>{{ $detail->buku->judul }}</h4>
                                <p>{{ $detail->buku->penulis }}</p>
                                <span class="item-qty">{{ $detail->jumlah }} x Rp {{ number_format($detail->total / $detail->jumlah, 0, ',', '.') }}</span>
                                
                                @if($pesanan->status_pengiriman === 'selesai')
                                    @php
                                        $hasReviewed = \App\Models\Review::where('id_user', Auth::id())
                                            ->where('id_buku', $detail->buku->id_buku)
                                            ->where('id_pesanan', $pesanan->id_pesanan)
                                            ->exists();
                                    @endphp
                                    @if($hasReviewed)
                                        <span class="reviewed-badge">
                                            <i class="fas fa-check-circle"></i> Sudah diulas
                                        </span>
                                    @else
                                        <a href="{{ route('review.create', ['buku' => $detail->buku->id_buku, 'pesanan' => $pesanan->id_pesanan]) }}" class="btn-review-item">
                                            <i class="fas fa-star"></i> Beri Ulasan
                                        </a>
                                    @endif
                                @endif
                            </div>
                            <div class="item-subtotal">
                                Rp {{ number_format($detail->total, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="address-card">
                    <h3><i class="fas fa-map-marker-alt"></i> Alamat Pengiriman</h3>
                    <p>{{ $pesanan->alamat_kirim }}</p>
                </div>
            </div>

            <div class="order-sidebar">
                <!-- Order Summary -->
                <div class="summary-card">
                    <h3>Ringkasan Pembayaran</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal ({{ $pesanan->detailPesanan->sum('jumlah') }} item)</span>
                        <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span class="free">Gratis</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-status">
                        <div class="status-item">
                            <span>Status Pembayaran:</span>
                            <span class="status-badge status-{{ $pesanan->status_pembayaran }}">
                                {{ $pesanan->status_pembayaran_label }}
                            </span>
                        </div>
                        <div class="status-item">
                            <span>Status Pengiriman:</span>
                            <span class="status-badge status-{{ $pesanan->status_pengiriman }}">
                                {{ $pesanan->status_pengiriman_label }}
                            </span>
                        </div>
                    </div>

                    @if($pesanan->status_pembayaran === 'belum_bayar')
                    <a href="{{ route('pembayaran.show', $pesanan->id_pesanan) }}" class="btn-pay">
                        <i class="fas fa-credit-card"></i> Bayar Sekarang
                    </a>
                    <form action="{{ route('pesanan.cancel', $pesanan->id_pesanan) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?')">
                        @csrf
                        <button type="submit" class="btn-cancel">
                            Batalkan Pesanan
                        </button>
                    </form>
                    @endif

                    @if($pesanan->status_pengiriman === 'dikirim')
                    <div class="confirm-notice">
                        <i class="fas fa-box"></i>
                        <p>Sudah menerima paket? Konfirmasi penerimaan untuk menyelesaikan pesanan.</p>
                    </div>
                    <form action="{{ route('pesanan.confirm', $pesanan->id_pesanan) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-confirm">
                            <i class="fas fa-check"></i> Konfirmasi Terima Pesanan
                        </button>
                    </form>
                    @endif

                    @if($pesanan->status_pengiriman === 'selesai')
                    <div class="completed-notice">
                        <i class="fas fa-check-circle"></i>
                        <p>Pesanan telah selesai. Terima kasih telah berbelanja di NEXUSTORE!</p>
                    </div>
                    
                    @php
                        $unreviewedBooks = $pesanan->detailPesanan->filter(function($detail) use ($pesanan) {
                            return !\App\Models\Review::where('id_user', Auth::id())
                                ->where('id_buku', $detail->buku->id_buku)
                                ->where('id_pesanan', $pesanan->id_pesanan)
                                ->exists();
                        });
                    @endphp
                    
                    @if($unreviewedBooks->count() > 0)
                    <div class="review-notice">
                        <i class="fas fa-star"></i>
                        <p>Bagikan pengalaman Anda! Ada {{ $unreviewedBooks->count() }} buku yang belum diulas.</p>
                    </div>
                    @endif
                    @endif
                </div>

                <!-- Order Info -->
                <div class="info-card">
                    <h3>Informasi Pesanan</h3>
                    <div class="info-row">
                        <span>No. Pesanan</span>
                        <span class="order-code">{{ $pesanan->kode_pesanan }}</span>
                    </div>
                    <div class="info-row">
                        <span>Tanggal Pesanan</span>
                        <span>{{ $pesanan->tanggal_pesanan->format('d M Y') }}</span>
                    </div>
                    @if($pesanan->kurir)
                    <div class="info-row">
                        <span>Kurir</span>
                        <span>{{ strtoupper($pesanan->kurir) }}</span>
                    </div>
                    @endif
                    @if($pesanan->no_resi)
                    <div class="info-row">
                        <span>No. Resi</span>
                        <span class="resi-code">{{ $pesanan->no_resi }}</span>
                    </div>
                    @endif
                </div>

                <!-- Help Card -->
                <div class="help-card">
                    <h3><i class="fas fa-question-circle"></i> Butuh Bantuan?</h3>
                    <p>Jika ada pertanyaan tentang pesanan, silakan hubungi customer service kami.</p>
                    <a href="mailto:support@nexustore.com" class="btn-help">
                        <i class="fas fa-envelope"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.order-detail-section {
    padding: 40px 0 80px;
    background: #f8f8f8;
    min-height: 70vh;
}

.page-header {
    margin-bottom: 30px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary-color);
    text-decoration: none;
    font-size: 14px;
    margin-bottom: 15px;
}

.back-link:hover {
    text-decoration: underline;
}

.page-header h1 {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-dark);
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

.alert-info {
    background: #cce5ff;
    color: #004085;
}

.order-detail-content {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 30px;
}

.order-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.status-card, .items-card, .address-card, .summary-card, .info-card, .help-card, .tracking-card {
    background: white;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.status-card h3, .items-card h3, .address-card h3, .summary-card h3, .info-card h3, .help-card h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* Status Timeline */
.status-timeline {
    display: flex;
    justify-content: space-between;
    position: relative;
}

.status-timeline::before {
    content: '';
    position: absolute;
    top: 25px;
    left: 50px;
    right: 50px;
    height: 3px;
    background: #eee;
}

.timeline-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    flex: 1;
    position: relative;
    z-index: 1;
}

.timeline-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #999;
    margin-bottom: 15px;
}

.timeline-item.completed .timeline-icon {
    background: var(--primary-color);
    color: white;
}

.timeline-item.cancelled .timeline-icon {
    background: #dc3545;
    color: white;
}

.timeline-item.pending .timeline-icon {
    background: #ffc107;
    color: #333;
}

.timeline-content h4 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
}

.timeline-content p {
    font-size: 12px;
    color: var(--text-gray);
}

.timeline-content .success-text { color: #28a745; }
.timeline-content .warning-text { color: #856404; }
.timeline-content .error-text { color: #dc3545; }
.timeline-content .info-text { color: #0c5460; font-size: 11px; }

/* Resi Box in Timeline */
.resi-box {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 8px;
    font-size: 12px;
}

.resi-box .kurir {
    background: var(--primary-color);
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-weight: 600;
}

.resi-box .resi-number {
    font-family: monospace;
    font-weight: 600;
}

.resi-box .track-btn {
    margin-left: auto;
    color: var(--primary-color);
    text-decoration: none;
    font-size: 11px;
}

/* Tracking Card */
.tracking-card {
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border: 2px solid #4caf50;
}

.tracking-header {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.tracking-header i {
    font-size: 40px;
    color: #4caf50;
}

.tracking-header h3 {
    font-size: 18px;
    margin-bottom: 5px;
    color: #2e7d32;
}

.tracking-header p {
    font-size: 14px;
    color: #388e3c;
}

.tracking-details {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.tracking-item {
    background: white;
    padding: 12px 15px;
    border-radius: 8px;
}

.tracking-item .label {
    display: block;
    font-size: 11px;
    color: var(--text-gray);
    margin-bottom: 5px;
    text-transform: uppercase;
}

.tracking-item .value {
    font-size: 14px;
    font-weight: 600;
}

.tracking-item .value.resi {
    font-family: monospace;
    color: var(--primary-color);
}

.btn-track {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 12px;
    background: #4caf50;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}

.btn-track:hover {
    background: #388e3c;
}

/* Items List */
.items-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.item-row {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f8f8;
    border-radius: 8px;
}

.item-row img {
    width: 70px;
    height: 90px;
    object-fit: cover;
    border-radius: 5px;
}

.item-info {
    flex: 1;
}

.item-info h4 {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 5px;
}

.item-info p {
    font-size: 13px;
    color: var(--text-gray);
    margin-bottom: 5px;
}

.item-qty {
    font-size: 13px;
    color: var(--text-gray);
}

.btn-review-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    background: linear-gradient(135deg, #FFA500, #FF8C00);
    color: white;
    text-decoration: none;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-top: 8px;
    transition: all 0.2s;
}

.btn-review-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(255, 165, 0, 0.4);
}

.reviewed-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    background: #d4edda;
    color: #155724;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-top: 8px;
}

.item-subtotal {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary-color);
}

/* Address Card */
.address-card h3 {
    display: flex;
    align-items: center;
    gap: 10px;
}

.address-card h3 i {
    color: var(--primary-color);
}

.address-card p {
    color: var(--text-gray);
    line-height: 1.6;
}

/* Summary Card */
.order-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 14px;
}

.summary-row .free {
    color: #28a745;
    font-weight: 600;
}

.summary-divider {
    height: 1px;
    background: #eee;
    margin: 10px 0;
}

.summary-row.total {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-color);
}

.summary-status {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 14px;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-belum_bayar { background: #fff3cd; color: #856404; }
.status-sudah_bayar { background: #d4edda; color: #155724; }
.status-dibatalkan { background: #f8d7da; color: #721c24; }
.status-diproses { background: #cce5ff; color: #004085; }
.status-dikirim { background: #d1ecf1; color: #0c5460; }
.status-selesai { background: #d4edda; color: #155724; }

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
    text-decoration: none;
    margin-top: 20px;
    transition: transform 0.2s;
}

.btn-pay:hover {
    transform: translateY(-2px);
}

.btn-cancel {
    width: 100%;
    padding: 12px;
    background: transparent;
    color: #dc3545;
    border: 1px solid #dc3545;
    border-radius: 10px;
    font-size: 14px;
    cursor: pointer;
    margin-top: 10px;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #dc3545;
    color: white;
}

.confirm-notice {
    display: flex;
    gap: 12px;
    padding: 15px;
    background: #e3f2fd;
    border-radius: 10px;
    margin-top: 20px;
    color: #1565c0;
}

.confirm-notice i {
    font-size: 24px;
}

.confirm-notice p {
    font-size: 13px;
    line-height: 1.5;
}

.btn-confirm {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 15px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 15px;
}

.btn-confirm:hover {
    background: #218838;
}

.completed-notice {
    display: flex;
    gap: 12px;
    padding: 15px;
    background: #d4edda;
    border-radius: 10px;
    margin-top: 20px;
    color: #155724;
}

.completed-notice i {
    font-size: 24px;
}

.completed-notice p {
    font-size: 13px;
    line-height: 1.5;
}

.review-notice {
    display: flex;
    gap: 12px;
    padding: 15px;
    background: linear-gradient(135deg, #fff8e1, #ffecb3);
    border-radius: 10px;
    margin-top: 15px;
    color: #ff8f00;
    border: 1px solid #ffc107;
}

.review-notice i {
    font-size: 24px;
}

.review-notice p {
    font-size: 13px;
    line-height: 1.5;
}

/* Info Card */
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 14px;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.order-code {
    font-family: monospace;
    font-weight: 700;
    color: var(--primary-color);
}

.resi-code {
    font-family: monospace;
    font-weight: 600;
    color: var(--primary-color);
}

/* Help Card */
.help-card h3 {
    display: flex;
    align-items: center;
    gap: 10px;
}

.help-card h3 i {
    color: var(--primary-color);
}

.help-card p {
    font-size: 14px;
    color: var(--text-gray);
    margin-bottom: 15px;
}

.btn-help {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 12px;
    background: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
    border-radius: 8px;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-help:hover {
    background: var(--light-color);
}

/* Responsive */
@media (max-width: 992px) {
    .order-detail-content {
        grid-template-columns: 1fr;
    }
    
    .status-timeline {
        flex-direction: column;
        gap: 20px;
    }
    
    .status-timeline::before {
        display: none;
    }
    
    .timeline-item {
        flex-direction: row;
        text-align: left;
        gap: 15px;
    }
    
    .tracking-details {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
@endsection

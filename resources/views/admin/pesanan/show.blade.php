@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="content-header">
    <div class="header-left">
        <a href="{{ route('admin.pesanan.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1>Detail Pesanan {{ $order->kode_pesanan }}</h1>
            <p>Dibuat pada {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
</div>
@endif

<div class="order-detail-grid">
    <!-- Left Column -->
    <div class="order-main">
        <!-- Order Status Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Status Pesanan</h3>
            </div>
            <div class="card-body">
                <div class="status-badges">
                    <div class="status-item">
                        <span class="label">Pembayaran:</span>
                        <span class="badge badge-{{ $order->status_pembayaran }}">
                            {{ $order->status_pembayaran_label }}
                        </span>
                    </div>
                    <div class="status-item">
                        <span class="label">Pengiriman:</span>
                        <span class="badge badge-{{ $order->status_pengiriman }}">
                            {{ $order->status_pengiriman_label }}
                        </span>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="order-timeline">
                    <div class="timeline-item {{ $order->created_at ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Pesanan Dibuat</h4>
                            <p>{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="timeline-item {{ $order->waktu_bayar ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Pembayaran</h4>
                            <p>{{ $order->waktu_bayar ? $order->waktu_bayar->format('d M Y, H:i') : 'Menunggu pembayaran' }}</p>
                        </div>
                    </div>
                    <div class="timeline-item {{ $order->waktu_kirim ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Dikirim</h4>
                            @if($order->waktu_kirim)
                                <p>{{ $order->waktu_kirim->format('d M Y, H:i') }}</p>
                                @if($order->kurir && $order->no_resi)
                                    <p class="resi-info">{{ strtoupper($order->kurir) }}: {{ $order->no_resi }}</p>
                                @endif
                            @else
                                <p>Menunggu pengiriman</p>
                            @endif
                        </div>
                    </div>
                    <div class="timeline-item {{ $order->waktu_selesai ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Selesai</h4>
                            <p>{{ $order->waktu_selesai ? $order->waktu_selesai->format('d M Y, H:i') : 'Menunggu konfirmasi pelanggan' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-box"></i> Produk Dipesan</h3>
            </div>
            <div class="card-body">
                <div class="order-items">
                    @foreach($order->detailPesanan as $detail)
                    <div class="order-item">
                        <img src="{{ $detail->buku->gambar_cover ? asset('storage/' . $detail->buku->gambar_cover) : 'https://via.placeholder.com/60x80/5B4AB3/ffffff?text=Book' }}" alt="{{ $detail->buku->judul }}">
                        <div class="item-info">
                            <h4>{{ $detail->buku->judul }}</h4>
                            <p>{{ $detail->buku->penulis }}</p>
                            <span class="item-qty">{{ $detail->jumlah }} x Rp {{ number_format($detail->total / $detail->jumlah, 0, ',', '.') }}</span>
                        </div>
                        <div class="item-total">
                            Rp {{ number_format($detail->total, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="order-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span>Gratis</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer & Shipping Info -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-user"></i> Informasi Pelanggan</h3>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="label">Nama</span>
                        <span class="value">{{ $order->user->nama_lengkap }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Email</span>
                        <span class="value">{{ $order->user->email }}</span>
                    </div>
                    <div class="info-item full">
                        <span class="label">Alamat Pengiriman</span>
                        <span class="value">{{ $order->alamat_kirim }}</span>
                    </div>
                </div>

                @if($order->catatan_admin)
                <div class="admin-notes-display">
                    <div class="notes-header">
                        <i class="fas fa-sticky-note"></i>
                        <span>Catatan Admin</span>
                    </div>
                    <div class="notes-content">
                        {{ $order->catatan_admin }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column - Actions -->
    <div class="order-sidebar">
        <!-- Update Status -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-edit"></i> Update Status</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pesanan.updateStatus', $order->id_pesanan) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-group">
                        <label>Status Pembayaran</label>
                        <select name="status_pembayaran" class="form-control">
                            <option value="">-- Tidak diubah --</option>
                            <option value="belum_bayar" {{ $order->status_pembayaran == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="sudah_bayar" {{ $order->status_pembayaran == 'sudah_bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                            <option value="dibatalkan" {{ $order->status_pembayaran == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status Pengiriman</label>
                        <select name="status_pengiriman" class="form-control">
                            <option value="">-- Tidak diubah --</option>
                            <option value="diproses" {{ $order->status_pengiriman == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $order->status_pengiriman == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $order->status_pengiriman == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <small class="form-hint">* Untuk mengirim pesanan, gunakan form "Kirim Pesanan" di bawah</small>
                    </div>

                    <div class="form-group">
                        <label>Catatan Admin</label>
                        <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Catatan internal...">{{ $order->catatan_admin }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Ship Order -->
        @if($order->status_pembayaran === 'sudah_bayar' && $order->status_pengiriman === 'diproses')
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-truck"></i> Kirim Pesanan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pesanan.ship', $order->id_pesanan) }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label>Kurir <span class="required">*</span></label>
                        <select name="kurir" class="form-control" required>
                            <option value="">Pilih Kurir</option>
                            <option value="jne">JNE</option>
                            <option value="jnt">J&T Express</option>
                            <option value="sicepat">SiCepat</option>
                            <option value="anteraja">AnterAja</option>
                            <option value="pos">POS Indonesia</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nomor Resi <span class="required">*</span></label>
                        <input type="text" name="no_resi" class="form-control" placeholder="Masukkan nomor resi" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-shipping-fast"></i> Kirim Pesanan
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Tracking Info (if shipped) -->
        @if($order->no_resi && $order->kurir)
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-map-marker-alt"></i> Info Pengiriman</h3>
            </div>
            <div class="card-body">
                <div class="tracking-info">
                    <div class="info-row">
                        <span class="label">Kurir:</span>
                        <span class="value">{{ strtoupper($order->kurir) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">No. Resi:</span>
                        <span class="value resi">{{ $order->no_resi }}</span>
                    </div>
                    @if($order->waktu_kirim)
                    <div class="info-row">
                        <span class="label">Waktu Kirim:</span>
                        <span class="value">{{ $order->waktu_kirim->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                </div>
                @if($order->tracking_url)
                <a href="{{ $order->tracking_url }}" target="_blank" class="btn btn-outline btn-block mt-3">
                    <i class="fas fa-external-link-alt"></i> Lacak di Website Kurir
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.content-header {
    margin-bottom: 25px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.btn-back {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-dark);
    text-decoration: none;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.content-header h1 {
    font-size: 24px;
    margin-bottom: 5px;
}

.content-header p {
    color: var(--text-gray);
    font-size: 14px;
}

.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success { background: #d4edda; color: #155724; }
.alert-danger { background: #f8d7da; color: #721c24; }

.order-detail-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 25px;
}

.order-main {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.order-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.card-header {
    padding: 18px 22px;
    border-bottom: 1px solid #eee;
}

.card-header h3 {
    font-size: 16px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-header h3 i {
    color: var(--primary-color);
}

.card-body {
    padding: 22px;
}

/* Status Badges */
.status-badges {
    display: flex;
    gap: 20px;
    margin-bottom: 25px;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.status-item .label {
    font-size: 14px;
    color: var(--text-gray);
}

.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-belum_bayar { background: #fff3cd; color: #856404; }
.badge-sudah_bayar { background: #d4edda; color: #155724; }
.badge-dibatalkan { background: #f8d7da; color: #721c24; }
.badge-diproses { background: #cce5ff; color: #004085; }
.badge-dikirim { background: #d1ecf1; color: #0c5460; }
.badge-selesai { background: #d4edda; color: #155724; }

/* Timeline */
.order-timeline {
    position: relative;
    padding-left: 30px;
}

.order-timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e0e0e0;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #e0e0e0;
    border: 3px solid white;
}

.timeline-item.completed .timeline-marker {
    background: var(--primary-color);
}

.timeline-content h4 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 3px;
}

.timeline-content p {
    font-size: 13px;
    color: var(--text-gray);
}

.timeline-content .resi-info {
    font-family: monospace;
    background: #f5f5f5;
    padding: 5px 10px;
    border-radius: 5px;
    margin-top: 5px;
    display: inline-block;
}

/* Order Items */
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
    background: #f8f9fa;
    border-radius: 10px;
}

.order-item img {
    width: 60px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
}

.item-info {
    flex: 1;
}

.item-info h4 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 3px;
}

.item-info p {
    font-size: 12px;
    color: var(--text-gray);
    margin-bottom: 5px;
}

.item-qty {
    font-size: 13px;
    color: var(--text-gray);
}

.item-total {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary-color);
}

.order-summary {
    border-top: 1px solid #eee;
    padding-top: 15px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    font-size: 14px;
}

.summary-row.total {
    border-top: 2px solid #eee;
    margin-top: 10px;
    padding-top: 15px;
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-color);
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.info-item.full {
    grid-column: 1 / -1;
}

.info-item .label {
    font-size: 12px;
    color: var(--text-gray);
    text-transform: uppercase;
}

.info-item .value {
    font-size: 14px;
    font-weight: 500;
}

/* Admin Notes Display */
.admin-notes-display {
    margin-top: 20px;
    padding: 15px;
    background: #fff8e6;
    border: 1px solid #ffe0a3;
    border-radius: 10px;
}

.admin-notes-display .notes-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #856404;
    margin-bottom: 8px;
}

.admin-notes-display .notes-content {
    font-size: 14px;
    color: #5a4a03;
    line-height: 1.5;
}

.form-hint {
    display: block;
    font-size: 11px;
    color: #888;
    margin-top: 5px;
    font-style: italic;
}

/* Form */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 8px;
}

.form-group label .required {
    color: #dc3545;
}

.form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
}

.btn {
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-block {
    width: 100%;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--secondary-color);
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
}

.btn-outline {
    background: transparent;
    border: 1px solid var(--primary-color);
    color: var(--primary-color);
    text-decoration: none;
}

.btn-outline:hover {
    background: var(--light-color);
}

/* Tracking Info */
.tracking-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.tracking-info .info-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
}

.tracking-info .label {
    color: var(--text-gray);
}

.tracking-info .resi {
    font-family: monospace;
    font-weight: 600;
    color: var(--primary-color);
}

.mt-3 {
    margin-top: 15px;
}

@media (max-width: 992px) {
    .order-detail-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
@endsection

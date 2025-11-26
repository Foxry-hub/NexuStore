@extends('layouts.app')

@section('title', 'Keranjang Belanja - NEXUSTORE')

@section('content')
<section class="cart-section">
    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h1>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('shop.index') }}">Shop</a>
                <span>/</span>
                <span>Keranjang</span>
            </nav>
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

        @if($cartItems->count() > 0)
        <div class="cart-content">
            <div class="cart-items">
                <div class="cart-header">
                    <div class="col-product">Produk</div>
                    <div class="col-price">Harga</div>
                    <div class="col-qty">Jumlah</div>
                    <div class="col-subtotal">Subtotal</div>
                    <div class="col-action"></div>
                </div>

                @foreach($cartItems as $item)
                <div class="cart-item">
                    <div class="col-product">
                        <div class="product-info">
                            <img src="{{ $item->buku->gambar_cover ? asset('storage/' . $item->buku->gambar_cover) : 'https://via.placeholder.com/80x100/5B4AB3/ffffff?text=Book' }}" alt="{{ $item->buku->judul }}">
                            <div class="product-details">
                                <h4>{{ $item->buku->judul }}</h4>
                                <p class="author">{{ $item->buku->penulis }}</p>
                                <span class="badge">{{ $item->buku->kategori->nama_kategori }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-price">
                        <span class="price">Rp {{ number_format($item->buku->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="col-qty">
                        <form action="{{ route('keranjang.update', $item->id_keranjang) }}" method="POST" class="qty-form">
                            @csrf
                            @method('PATCH')
                            <div class="qty-input">
                                <button type="button" class="qty-btn minus">-</button>
                                <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->buku->stok }}">
                                <button type="button" class="qty-btn plus">+</button>
                            </div>
                            <button type="submit" class="btn-update" title="Update">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </form>
                        <small class="stock-info">Stok: {{ $item->buku->stok }}</small>
                    </div>
                    <div class="col-subtotal">
                        <span class="subtotal">Rp {{ number_format($item->buku->harga * $item->jumlah, 0, ',', '.') }}</span>
                    </div>
                    <div class="col-action">
                        <form action="{{ route('keranjang.destroy', $item->id_keranjang) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <h3>Ringkasan Belanja</h3>
                <div class="summary-row">
                    <span>Total Item</span>
                    <span>{{ $cartItems->sum('jumlah') }} buku</span>
                </div>
                <div class="summary-row total">
                    <span>Total Harga</span>
                    <span class="total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn-checkout">
                    <i class="fas fa-credit-card"></i> Lanjut ke Checkout
                </a>
                <a href="{{ route('shop.index') }}" class="btn-continue">
                    <i class="fas fa-arrow-left"></i> Lanjut Belanja
                </a>
            </div>
        </div>
        @else
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h2>Keranjang Kosong</h2>
            <p>Belum ada produk di keranjang Anda</p>
            <a href="{{ route('shop.index') }}" class="btn-shop">
                <i class="fas fa-store"></i> Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
.cart-section {
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

.alert-success {
    background: #d4edda;
    color: #155724;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
}

.cart-content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

.cart-items {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.cart-header {
    display: grid;
    grid-template-columns: 2fr 1fr 1.2fr 1fr 60px;
    gap: 15px;
    padding: 15px 20px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    font-weight: 600;
    font-size: 14px;
}

.cart-item {
    display: grid;
    grid-template-columns: 2fr 1fr 1.2fr 1fr 60px;
    gap: 15px;
    padding: 20px;
    border-bottom: 1px solid #f0f0f0;
    align-items: center;
}

.cart-item:last-child {
    border-bottom: none;
}

.product-info {
    display: flex;
    gap: 15px;
}

.product-info img {
    width: 80px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
}

.product-details h4 {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--text-dark);
}

.product-details .author {
    font-size: 13px;
    color: var(--text-gray);
    margin-bottom: 8px;
}

.product-details .badge {
    background: var(--light-color);
    color: var(--primary-color);
    padding: 3px 10px;
    border-radius: 15px;
    font-size: 11px;
}

.price, .subtotal {
    font-weight: 600;
    color: var(--primary-color);
}

.qty-form {
    display: flex;
    align-items: center;
    gap: 8px;
}

.qty-input {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.qty-btn {
    width: 32px;
    height: 32px;
    border: none;
    background: #f5f5f5;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.2s;
}

.qty-btn:hover {
    background: var(--primary-color);
    color: white;
}

.qty-input input {
    width: 45px;
    height: 32px;
    border: none;
    text-align: center;
    font-size: 14px;
    -moz-appearance: textfield;
}

.qty-input input::-webkit-outer-spin-button,
.qty-input input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

.btn-update {
    width: 32px;
    height: 32px;
    border: none;
    background: var(--primary-color);
    color: white;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-update:hover {
    background: var(--secondary-color);
}

.stock-info {
    display: block;
    margin-top: 5px;
    color: var(--text-gray);
    font-size: 12px;
}

.btn-remove {
    width: 40px;
    height: 40px;
    border: none;
    background: #fee;
    color: #dc3545;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-remove:hover {
    background: #dc3545;
    color: white;
}

/* Cart Summary */
.cart-summary {
    background: white;
    border-radius: 10px;
    padding: 25px;
    height: fit-content;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 100px;
}

.cart-summary h3 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    font-size: 14px;
    color: var(--text-gray);
}

.summary-row.total {
    border-top: 2px solid #eee;
    margin-top: 10px;
    padding-top: 20px;
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
}

.total-price {
    color: var(--primary-color);
}

.btn-checkout {
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
    text-decoration: none;
    margin-top: 20px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(91, 74, 179, 0.3);
}

.btn-continue {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 12px;
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    margin-top: 10px;
    transition: all 0.2s;
}

.btn-continue:hover {
    background: var(--light-color);
}

/* Empty Cart */
.empty-cart {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 10px;
}

.empty-cart i {
    font-size: 80px;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-cart h2 {
    font-size: 24px;
    margin-bottom: 10px;
    color: var(--text-dark);
}

.empty-cart p {
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
    transition: background 0.2s;
}

.btn-shop:hover {
    background: var(--secondary-color);
}

/* Responsive */
@media (max-width: 992px) {
    .cart-content {
        grid-template-columns: 1fr;
    }
    
    .cart-summary {
        position: static;
    }
}

@media (max-width: 768px) {
    .cart-header {
        display: none;
    }
    
    .cart-item {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .col-product {
        grid-column: 1;
    }
    
    .col-price::before { content: 'Harga: '; font-weight: normal; }
    .col-subtotal::before { content: 'Subtotal: '; font-weight: normal; }
}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('.qty-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const input = this.parentElement.querySelector('input');
        const max = parseInt(input.getAttribute('max'));
        let value = parseInt(input.value);
        
        if (this.classList.contains('plus') && value < max) {
            input.value = value + 1;
        } else if (this.classList.contains('minus') && value > 1) {
            input.value = value - 1;
        }
    });
});
</script>
@endpush
@endsection

@extends('layouts.app')

@section('title', $book->judul . ' - NEXUSTORE')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
            <span>/</span>
            <a href="{{ route('shop.index') }}">Products</a>
            <span>/</span>
            <span>{{ $book->judul }}</span>
        </div>
    </div>
</section>

<!-- Product Detail Section -->
<section class="product-detail-section">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="product-detail">
            <!-- Product Image -->
            <div class="product-gallery">
                <div class="main-image">
                    <img src="{{ $book->gambar_cover ? asset('storage/' . $book->gambar_cover) : 'https://via.placeholder.com/400x550/5B4AB3/ffffff?text=' . urlencode($book->judul) }}" alt="{{ $book->judul }}">
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info-detail">
                @if($book->kategori)
                    <span class="product-category">{{ $book->kategori->nama_kategori }}</span>
                @endif
                
                <h1 class="product-title-detail">{{ $book->judul }}</h1>
                
                <div class="product-author-detail">
                    <i class="fas fa-user"></i>
                    <span>{{ $book->penulis }}</span>
                </div>
                
                <div class="product-rating-detail">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $book->rating_rounded)
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $book->average_rating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="rating-text">({{ number_format($book->average_rating, 1) }} / 5.0) - {{ $book->reviews_count }} ulasan</span>
                </div>

                <div class="product-price-detail">
                    <span class="price">Rp {{ number_format($book->harga, 0, ',', '.') }}</span>
                </div>

                <div class="product-stock">
                    @if($book->stok > 0)
                        <span class="in-stock">
                            <i class="fas fa-check-circle"></i>
                            Stok tersedia: {{ $book->stok }} buku
                        </span>
                    @else
                        <span class="out-stock">
                            <i class="fas fa-times-circle"></i>
                            Stok habis
                        </span>
                    @endif
                </div>

                <div class="product-description">
                    <h3>Deskripsi</h3>
                    <p>{{ $book->deskripsi ?: 'Tidak ada deskripsi tersedia untuk buku ini.' }}</p>
                </div>

                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Penerbit:</span>
                        <span class="meta-value">{{ $book->penerbit ?: '-' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tahun Terbit:</span>
                        <span class="meta-value">{{ $book->tahun_terbit ?: '-' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">ISBN:</span>
                        <span class="meta-value">{{ $book->isbn ?: '-' }}</span>
                    </div>
                </div>

                <!-- Add to Cart Form -->
                <div class="product-actions-detail">
                    @auth
                        @if(Auth::user()->isPelanggan())
                            @if($book->stok > 0)
                                <form action="{{ route('keranjang.add') }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="id_buku" value="{{ $book->id_buku }}">
                                    <div class="quantity-input">
                                        <button type="button" class="qty-btn minus">-</button>
                                        <input type="number" name="jumlah" value="1" min="1" max="{{ $book->stok }}" class="qty-field">
                                        <button type="button" class="qty-btn plus">+</button>
                                    </div>
                                    <button type="submit" class="btn-add-to-cart">
                                        <i class="fas fa-shopping-cart"></i>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button class="btn-add-to-cart disabled" disabled>
                                    <i class="fas fa-shopping-cart"></i>
                                    Stok Habis
                                </button>
                            @endif
                        @else
                            <p class="admin-notice">
                                <i class="fas fa-info-circle"></i>
                                Login sebagai pelanggan untuk berbelanja
                            </p>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-add-to-cart">
                            <i class="fas fa-sign-in-alt"></i>
                            Login untuk Membeli
                        </a>
                    @endauth
                </div>

                <div class="product-share">
                    <span>Share:</span>
                    <div class="share-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                        <a href="#"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Books Section -->
@if($relatedBooks->count() > 0)
<section class="related-books-section">
    <div class="container">
        <div class="section-header">
            <h2>Buku <span class="highlight">Terkait</span></h2>
            <a href="{{ route('shop.index', ['kategori' => $book->id_kategori]) }}" class="view-all">Lihat Semua →</a>
        </div>
        
        <div class="book-grid">
            @foreach($relatedBooks as $relatedBook)
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ $relatedBook->gambar_cover ? asset('storage/' . $relatedBook->gambar_cover) : 'https://via.placeholder.com/200x280/5B4AB3/ffffff?text=' . urlencode($relatedBook->judul) }}" alt="{{ $relatedBook->judul }}">
                    <div class="product-actions">
                        <a href="{{ route('shop.show', $relatedBook->id_buku) }}" class="action-btn" title="Quick View">
                            <i class="fas fa-eye"></i>
                        </a>
                        @auth
                            @if(Auth::user()->isPelanggan())
                                <form action="{{ route('keranjang.add') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="id_buku" value="{{ $relatedBook->id_buku }}">
                                    <button type="submit" class="action-btn" title="Add to Cart" {{ $relatedBook->stok < 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $relatedBook->rating_rounded)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <h3 class="product-title">
                        <a href="{{ route('shop.show', $relatedBook->id_buku) }}">{{ $relatedBook->judul }}</a>
                    </h3>
                    <p class="product-author">{{ $relatedBook->penulis }}</p>
                    <div class="product-price">
                        <span class="price">Rp {{ number_format($relatedBook->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Reviews Section -->
<section class="reviews-section">
    <div class="container">
        <div class="reviews-container">
            <div class="reviews-header">
                <h2><i class="fas fa-comments"></i> Ulasan Pembeli</h2>
                <div class="rating-summary">
                    <div class="rating-big">
                        <span class="rating-number">{{ number_format($book->average_rating, 1) }}</span>
                        <div class="rating-stars-big">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $book->rating_rounded)
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $book->average_rating)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="total-reviews">{{ $book->reviews_count }} ulasan</span>
                    </div>
                    <div class="rating-bars">
                        @php
                            $reviews = $book->approvedReviews;
                            $totalReviews = $reviews->count();
                        @endphp
                        @for($i = 5; $i >= 1; $i--)
                            @php
                                $count = $reviews->where('rating', $i)->count();
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="rating-bar-item">
                                <span class="star-label">{{ $i }} <i class="fas fa-star"></i></span>
                                <div class="bar-track">
                                    <div class="bar-fill" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="bar-count">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="reviews-list">
                @forelse($book->approvedReviews()->with('user')->latest()->take(10)->get() as $review)
                <div class="review-item">
                    <div class="review-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="review-content">
                        <div class="review-header-item">
                            <span class="reviewer-name">{{ $review->user->nama ?? 'Pengguna' }}</span>
                            <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        @if($review->ulasan)
                            <p class="review-text">{{ $review->ulasan }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="no-reviews">
                    <i class="far fa-comment-dots"></i>
                    <h3>Belum ada ulasan</h3>
                    <p>Jadilah yang pertama memberikan ulasan untuk buku ini!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Breadcrumb */
.breadcrumb-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    padding: 60px 0 100px;
    color: white;
    position: relative;
    overflow: hidden;
}

.breadcrumb-section::after {
    content: '';
    position: absolute;
    bottom: -50px;
    left: 0;
    right: 0;
    height: 100px;
    background: white;
    border-radius: 50% 50% 0 0;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    position: relative;
    z-index: 1;
}

.breadcrumb a {
    color: white;
    text-decoration: none;
}

.breadcrumb a:hover {
    opacity: 0.8;
}

/* Alert Messages */
.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Product Detail Section */
.product-detail-section {
    padding: 40px 0 80px;
    background-color: #f8f8f8;
}

.product-detail {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 50px;
    background-color: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

/* Product Gallery */
.product-gallery {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.main-image {
    background-color: #f8f8f8;
    border-radius: 15px;
    overflow: hidden;
    aspect-ratio: 3/4;
}

.main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Info Detail */
.product-info-detail {
    padding: 10px 0;
}

.product-category {
    display: inline-block;
    background-color: var(--light-color);
    color: var(--primary-color);
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 15px;
}

.product-title-detail {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 15px;
    line-height: 1.3;
}

.product-author-detail {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    color: var(--text-gray);
    margin-bottom: 15px;
}

.product-rating-detail {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.product-rating-detail .stars {
    color: #FFA500;
}

.product-rating-detail .stars .far {
    color: #ddd;
}

.rating-text {
    color: var(--text-gray);
    font-size: 14px;
}

.product-price-detail {
    margin-bottom: 20px;
}

.product-price-detail .price {
    font-size: 36px;
    font-weight: 800;
    color: var(--primary-color);
}

.product-stock {
    margin-bottom: 25px;
}

.in-stock {
    color: #28a745;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.out-stock {
    color: #dc3545;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.product-description {
    margin-bottom: 25px;
    padding-bottom: 25px;
    border-bottom: 1px solid #e0e0e0;
}

.product-description h3 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
}

.product-description p {
    color: var(--text-gray);
    line-height: 1.8;
}

.product-meta {
    margin-bottom: 30px;
}

.meta-item {
    display: flex;
    margin-bottom: 10px;
    font-size: 14px;
}

.meta-label {
    min-width: 120px;
    font-weight: 600;
    color: var(--text-dark);
}

.meta-value {
    color: var(--text-gray);
}

/* Add to Cart Form */
.product-actions-detail {
    margin-bottom: 30px;
}

.add-to-cart-form {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.quantity-input {
    display: flex;
    align-items: center;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    overflow: hidden;
}

.qty-btn {
    width: 45px;
    height: 50px;
    border: none;
    background-color: #f8f8f8;
    font-size: 20px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.qty-btn:hover {
    background-color: #e0e0e0;
}

.qty-field {
    width: 60px;
    height: 50px;
    border: none;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    -moz-appearance: textfield;
}

.qty-field::-webkit-outer-spin-button,
.qty-field::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.btn-add-to-cart {
    flex: 1;
    min-width: 200px;
    padding: 15px 30px;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: background-color 0.3s, transform 0.3s;
    text-decoration: none;
}

.btn-add-to-cart:hover:not(.disabled) {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
}

.btn-add-to-cart.disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.admin-notice {
    color: var(--text-gray);
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.product-share {
    display: flex;
    align-items: center;
    gap: 15px;
    padding-top: 25px;
    border-top: 1px solid #e0e0e0;
}

.product-share span {
    font-weight: 600;
    color: var(--text-dark);
}

.share-links {
    display: flex;
    gap: 10px;
}

.share-links a {
    width: 40px;
    height: 40px;
    background-color: #f8f8f8;
    color: var(--text-gray);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    text-decoration: none;
}

.share-links a:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Related Books Section */
.related-books-section {
    padding: 60px 0;
    background-color: white;
}

/* Reviews Section */
.reviews-section {
    padding: 60px 0;
    background-color: #f8f8f8;
}

.reviews-container {
    background: white;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.reviews-header {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
}

.reviews-header h2 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.reviews-header h2 i {
    color: var(--primary-color);
}

.rating-summary {
    display: flex;
    gap: 40px;
    align-items: flex-start;
}

.rating-big {
    text-align: center;
    min-width: 150px;
}

.rating-number {
    font-size: 56px;
    font-weight: 800;
    color: var(--primary-color);
    display: block;
    line-height: 1;
}

.rating-stars-big {
    color: #FFA500;
    font-size: 20px;
    margin: 10px 0;
}

.rating-stars-big .far {
    color: #ddd;
}

.total-reviews {
    color: var(--text-gray);
    font-size: 14px;
}

.rating-bars {
    flex: 1;
    max-width: 400px;
}

.rating-bar-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
}

.star-label {
    min-width: 40px;
    font-size: 14px;
    color: #666;
    display: flex;
    align-items: center;
    gap: 4px;
}

.star-label i {
    color: #FFA500;
    font-size: 12px;
}

.bar-track {
    flex: 1;
    height: 8px;
    background: #eee;
    border-radius: 4px;
    overflow: hidden;
}

.bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #FFA500, #FF8C00);
    border-radius: 4px;
    transition: width 0.5s ease;
}

.bar-count {
    min-width: 30px;
    text-align: right;
    font-size: 14px;
    color: #888;
}

.reviews-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.review-item {
    display: flex;
    gap: 15px;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 12px;
}

.review-avatar {
    font-size: 45px;
    color: #ccc;
    flex-shrink: 0;
}

.review-content {
    flex: 1;
}

.review-header-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.reviewer-name {
    font-weight: 600;
    color: var(--text-dark);
}

.review-date {
    font-size: 12px;
    color: #888;
}

.review-rating {
    color: #FFA500;
    font-size: 14px;
    margin-bottom: 10px;
}

.review-rating .far {
    color: #ddd;
}

.review-text {
    color: #555;
    line-height: 1.7;
    font-size: 14px;
}

.no-reviews {
    text-align: center;
    padding: 60px 20px;
    color: #888;
}

.no-reviews i {
    font-size: 60px;
    margin-bottom: 20px;
    color: #ddd;
}

.no-reviews h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #666;
}

.no-reviews p {
    font-size: 14px;
}

/* Product Card Styles (reused from shop index) */
.product-card {
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    border: 1px solid #f0f0f0;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.product-image {
    position: relative;
    aspect-ratio: 5/7;
    overflow: hidden;
    background-color: #f8f8f8;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.3s;
}

.product-card:hover .product-actions {
    opacity: 1;
}

.action-btn {
    width: 40px;
    height: 40px;
    background-color: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s;
    text-decoration: none;
    color: var(--text-dark);
}

.action-btn:hover {
    background-color: var(--primary-color);
    color: white;
}

.product-info {
    padding: 15px;
}

.product-rating {
    color: #FFA500;
    font-size: 12px;
    margin-bottom: 8px;
}

.product-rating .far {
    color: #ddd;
}

.product-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
}

.product-title a {
    color: var(--text-dark);
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-title a:hover {
    color: var(--primary-color);
}

.product-author {
    font-size: 12px;
    color: var(--text-gray);
    margin-bottom: 10px;
}

.product-price .price {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-color);
}

/* Responsive */
@media (max-width: 992px) {
    .product-detail {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .product-gallery {
        position: static;
    }
}

@media (max-width: 576px) {
    .product-detail {
        padding: 25px;
    }
    
    .product-title-detail {
        font-size: 24px;
    }
    
    .product-price-detail .price {
        font-size: 28px;
    }
    
    .add-to-cart-form {
        flex-direction: column;
    }
    
    .btn-add-to-cart {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const minusBtn = document.querySelector('.qty-btn.minus');
    const plusBtn = document.querySelector('.qty-btn.plus');
    const qtyField = document.querySelector('.qty-field');
    
    if (minusBtn && plusBtn && qtyField) {
        const maxQty = parseInt(qtyField.getAttribute('max'));
        
        minusBtn.addEventListener('click', function() {
            let value = parseInt(qtyField.value);
            if (value > 1) {
                qtyField.value = value - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            let value = parseInt(qtyField.value);
            if (value < maxQty) {
                qtyField.value = value + 1;
            }
        });
        
        qtyField.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (value < 1) this.value = 1;
            if (value > maxQty) this.value = maxQty;
        });
    }
});
</script>
@endpush
@endsection

@extends('layouts.app')

@section('title', 'Shop - NEXUSTORE')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb-section">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
            <span>/</span>
            <span>Products</span>
        </div>
    </div>
</section>

<!-- Shop Section -->
<section class="shop-section">
    <div class="container">
        <div class="shop-header">
            <h1>Archives: Products</h1>
        </div>
        
        <div class="shop-layout">
            <!-- Sidebar Filter -->
            <aside class="shop-sidebar">
                <!-- Filter by Price -->
                <div class="filter-widget">
                    <h3>Filter by price</h3>
                    <form action="{{ route('shop.index') }}" method="GET" id="priceFilterForm">
                        <div class="price-slider">
                            <input type="range" min="0" max="500000" value="{{ request('max_price', 500000) }}" id="priceRange">
                        </div>
                        <div class="price-inputs">
                            <input type="number" name="min_price" placeholder="0" value="{{ request('min_price', 0) }}" class="price-input">
                            <input type="number" name="max_price" placeholder="500000" value="{{ request('max_price', 500000) }}" class="price-input">
                        </div>
                        <button type="submit" class="btn-filter">Filter</button>
                    </form>
                </div>

                <!-- Filter by Category -->
                <div class="filter-widget">
                    <h3>Filter by category</h3>
                    <div class="filter-list">
                        @foreach($categories as $category)
                        <label class="filter-item">
                            <input type="checkbox" name="kategori" value="{{ $category->id_kategori }}" {{ request('kategori') == $category->id_kategori ? 'checked' : '' }}>
                            <span>{{ $category->nama_kategori }}</span>
                            <span class="count">({{ $category->buku->count() }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Filter by Rating -->
                <div class="filter-widget">
                    <h3>Filter by rating</h3>
                    <div class="filter-list">
                        <label class="filter-item">
                            <input type="checkbox">
                            <span class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </span>
                            <span class="count">(0)</span>
                        </label>
                        <label class="filter-item">
                            <input type="checkbox">
                            <span class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                            <span class="count">(0)</span>
                        </label>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="shop-main">
                <!-- Toolbar -->
                <div class="shop-toolbar">
                    <div class="toolbar-left">
                        <span class="result-count">Showing 1-{{ $books->count() }} of {{ $books->total() }} results</span>
                    </div>
                    
                    <div class="toolbar-right">
                        <form action="{{ route('shop.index') }}" method="GET" class="sort-form">
                            <select name="sort" class="sort-select" onchange="this.form.submit()">
                                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="harga_terendah" {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                                <option value="harga_tertinggi" {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                                <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama: A-Z</option>
                                <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama: Z-A</option>
                            </select>
                        </form>
                        
                        <div class="view-mode">
                            <button class="view-btn active" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                        
                        <input type="number" value="12" class="per-page-input" min="1" max="100">
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid">
                    @forelse($books as $book)
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $book->gambar_cover ? asset('storage/' . $book->gambar_cover) : 'https://via.placeholder.com/200x280/5B4AB3/ffffff?text=' . urlencode($book->judul) }}" alt="{{ $book->judul }}">
                            <div class="product-actions">
                                <button class="action-btn" title="Quick View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn" title="Add to Cart">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <button class="action-btn" title="Add to Wishlist">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <h3 class="product-title">
                                <a href="{{ route('shop.show', $book->id_buku) }}">{{ $book->judul }}</a>
                            </h3>
                            <p class="product-author">{{ $book->penulis }}</p>
                            <div class="product-price">
                                <span class="price">Rp {{ number_format($book->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="no-products">
                        <i class="fas fa-book"></i>
                        <p>Tidak ada buku yang ditemukan</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($books->hasPages())
                <div class="pagination-wrapper">
                    {{ $books->links('vendor.pagination.custom') }}
                </div>
                @endif
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

/* Shop Section */
.shop-section {
    padding: 40px 0 80px;
    background-color: #f8f8f8;
}

.shop-header {
    text-align: center;
    margin-bottom: 40px;
}

.shop-header h1 {
    font-size: 36px;
    font-weight: 700;
    color: var(--text-dark);
}

.shop-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 30px;
}

/* Sidebar */
.shop-sidebar {
    background-color: white;
    padding: 25px;
    border-radius: 10px;
    height: fit-content;
    position: sticky;
    top: 90px;
}

.filter-widget {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #e0e0e0;
}

.filter-widget:last-child {
    border-bottom: none;
}

.filter-widget h3 {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 15px;
    color: var(--text-dark);
}

.price-slider {
    margin-bottom: 15px;
}

.price-slider input[type="range"] {
    width: 100%;
}

.price-inputs {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.price-input {
    flex: 1;
    padding: 8px 10px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    font-size: 13px;
    width: 0;
    min-width: 0;
}

.price-input::placeholder {
    font-size: 12px;
}

/* Remove number spinner arrows */
.price-input::-webkit-inner-spin-button,
.price-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.price-input[type=number] {
    -moz-appearance: textfield;
}

.btn-filter {
    width: 100%;
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-filter:hover {
    background-color: var(--secondary-color);
}

.filter-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.filter-item {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-size: 14px;
}

.filter-item input[type="checkbox"] {
    cursor: pointer;
}

.filter-item .count {
    margin-left: auto;
    color: var(--text-gray);
    font-size: 12px;
}

.rating-stars {
    color: #FFA500;
    font-size: 12px;
}

.rating-stars .far {
    color: #ddd;
}

/* Shop Main */
.shop-main {
    background-color: white;
    padding: 25px;
    border-radius: 10px;
}

.shop-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e0e0e0;
}

.result-count {
    font-size: 14px;
    color: var(--text-gray);
}

.toolbar-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.sort-select {
    padding: 8px 12px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

.view-mode {
    display: flex;
    gap: 5px;
}

.view-btn {
    width: 35px;
    height: 35px;
    border: 1px solid #e0e0e0;
    background-color: white;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s;
}

.view-btn.active,
.view-btn:hover {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.per-page-input {
    width: 60px;
    padding: 8px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    text-align: center;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 25px;
}

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

.product-price {
    display: flex;
    align-items: center;
    gap: 10px;
}

.price {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-color);
}

.price-old {
    font-size: 14px;
    color: var(--text-gray);
    text-decoration: line-through;
}

.no-products {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: var(--text-gray);
}

.no-products i {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.3;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 40px;
    padding: 30px 20px;
    display: flex;
    justify-content: center;
    background: #f5f5f5;
    border-radius: 10px;
}

.custom-pagination {
    display: flex;
    align-items: center;
    gap: 8px;
}

.custom-pagination .arrow {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    font-size: 20px;
    color: #333;
    text-decoration: none;
    transition: all 0.3s;
}

.custom-pagination .arrow:hover:not(.disabled) {
    color: #000;
    transform: scale(1.1);
}

.custom-pagination .arrow.disabled {
    color: #ccc;
    cursor: not-allowed;
}

.custom-pagination .page {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 15px;
    font-weight: 500;
    color: #333;
    text-decoration: none;
    transition: all 0.3s;
}

.custom-pagination .page:hover:not(.active) {
    background: #e0e0e0;
}

.custom-pagination .page.active {
    background: #5B4AB3;
    color: white;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(91, 74, 179, 0.3);
}

.custom-pagination .dots {
    color: #999;
    padding: 0 5px;
}

/* Responsive */
@media (max-width: 992px) {
    .shop-layout {
        grid-template-columns: 1fr;
    }
    
    .shop-sidebar {
        position: static;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }
}

@media (max-width: 576px) {
    .shop-toolbar {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .toolbar-right {
        width: 100%;
        justify-content: space-between;
    }
    
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
}
</style>
@endpush
@endsection

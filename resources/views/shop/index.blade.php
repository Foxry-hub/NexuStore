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
                <form action="{{ route('shop.index') }}" method="GET" id="filterForm">
                    <!-- Keep sort and search parameter -->
                    <input type="hidden" name="sort" value="{{ request('sort', 'terbaru') }}">
                    @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <!-- Filter by Price -->
                    <div class="filter-widget">
                        <h3>Filter by price</h3>
                        <div class="price-range-slider">
                            <div class="range-track"></div>
                            <input type="range" min="0" max="500000" step="10000" value="{{ request('min_price', 0) }}" id="minPriceRange" class="range-input range-min">
                            <input type="range" min="0" max="500000" step="10000" value="{{ request('max_price', 500000) }}" id="maxPriceRange" class="range-input range-max">
                        </div>
                        <div class="price-values">
                            <span>Rp <span id="minPriceDisplay">{{ number_format(request('min_price', 0), 0, ',', '.') }}</span></span>
                            <span>—</span>
                            <span>Rp <span id="maxPriceDisplay">{{ number_format(request('max_price', 500000), 0, ',', '.') }}</span></span>
                        </div>
                        <input type="hidden" name="min_price" id="minPriceInput" value="{{ request('min_price', 0) }}">
                        <input type="hidden" name="max_price" id="maxPriceInput" value="{{ request('max_price', 500000) }}">
                    </div>

                    <!-- Filter by Category -->
                    <div class="filter-widget">
                        <h3>Filter by category</h3>
                        <div class="filter-list">
                            @php
                                $selectedKategori = request('kategori', []);
                                if (!is_array($selectedKategori)) {
                                    $selectedKategori = [$selectedKategori];
                                }
                            @endphp
                            @foreach($categories as $category)
                            <label class="filter-item">
                                <input type="checkbox" name="kategori[]" value="{{ $category->id_kategori }}" 
                                    {{ in_array($category->id_kategori, $selectedKategori) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span class="filter-label">{{ $category->nama_kategori }}</span>
                                <span class="count">({{ $category->buku->count() }})</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter by Rating -->
                    <div class="filter-widget">
                        <h3>Filter by rating</h3>
                        <div class="filter-list">
                            @php
                                $selectedRating = request('rating', []);
                                if (!is_array($selectedRating)) {
                                    $selectedRating = [$selectedRating];
                                }
                            @endphp
                            @for($i = 5; $i >= 1; $i--)
                            <label class="filter-item">
                                <input type="checkbox" name="rating[]" value="{{ $i }}"
                                    {{ in_array($i, $selectedRating) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span class="rating-stars">
                                    @for($j = 1; $j <= 5; $j++)
                                        @if($j <= $i)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </span>
                                <span class="rating-text">& up</span>
                            </label>
                            @endfor
                        </div>
                    </div>

                    <!-- Apply Filter Button -->
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-filter"></i> Apply Filter
                    </button>
                    
                    @if(request()->hasAny(['min_price', 'max_price', 'kategori', 'rating']))
                    <a href="{{ route('shop.index') }}" class="btn-reset">
                        <i class="fas fa-times"></i> Reset Filter
                    </a>
                    @endif
                </form>
            </aside>

            <!-- Main Content -->
            <div class="shop-main">
                <!-- Search Bar -->
                <div class="search-bar-container">
                    <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                        <!-- Preserve existing filter params -->
                        <input type="hidden" name="min_price" value="{{ request('min_price', 0) }}">
                        <input type="hidden" name="max_price" value="{{ request('max_price', 500000) }}">
                        <input type="hidden" name="sort" value="{{ request('sort', 'terbaru') }}">
                        @if(request('kategori'))
                            @foreach((array)request('kategori') as $kat)
                            <input type="hidden" name="kategori[]" value="{{ $kat }}">
                            @endforeach
                        @endif
                        @if(request('rating'))
                            @foreach((array)request('rating') as $rat)
                            <input type="hidden" name="rating[]" value="{{ $rat }}">
                            @endforeach
                        @endif
                        <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="search-input" placeholder="Cari buku berdasarkan judul..." value="{{ request('search') }}">
                            @if(request('search'))
                            <a href="{{ route('shop.index', request()->except('search')) }}" class="search-clear">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </form>
                </div>

                <!-- Toolbar -->
                <div class="shop-toolbar">
                    <div class="toolbar-left">
                        <span class="result-count">
                            @if(request('search'))
                                Hasil pencarian "{{ request('search') }}": {{ $books->total() }} buku ditemukan
                            @else
                                Showing 1-{{ $books->count() }} of {{ $books->total() }} results
                            @endif
                        </span>
                    </div>
                    
                    <div class="toolbar-right">
                        <form action="{{ route('shop.index') }}" method="GET" class="sort-form" id="sortForm">
                            <!-- Preserve existing filter params -->
                            <input type="hidden" name="min_price" value="{{ request('min_price', 0) }}">
                            <input type="hidden" name="max_price" value="{{ request('max_price', 500000) }}">
                            @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('kategori'))
                                @foreach((array)request('kategori') as $kat)
                                <input type="hidden" name="kategori[]" value="{{ $kat }}">
                                @endforeach
                            @endif
                            @if(request('rating'))
                                @foreach((array)request('rating') as $rat)
                                <input type="hidden" name="rating[]" value="{{ $rat }}">
                                @endforeach
                            @endif
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
                    </div>
                </div>

                <!-- Active Filters -->
                @if(request()->hasAny(['kategori', 'rating', 'search']) || request('min_price', 0) > 0 || request('max_price', 500000) < 500000)
                <div class="active-filters">
                    <span class="active-label">Active Filters:</span>
                    @if(request('search'))
                        <span class="filter-tag">
                            <i class="fas fa-search"></i> "{{ request('search') }}"
                            <a href="{{ route('shop.index', request()->except('search')) }}" class="remove-filter">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                    @endif
                    @if(request('min_price', 0) > 0 || request('max_price', 500000) < 500000)
                        <span class="filter-tag">
                            Rp {{ number_format(request('min_price', 0), 0, ',', '.') }} - Rp {{ number_format(request('max_price', 500000), 0, ',', '.') }}
                        </span>
                    @endif
                    @if(request('kategori'))
                        @foreach((array)request('kategori') as $katId)
                            @php $kat = $categories->firstWhere('id_kategori', $katId); @endphp
                            @if($kat)
                                <span class="filter-tag">{{ $kat->nama_kategori }}</span>
                            @endif
                        @endforeach
                    @endif
                    @if(request('rating'))
                        @foreach((array)request('rating') as $rat)
                            <span class="filter-tag">{{ $rat }}★ & up</span>
                        @endforeach
                    @endif
                </div>
                @endif

                <!-- Products Grid -->
                <div class="products-grid">
                    @forelse($books as $book)
                    <a href="{{ route('shop.show', $book->id_buku) }}" class="product-card">
                        <div class="product-image">
                            <img src="{{ $book->gambar_cover ? asset('storage/' . $book->gambar_cover) : 'https://via.placeholder.com/200x280/5B4AB3/ffffff?text=' . urlencode($book->judul) }}" alt="{{ $book->judul }}">
                            @auth
                                @if(Auth::user()->isPelanggan())
                                <div class="product-actions">
                                    <form action="{{ route('keranjang.add') }}" method="POST" class="add-cart-form" onclick="event.stopPropagation();">
                                        @csrf
                                        <input type="hidden" name="id_buku" value="{{ $book->id_buku }}">
                                        <button type="submit" class="action-btn" title="Add to Cart" {{ $book->stok < 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            @endauth
                        </div>
                        <div class="product-info">
                            <div class="product-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $book->rating_rounded)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span class="rating-count">({{ $book->reviews_count }})</span>
                            </div>
                            <h3 class="product-title">{{ $book->judul }}</h3>
                            <p class="product-author">{{ $book->penulis }}</p>
                            <div class="product-price">
                                <span class="price">Rp {{ number_format($book->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="no-products">
                        <i class="fas fa-book"></i>
                        <p>Tidak ada buku yang ditemukan</p>
                        <a href="{{ route('shop.index') }}" class="btn-reset-inline">Reset Filter</a>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($books->hasPages())
                <div class="pagination-wrapper">
                    {{ $books->appends(request()->query())->links('vendor.pagination.custom') }}
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
    font-size: 16px;
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

.filter-widget:last-of-type {
    border-bottom: none;
    margin-bottom: 20px;
}

.filter-widget h3 {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 20px;
    color: var(--text-dark);
}

/* Dual Range Slider */
.price-range-slider {
    position: relative;
    height: 30px;
    margin: 20px 0;
}

.price-range-slider .range-track {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    height: 6px;
    background: #e0e0e0;
    border-radius: 3px;
}

.range-input {
    position: absolute;
    width: 100%;
    height: 6px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    -webkit-appearance: none;
    appearance: none;
    background: transparent;
}

.range-input::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    background: var(--primary-color);
    border-radius: 50%;
    cursor: pointer;
    pointer-events: auto;
    border: 3px solid white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    transition: transform 0.2s;
}

.range-input::-webkit-slider-thumb:hover {
    transform: scale(1.1);
}

.range-input::-moz-range-thumb {
    width: 20px;
    height: 20px;
    background: var(--primary-color);
    border-radius: 50%;
    cursor: pointer;
    pointer-events: auto;
    border: 3px solid white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

.price-values {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
    padding: 5px 0;
}

.price-values span:nth-child(2) {
    color: #aaa;
}

.btn-filter {
    width: 100%;
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 10px;
}

.btn-filter:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
}

.btn-reset {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: white;
    color: #666;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-reset:hover {
    border-color: #ff4444;
    color: #ff4444;
    background: #fff5f5;
}

.filter-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 200px;
    overflow-y: auto;
}

.filter-item {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    font-size: 14px;
    padding: 8px 10px;
    border-radius: 6px;
    transition: background 0.2s;
}

.filter-item:hover {
    background: #f5f5f5;
}

.filter-item input[type="checkbox"] {
    display: none;
}

.filter-item .checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid #ddd;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}

.filter-item .checkmark::after {
    content: '✓';
    font-size: 12px;
    font-weight: bold;
    color: white;
    opacity: 0;
    transition: opacity 0.2s;
}

.filter-item input[type="checkbox"]:checked + .checkmark {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.filter-item input[type="checkbox"]:checked + .checkmark::after {
    opacity: 1;
}

.filter-item .filter-label {
    flex: 1;
}

.filter-item .count {
    color: var(--text-gray);
    font-size: 12px;
}

.filter-item .rating-text {
    color: #888;
    font-size: 12px;
}

.rating-stars {
    color: #FFA500;
    font-size: 14px;
}

.rating-stars .far {
    color: #ddd;
}

/* Active Filters */
.active-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    padding: 15px;
    background: #f9f8ff;
    border-radius: 8px;
    border: 1px solid #e8e5ff;
}

.active-label {
    font-weight: 600;
    color: #666;
    font-size: 13px;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    background: var(--primary-color);
    color: white;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.filter-tag .remove-filter {
    color: white;
    opacity: 0.7;
    margin-left: 5px;
    transition: opacity 0.3s;
}

.filter-tag .remove-filter:hover {
    opacity: 1;
}

/* Shop Main */
.shop-main {
    background-color: white;
    padding: 25px;
    border-radius: 10px;
}

/* Search Bar */
.search-bar-container {
    margin-bottom: 25px;
}

.search-form {
    display: flex;
    gap: 12px;
    align-items: center;
}

.search-input-wrapper {
    flex: 1;
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 15px;
    color: #999;
    font-size: 16px;
}

.search-input {
    width: 100%;
    padding: 14px 45px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 15px;
    transition: all 0.3s;
    background: #f8f8f8;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    background: white;
    box-shadow: 0 0 0 4px rgba(91, 74, 179, 0.1);
}

.search-input::placeholder {
    color: #aaa;
}

.search-clear {
    position: absolute;
    right: 15px;
    color: #999;
    text-decoration: none;
    padding: 5px;
    transition: color 0.3s;
}

.search-clear:hover {
    color: #ff4444;
}

.search-btn {
    padding: 14px 25px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    white-space: nowrap;
}

.search-btn:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(91, 74, 179, 0.3);
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

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 25px;
}

.product-card {
    display: block;
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    border: 1px solid #f0f0f0;
    text-decoration: none;
    cursor: pointer;
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

.add-cart-form {
    display: inline;
}

.action-btn {
    width: 50px;
    height: 50px;
    background-color: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s;
    color: var(--text-dark);
    font-size: 20px;
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
    display: flex;
    align-items: center;
    gap: 5px;
}

.product-rating .far {
    color: #ddd;
}

.product-rating .rating-count {
    color: #888;
    font-size: 11px;
}

.product-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--text-dark);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-card:hover .product-title {
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

.btn-reset-inline {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 25px;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
}

.btn-reset-inline:hover {
    background: var(--secondary-color);
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
    .search-form {
        flex-direction: column;
    }
    
    .search-input-wrapper {
        width: 100%;
    }
    
    .search-btn {
        width: 100%;
        justify-content: center;
    }
    
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

    .active-filters {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const minRange = document.getElementById('minPriceRange');
    const maxRange = document.getElementById('maxPriceRange');
    const minDisplay = document.getElementById('minPriceDisplay');
    const maxDisplay = document.getElementById('maxPriceDisplay');
    const minInput = document.getElementById('minPriceInput');
    const maxInput = document.getElementById('maxPriceInput');
    
    const minGap = 10000; // Minimum gap between min and max
    
    function formatPrice(value) {
        return parseInt(value).toLocaleString('id-ID');
    }
    
    function updateSlider() {
        let minVal = parseInt(minRange.value);
        let maxVal = parseInt(maxRange.value);
        
        // Ensure min doesn't exceed max
        if (minVal > maxVal - minGap) {
            minVal = maxVal - minGap;
            minRange.value = minVal;
        }
        
        // Ensure max doesn't go below min
        if (maxVal < minVal + minGap) {
            maxVal = minVal + minGap;
            maxRange.value = maxVal;
        }
        
        // Update display
        minDisplay.textContent = formatPrice(minVal);
        maxDisplay.textContent = formatPrice(maxVal);
        
        // Update hidden inputs
        minInput.value = minVal;
        maxInput.value = maxVal;
    }
    
    minRange.addEventListener('input', updateSlider);
    maxRange.addEventListener('input', updateSlider);
    
    // Initialize
    updateSlider();
    
    // View mode toggle
    const viewBtns = document.querySelectorAll('.view-btn');
    const productsGrid = document.querySelector('.products-grid');
    
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            if (this.dataset.view === 'list') {
                productsGrid.style.gridTemplateColumns = '1fr';
            } else {
                productsGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(220px, 1fr))';
            }
        });
    });
});
</script>
@endpush

@endsection

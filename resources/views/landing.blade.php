@extends('layouts.app')

@section('title', 'NEXUSTORE - Toko Buku Online Terlengkap')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-slider">
            <div class="hero-slide">
                <div class="hero-content">
                    <div class="promo-badge">DISKON 17%</div>
                    <h1>BUKU PALING DIBURU!</h1>
                    <p>DARI GRAMEDIA, BPMIGAS DAN DARI PENULIS DUNIA</p>
                    <button class="btn-primary">Beli Sekarang <i class="fas fa-arrow-right"></i></button>
                </div>
                <div class="hero-image">
                    <img src="https://via.placeholder.com/400x300/5B4AB3/ffffff?text=Promo+Buku" alt="Promo Buku">
                </div>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="search-container">
            <div class="search-bar">
                <select class="category-select">
                    <option>Kategori</option>
                    <option>Fiksi</option>
                    <option>Non-Fiksi</option>
                    <option>Pendidikan</option>
                    <option>Bisnis</option>
                </select>
                <input type="text" placeholder="Cari Judul Buku" class="search-input">
                <button class="btn-search">Search</button>
            </div>
        </div>
    </div>
</section>

<!-- Most Popular Section -->
<section class="book-section">
    <div class="container">
        <div class="section-header">
            <h2>Most <span class="highlight">Popular</span></h2>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="book-grid">
            @for($i = 1; $i <= 5; $i++)
            <div class="book-card">
                <div class="book-image">
                    <img src="https://via.placeholder.com/200x280/{{ $i % 2 == 0 ? '5B4AB3' : 'E8E6F8' }}/333333?text=Book+{{ $i }}" alt="Book {{ $i }}">
                </div>
                <div class="book-info">
                    <h3 class="book-title">Serangai Sibernatik Membentuk Keselarasan</h3>
                    <p class="book-author">Mochamad Yoga Pamungkas</p>
                    <p class="book-price">Rp 75.000</p>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Top Search Section -->
<section class="book-section">
    <div class="container">
        <div class="section-header">
            <h2>Top <span class="highlight">Search</span></h2>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="book-grid">
            @for($i = 1; $i <= 3; $i++)
            <div class="book-card">
                <div class="book-image">
                    <img src="https://via.placeholder.com/200x280/322684/ffffff?text=Top+Book+{{ $i }}" alt="Top Book {{ $i }}">
                </div>
                <div class="book-info">
                    <h3 class="book-title">Menjadi Pribadi Terencana</h3>
                    <p class="book-author">Suci Ramadhani Fahmi</p>
                    <p class="book-price">Rp 90.000</p>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- Editor Choices Section -->
<section class="book-section">
    <div class="container">
        <div class="section-header">
            <h2>Editor <span class="highlight">Choices</span></h2>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="book-grid">
            @for($i = 1; $i <= 5; $i++)
            <div class="book-card">
                <div class="book-image">
                    <img src="https://via.placeholder.com/200x280/{{ $i % 3 == 0 ? '5B4AB3' : ($i % 2 == 0 ? '322684' : 'E8E6F8') }}/333333?text=Editor+{{ $i }}" alt="Editor Choice {{ $i }}">
                </div>
                <div class="book-info">
                    <h3 class="book-title">Serangai Sibernatik Membentuk Keselarasan</h3>
                    <p class="book-author">Mochamad Yoga Pamungkas</p>
                    <p class="book-price">Rp 75.000</p>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <button class="btn-primary btn-large">Continue</button>
    </div>
</section>
@endsection

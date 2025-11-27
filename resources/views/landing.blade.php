@extends('layouts.app')

@section('title', 'NEXUSTORE - Toko Buku Online Terlengkap')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-slider">
            <div class="hero-slide">
                <div class="hero-content">
                    <span class="hero-badge"><i class="fas fa-book-open"></i> Toko Buku Online #1</span>
                    <h1>Temukan Buku <span class="text-gradient">Impianmu</span> di NEXUSTORE</h1>
                    <p>Jelajahi ribuan koleksi buku dari berbagai genre. Dari novel bestseller hingga buku pendidikan, semua tersedia dengan harga terbaik.</p>
                    <div class="hero-buttons">
                        <a href="#popular" class="btn-primary">Jelajahi Koleksi <i class="fas fa-arrow-right"></i></a>
                        <a href="#about" class="btn-outline">Tentang Kami <i class="fas fa-info-circle"></i></a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">10K+</span>
                            <span class="stat-label">Judul Buku</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">5K+</span>
                            <span class="stat-label">Pelanggan</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">99%</span>
                            <span class="stat-label">Rating</span>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="hero-illustration">
                        <div class="floating-books">
                            <div class="book-float book-1">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="book-float book-2">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="book-float book-3">
                                <i class="fas fa-bookmark"></i>
                            </div>
                        </div>
                        <div class="main-illustration">
                            <i class="fas fa-books"></i>
                            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400&h=300&fit=crop" alt="Books Collection" class="hero-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Most Popular Section -->
<section class="book-section" id="popular">
    <div class="container">
        <div class="section-header">
            <h2>Most <span class="highlight">Popular</span></h2>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="book-grid">
            @php
            $popularBooks = [
                ['title' => 'Atomic Habits', 'author' => 'James Clear', 'price' => 'Rp 99.000', 'cover' => 'https://m.media-amazon.com/images/I/81wgcld4wxL._AC_UF1000,1000_QL80_.jpg'],
                ['title' => 'Deep Work', 'author' => 'Cal Newport', 'price' => 'Rp 89.000', 'cover' => 'https://m.media-amazon.com/images/I/81JJ7fyyKyS._AC_UF1000,1000_QL80_.jpg'],
                ['title' => 'Think and Grow Rich', 'author' => 'Napoleon Hill', 'price' => 'Rp 85.000', 'cover' => 'https://m.media-amazon.com/images/I/71UypkUjStL._AC_UF1000,1000_QL80_.jpg'],
                ['title' => 'How to Win Friends', 'author' => 'Dale Carnegie', 'price' => 'Rp 79.000', 'cover' => 'https://m.media-amazon.com/images/I/71vK0WVQ4rL._AC_UF1000,1000_QL80_.jpg'],
                ['title' => 'The Power of Now', 'author' => 'Eckhart Tolle', 'price' => 'Rp 82.000', 'cover' => 'https://m.media-amazon.com/images/I/714FbKtXS+L._AC_UF1000,1000_QL80_.jpg'],
            ];
            @endphp
            @foreach($popularBooks as $book)
            <div class="book-card">
                <div class="book-image">
                    <img src="{{ $book['cover'] }}" alt="{{ $book['title'] }}">
                </div>
                <div class="book-info">
                    <h3 class="book-title">{{ $book['title'] }}</h3>
                    <p class="book-author">{{ $book['author'] }}</p>
                    <p class="book-price">{{ $book['price'] }}</p>
                </div>
            </div>
            @endforeach
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
            @php
            $topSearchBooks = [
                ['title' => 'Rich Dad Poor Dad', 'author' => 'Robert Kiyosaki', 'price' => 'Rp 95.000', 'cover' => 'https://m.media-amazon.com/images/I/81bsw6fnUiL._AC_UF1000,1000_QL80_.jpg'],
                ['title' => 'The Alchemist', 'author' => 'Paulo Coelho', 'price' => 'Rp 85.000', 'cover' => 'https://m.media-amazon.com/images/I/61HAE8zahLL._AC_UF1000,1000_QL80_.jpg'],
                ['title' => 'Ikigai', 'author' => 'Héctor García', 'price' => 'Rp 89.000', 'cover' => 'https://m.media-amazon.com/images/I/81l3rZK4lnL._AC_UF1000,1000_QL80_.jpg'],
            ];
            @endphp
            @foreach($topSearchBooks as $book)
            <div class="book-card">
                <div class="book-image">
                    <img src="{{ $book['cover'] }}" alt="{{ $book['title'] }}">
                </div>
                <div class="book-info">
                    <h3 class="book-title">{{ $book['title'] }}</h3>
                    <p class="book-author">{{ $book['author'] }}</p>
                    <p class="book-price">{{ $book['price'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="about-section" id="about">
    <div class="container">
        <div class="about-container">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=500" alt="Library" class="about-img-main">
                <div class="about-badge">
                    <h3>5+</h3>
                    <p>Tahun Pengalaman</p>
                </div>
            </div>
            <div class="about-content">
                <h2>Tentang <span class="highlight">NEXUSTORE</span></h2>
                <p>NEXUSTORE adalah toko buku online terpercaya yang berdiri sejak 2019. Kami berkomitmen untuk menyediakan buku-buku berkualitas dengan harga terjangkau untuk semua kalangan pembaca di Indonesia.</p>
                <p>Visi kami adalah menjadi platform terdepan dalam menyebarkan literasi dan pengetahuan melalui buku. Dengan lebih dari 10.000 judul buku dan ribuan pelanggan setia, kami terus berinovasi untuk memberikan pengalaman berbelanja terbaik.</p>
                <div class="about-features">
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Buku Original 100%</span>
                    </div>
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Garansi Kualitas</span>
                    </div>
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pembayaran Aman</span>
                    </div>
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Pengembalian Mudah</span>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="btn-primary">Bergabung Sekarang <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="contact-container">
            <div class="contact-content">
                <h2>Butuh <span class="highlight">Bantuan?</span></h2>
                <p>Kami siap membantu Anda! Jika ada pertanyaan tentang produk, pemesanan, atau hal lainnya, jangan ragu untuk menghubungi kami via WhatsApp.</p>
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-detail">
                            <h4>WhatsApp</h4>
                            <p>+62 813-8808-8171</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-detail">
                            <h4>Jam Operasional</h4>
                            <p>Senin - Sabtu, 09:00 - 21:00</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="contact-detail">
                            <h4>Respon Cepat</h4>
                            <p>Balasan dalam 5-10 menit</p>
                        </div>
                    </div>
                </div>
                <a href="https://wa.me/6281388088171?text=Halo%20NEXUSTORE,%20saya%20ingin%20bertanya%20tentang%20produk%20buku." 
                   class="btn-whatsapp" 
                   target="_blank">
                    <i class="fab fa-whatsapp"></i> Chat Sekarang
                </a>
            </div>
            <div class="contact-illustration">
                <div class="contact-card">
                    <div class="chat-bubble incoming">
                        <p>Halo, ada yang bisa dibantu? 👋</p>
                    </div>
                    <div class="chat-bubble outgoing">
                        <p>Saya mau tanya tentang buku...</p>
                    </div>
                    <div class="chat-bubble incoming">
                        <p>Tentu! Silakan tanyakan apa saja 😊</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

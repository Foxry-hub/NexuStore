<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUSTORE - Toko Buku Online Terbaik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #5B4AB3;
            --secondary-color: #322684;
            --accent-color: #7C6DD8;
            --light-color: #E8E6F8;
            --text-dark: #1a1a1a;
            --text-gray: #666666;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 24px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn-outline {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(91, 74, 179, 0.4);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 56px;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-content h1 span {
            background: linear-gradient(90deg, #FFD700, #FFA500);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 18px;
            color: rgba(255,255,255,0.9);
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
        }

        .btn-hero {
            padding: 16px 36px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s;
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary-color);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .btn-hero-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
        }

        .btn-hero-outline:hover {
            background: white;
            color: var(--primary-color);
        }

        .hero-image {
            position: relative;
        }

        .hero-image img {
            width: 100%;
            max-width: 500px;
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
        }

        .floating-card {
            position: absolute;
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            animation: float 3s ease-in-out infinite;
        }

        .floating-card-1 {
            top: 20%;
            right: -30px;
        }

        .floating-card-2 {
            bottom: 20%;
            left: -30px;
            animation-delay: 1.5s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .floating-card i {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .floating-card h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .floating-card p {
            font-size: 12px;
            color: var(--text-gray);
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background: white;
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 42px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .section-header p {
            font-size: 18px;
            color: var(--text-gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .feature-card {
            text-align: center;
            padding: 40px 25px;
            border-radius: 20px;
            background: var(--light-color);
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(91, 74, 179, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .feature-icon i {
            font-size: 32px;
            color: white;
        }

        .feature-card h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .feature-card p {
            font-size: 14px;
            color: var(--text-gray);
            line-height: 1.6;
        }

        /* About Us Section */
        .about {
            padding: 100px 0;
            background: linear-gradient(180deg, #f8f9fa 0%, white 100%);
        }

        .about-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-image {
            position: relative;
        }

        .about-image-main {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.1);
        }

        .about-badge {
            position: absolute;
            bottom: -20px;
            right: -20px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 25px 35px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 15px 30px rgba(91, 74, 179, 0.3);
        }

        .about-badge h3 {
            font-size: 36px;
            font-weight: 800;
        }

        .about-badge p {
            font-size: 14px;
            opacity: 0.9;
        }

        .about-content h2 {
            font-size: 42px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .about-content h2 span {
            color: var(--primary-color);
        }

        .about-content > p {
            font-size: 16px;
            color: var(--text-gray);
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .about-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .about-feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .about-feature-item i {
            width: 40px;
            height: 40px;
            background: var(--light-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 18px;
        }

        .about-feature-item span {
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Stats Section */
        .stats {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 48px;
            font-weight: 800;
            color: white;
            margin-bottom: 10px;
        }

        .stat-item p {
            font-size: 16px;
            color: rgba(255,255,255,0.8);
        }

        /* Categories Section */
        .categories {
            padding: 100px 0;
            background: white;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
        }

        .category-card {
            text-align: center;
            padding: 30px 15px;
            border-radius: 15px;
            background: #f8f9fa;
            transition: all 0.3s;
            text-decoration: none;
            color: var(--text-dark);
        }

        .category-card:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-5px);
        }

        .category-card i {
            font-size: 36px;
            margin-bottom: 15px;
            color: var(--primary-color);
            transition: color 0.3s;
        }

        .category-card:hover i {
            color: white;
        }

        .category-card h4 {
            font-size: 14px;
            font-weight: 600;
        }

        /* Testimonials */
        .testimonials {
            padding: 100px 0;
            background: var(--light-color);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .testimonial-card {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .testimonial-stars {
            color: #FFD700;
            margin-bottom: 15px;
        }

        .testimonial-text {
            font-size: 15px;
            color: var(--text-gray);
            line-height: 1.8;
            margin-bottom: 20px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
        }

        .testimonial-info h4 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .testimonial-info p {
            font-size: 13px;
            color: var(--text-gray);
        }

        /* CTA Section */
        .cta {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            text-align: center;
        }

        .cta h2 {
            font-size: 42px;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 18px;
            color: rgba(255,255,255,0.9);
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer */
        .footer {
            background: #1a1a2e;
            color: white;
            padding: 60px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-brand h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-brand p {
            font-size: 14px;
            color: rgba(255,255,255,0.7);
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .footer-social {
            display: flex;
            gap: 15px;
        }

        .footer-social a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s;
        }

        .footer-social a:hover {
            background: var(--primary-color);
        }

        .footer-links h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 30px;
            text-align: center;
            font-size: 14px;
            color: rgba(255,255,255,0.5);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-content h1 {
                font-size: 42px;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-image {
                display: none;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .about-container {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .categories-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero-content h1 {
                font-size: 32px;
            }

            .section-header h2 {
                font-size: 32px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .about-features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="logo">
                <span class="logo-icon">N</span>
                <span class="logo-text">NEXUSTORE</span>
            </a>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#features">Fitur</a>
                <a href="#about">Tentang Kami</a>
                <a href="#categories">Kategori</a>
                <a href="#testimonials">Testimoni</a>
            </div>
            <div class="nav-buttons">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/pelanggan/dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Temukan Buku <span>Impianmu</span> di NEXUSTORE</h1>
                <p>Jelajahi ribuan koleksi buku berkualitas dari berbagai genre. Dari novel terlaris hingga buku pendidikan, semua tersedia dengan harga terbaik dan pengiriman cepat ke seluruh Indonesia.</p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn-hero btn-hero-primary">
                        <i class="fas fa-shopping-bag"></i> Mulai Belanja
                    </a>
                    <a href="#about" class="btn-hero btn-hero-outline">
                        <i class="fas fa-info-circle"></i> Pelajari Lebih
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=500" alt="Books Collection">
                <div class="floating-card floating-card-1">
                    <i class="fas fa-book"></i>
                    <h4>10,000+ Buku</h4>
                    <p>Koleksi Lengkap</p>
                </div>
                <div class="floating-card floating-card-2">
                    <i class="fas fa-truck"></i>
                    <h4>Gratis Ongkir</h4>
                    <p>Min. Order 100rb</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-container">
            <div class="section-header">
                <h2>Mengapa Memilih Kami?</h2>
                <p>NEXUSTORE memberikan pengalaman berbelanja buku online terbaik dengan berbagai keunggulan</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3>Koleksi Lengkap</h3>
                    <p>Ribuan judul buku dari berbagai penerbit ternama Indonesia dan internasional</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h3>Harga Terbaik</h3>
                    <p>Dapatkan diskon hingga 50% untuk buku-buku pilihan setiap minggunya</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>Pengiriman Cepat</h3>
                    <p>Pesanan diproses dalam 24 jam dan dikirim ke seluruh Indonesia</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Layanan 24/7</h3>
                    <p>Tim customer service siap membantu kapan saja Anda membutuhkan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about" id="about">
        <div class="section-container">
            <div class="about-container">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=600" alt="Library" class="about-image-main">
                    <div class="about-badge">
                        <h3>5+</h3>
                        <p>Tahun Pengalaman</p>
                    </div>
                </div>
                <div class="about-content">
                    <h2>Tentang <span>NEXUSTORE</span></h2>
                    <p>NEXUSTORE adalah toko buku online terpercaya yang berdiri sejak 2019. Kami berkomitmen untuk menyediakan buku-buku berkualitas dengan harga terjangkau untuk semua kalangan pembaca di Indonesia.</p>
                    <p>Visi kami adalah menjadi platform terdepan dalam menyebarkan literasi dan pengetahuan melalui buku. Dengan lebih dari 10.000 judul buku dan ribuan pelanggan setia, kami terus berinovasi untuk memberikan pengalaman berbelanja terbaik.</p>
                    <div class="about-features">
                        <div class="about-feature-item">
                            <i class="fas fa-check"></i>
                            <span>Buku Original 100%</span>
                        </div>
                        <div class="about-feature-item">
                            <i class="fas fa-check"></i>
                            <span>Garansi Kualitas</span>
                        </div>
                        <div class="about-feature-item">
                            <i class="fas fa-check"></i>
                            <span>Pembayaran Aman</span>
                        </div>
                        <div class="about-feature-item">
                            <i class="fas fa-check"></i>
                            <span>Pengembalian Mudah</span>
                        </div>
                    </div>
                    <a href="{{ route('register') }}" class="btn btn-primary">Bergabung Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="section-container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>10K+</h3>
                    <p>Judul Buku</p>
                </div>
                <div class="stat-item">
                    <h3>50K+</h3>
                    <p>Pelanggan Puas</p>
                </div>
                <div class="stat-item">
                    <h3>100K+</h3>
                    <p>Buku Terjual</p>
                </div>
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Kota Terjangkau</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories" id="categories">
        <div class="section-container">
            <div class="section-header">
                <h2>Kategori Populer</h2>
                <p>Temukan buku sesuai minat dan kebutuhanmu</p>
            </div>
            <div class="categories-grid">
                <a href="#" class="category-card">
                    <i class="fas fa-heart"></i>
                    <h4>Novel Romantis</h4>
                </a>
                <a href="#" class="category-card">
                    <i class="fas fa-user-secret"></i>
                    <h4>Misteri & Thriller</h4>
                </a>
                <a href="#" class="category-card">
                    <i class="fas fa-graduation-cap"></i>
                    <h4>Pendidikan</h4>
                </a>
                <a href="#" class="category-card">
                    <i class="fas fa-child"></i>
                    <h4>Anak-anak</h4>
                </a>
                <a href="#" class="category-card">
                    <i class="fas fa-briefcase"></i>
                    <h4>Bisnis</h4>
                </a>
                <a href="#" class="category-card">
                    <i class="fas fa-brain"></i>
                    <h4>Self-Help</h4>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="section-container">
            <div class="section-header">
                <h2>Apa Kata Mereka?</h2>
                <p>Testimoni dari pelanggan setia NEXUSTORE</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Pelayanan sangat memuaskan! Buku sampai dengan cepat dan dikemas dengan rapi. Pasti akan order lagi di NEXUSTORE."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">AS</div>
                        <div class="testimonial-info">
                            <h4>Andi Setiawan</h4>
                            <p>Jakarta</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Koleksi bukunya lengkap banget! Saya selalu menemukan buku yang saya cari di sini. Harganya juga sangat bersaing."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">DR</div>
                        <div class="testimonial-info">
                            <h4>Dewi Rahayu</h4>
                            <p>Bandung</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Website yang user-friendly dan proses checkout yang mudah. Tim support juga sangat responsif saat saya butuh bantuan."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">BP</div>
                        <div class="testimonial-info">
                            <h4>Budi Prasetyo</h4>
                            <p>Surabaya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="section-container">
            <h2>Siap Mulai Membaca?</h2>
            <p>Daftar sekarang dan dapatkan diskon 20% untuk pembelian pertama Anda!</p>
            <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">
                <i class="fas fa-user-plus"></i> Daftar Gratis
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="section-container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3>
                        <span class="logo-icon" style="width:35px;height:35px;font-size:18px;">N</span>
                        NEXUSTORE
                    </h3>
                    <p>Toko buku online terpercaya dengan koleksi lengkap dan harga terbaik. Kami berkomitmen untuk menyebarkan literasi ke seluruh Indonesia.</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#about">Tentang Kami</a></li>
                        <li><a href="#categories">Kategori</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Cara Order</a></li>
                        <li><a href="#">Pengiriman</a></li>
                        <li><a href="#">Pengembalian</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Kontak</h4>
                    <ul>
                        <li><a href="#"><i class="fas fa-envelope"></i> info@nexustore.com</a></li>
                        <li><a href="#"><i class="fas fa-phone"></i> +62 812 3456 7890</a></li>
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 NEXUSTORE. All rights reserved. Made with <i class="fas fa-heart" style="color:#e74c3c;"></i> in Indonesia</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 2px 30px rgba(0,0,0,0.15)';
            } else {
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            }
        });
    </script>
</body>
</html>

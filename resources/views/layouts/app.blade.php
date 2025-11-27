<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NEXUSTORE - Toko Buku Online')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <div class="navbar-logo">
                    <span class="logo-icon">N</span>
                    <span class="logo-text">NEXUSTORE</span>
                </div>
                
                <div class="navbar-actions">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                    </a>
                    @auth
                        @if(Auth::user()->isPelanggan())
                            <a href="{{ route('keranjang.index') }}" class="nav-link cart-link">
                                <i class="fas fa-shopping-cart"></i>
                                @php
                                    $cartCount = \App\Http\Controllers\KeranjangController::getCartCount();
                                @endphp
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('pesanan.index') }}" class="nav-link">
                                <i class="fas fa-box"></i>
                            </a>
                            <a href="{{ route('pelanggan.profile') }}" class="nav-link">
                                <i class="fas fa-user"></i>
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link-btn">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-user"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <span class="logo-icon">N</span>
                    <span class="logo-text">NEXUSTORE</span>
                </div>
                <div class="footer-links">
                    <a href="#about">About</a>
                    <a href="{{ route('shop.index') }}">Discover</a>
                    <a href="#contact">Contact</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Copyright 2024 NEXUSTORE. All Right Reserved</p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281388088171?text=Halo%20NEXUSTORE,%20saya%20ingin%20bertanya%20tentang%20produk%20buku." 
       class="whatsapp-float" 
       target="_blank" 
       title="Chat via WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-tooltip">Ada pertanyaan? Chat kami!</span>
    </a>

    <style>
    /* Floating WhatsApp Button */
    .whatsapp-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        z-index: 9999;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .whatsapp-float:hover {
        transform: scale(1.1) translateY(-5px);
        box-shadow: 0 8px 30px rgba(37, 211, 102, 0.5);
    }

    .whatsapp-float::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: inherit;
        animation: whatsapp-pulse 2s infinite;
        z-index: -1;
    }

    @keyframes whatsapp-pulse {
        0% {
            transform: scale(1);
            opacity: 0.7;
        }
        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    .whatsapp-tooltip {
        position: absolute;
        right: 75px;
        background: #333;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 14px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        font-family: 'Montserrat', sans-serif;
    }

    .whatsapp-tooltip::after {
        content: '';
        position: absolute;
        right: -8px;
        top: 50%;
        transform: translateY(-50%);
        border: 8px solid transparent;
        border-left-color: #333;
        border-right: none;
    }

    .whatsapp-float:hover .whatsapp-tooltip {
        opacity: 1;
        visibility: visible;
        right: 80px;
    }

    @media (max-width: 576px) {
        .whatsapp-float {
            bottom: 20px;
            right: 20px;
            width: 55px;
            height: 55px;
            font-size: 28px;
        }

        .whatsapp-tooltip {
            display: none;
        }
    }
    </style>

    @stack('scripts')
</body>
</html>

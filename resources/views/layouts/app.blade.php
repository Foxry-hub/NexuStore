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
                    <a href="#" class="nav-link">
                        <i class="fas fa-heart"></i>
                    </a>
                    @auth
                        @if(Auth::user()->isPelanggan())
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
                    <a href="#">About</a>
                    <a href="#">Discover</a>
                    <a href="#">Payment</a>
                    <a href="#">Contact</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Copyright 2024 NEXUSTORE. All Right Reserved</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

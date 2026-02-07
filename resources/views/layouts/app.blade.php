<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ClothesZC - Boutique de Mode')</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Raleway:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS pour la pagination -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== VARIABLES ===== */
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #e94560;
            --accent-light: #ff6b6b;
            --light: #f8f9fa;
            --dark: #0f0f1a;
            --gray: #6c757d;
            --gray-light: #e9ecef;
            --white: #ffffff;
            --gold: #d4af37;
            --shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 20px 60px rgba(0, 0, 0, 0.15);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== RESET ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Raleway', sans-serif;
            font-size: 16px;
            line-height: 1.7;
            color: var(--dark);
            background: var(--white);
            overflow-x: hidden;
            padding-top: 90px; /* Espace pour le header fixe */
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        img {
            max-width: 100%;
            height: auto;
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ===== HEADER ===== */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: var(--primary); /* Fond par défaut */
            transition: var(--transition);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header.scrolled {
            background: var(--white);
            box-shadow: var(--shadow);
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo img {
            height: 55px;
            width: auto;
            border-radius: 8px;
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white);
            transition: var(--transition);
        }

        .header.scrolled .logo-text {
            color: var(--primary);
        }

        .logo-text span {
            color: var(--accent);
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .nav-link {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--white);
            position: relative;
            padding: 8px 0;
        }

        .header.scrolled .nav-link {
            color: var(--dark);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: var(--transition);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--accent);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            background: rgba(255, 255, 255, 0.1);
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .header.scrolled .header-btn {
            color: var(--dark);
            background: var(--gray-light);
        }

        .header-btn:hover {
            background: var(--accent);
            color: var(--white);
            transform: scale(1.1);
        }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 10px;
        }

        .mobile-toggle span {
            width: 25px;
            height: 2px;
            background: var(--white);
            transition: var(--transition);
        }

        .header.scrolled .mobile-toggle span {
            background: var(--dark);
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 32px;
            font-family: 'Raleway', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--accent);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--accent-light);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(233, 69, 96, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--accent);
            color: var(--accent);
        }

        .btn-outline:hover {
            background: var(--accent);
            color: var(--white);
        }

        .btn-white {
            background: var(--white);
            color: var(--primary);
        }

        .btn-white:hover {
            background: var(--accent);
            color: var(--white);
            transform: translateY(-3px);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--primary);
            color: var(--white);
            padding: 80px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 50px;
            margin-bottom: 60px;
        }

        .footer-brand p {
            color: rgba(255, 255, 255, 0.7);
            margin: 20px 0;
            font-size: 0.95rem;
            line-height: 1.8;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .footer-social a {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            transition: var(--transition);
        }

        .footer-social a:hover {
            background: var(--accent);
            transform: translateY(-5px);
        }

        .footer-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            margin-bottom: 25px;
            color: var(--white);
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--accent);
            padding-left: 8px;
        }

        .footer-contact p {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .footer-contact i {
            color: var(--accent);
            width: 20px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        /* ===== PRODUCT CARDS ===== */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .product-image {
            position: relative;
            height: 320px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 6px 16px;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-new {
            background: var(--accent);
            color: var(--white);
        }

        .badge-sale {
            background: var(--gold);
            color: var(--dark);
        }

        .product-actions {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            display: flex;
            gap: 10px;
            opacity: 0;
            transition: var(--transition);
        }

        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .action-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: none;
            background: var(--white);
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            background: var(--accent);
            color: var(--white);
            transform: scale(1.15);
        }

        .product-info {
            padding: 25px;
        }

        .product-category {
            color: var(--accent);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 600;
            margin: 10px 0;
            color: var(--dark);
        }

        .product-name a:hover {
            color: var(--accent);
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 15px;
        }

        .price-current {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent);
        }

        .price-old {
            font-size: 1rem;
            color: var(--gray);
            text-decoration: line-through;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 12px;
            color: var(--gold);
            font-size: 0.9rem;
        }

        .product-rating span {
            color: var(--gray);
            margin-left: 5px;
        }

        /* ===== SECTION STYLES ===== */
        .section {
            padding: 100px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-tag {
            display: inline-block;
            background: rgba(233, 69, 96, 0.1);
            color: var(--accent);
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .section-subtitle {
            color: var(--gray);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 160px 0 80px;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
        }

        .page-header p {
            font-size: 1.15rem;
            opacity: 0.9;
            position: relative;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav {
                display: none;
            }

            .mobile-toggle {
                display: flex;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .section-title {
                font-size: 2.2rem;
            }

            .page-header h1 {
                font-size: 2.5rem;
            }
        }

        /* ===== BREADCRUMB ===== */
        .breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: rgba(255, 255, 255, 0.7);
        }

        .breadcrumb a:hover {
            color: var(--accent);
        }

        .breadcrumb span {
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <div class="header-inner">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('logojpeg.jpeg') }}" alt="ClothesZC">
                </a>

                <nav class="nav">
                    <a href="{{ route('home') }}"
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
                    <a href="{{ route('produits.index') }}"
                        class="nav-link {{ request()->routeIs('produits.*') ? 'active' : '' }}">Boutique</a>
                    
                    @auth
                        @if(Auth::user()->isAdmin())
                            {{-- Menu ADMIN --}}
                            <a href="{{ route('produits.manage') }}"
                                class="nav-link {{ request()->routeIs('produits.manage') ? 'active' : '' }}">Gérer Produits</a>
                            <a href="{{ route('espaceadmin') }}"
                                class="nav-link {{ request()->routeIs('espaceadmin') ? 'active' : '' }}">Espace Admin</a>
                        @elseif(Auth::user()->isUser())
                            {{-- Menu USER --}}
                            <a href="{{ route('espaceclient') }}"
                                class="nav-link {{ request()->routeIs('espaceclient') ? 'active' : '' }}">Espace Client</a>
                        @endif
                    @endauth
                    
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">À
                        Propos</a>
                    <a href="{{ route('contact') }}"
                        class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                </nav>

                <div class="header-actions">
                    <button class="header-btn"><i class="fas fa-search"></i></button>
                    
                    <!-- Panier -->
                    <a href="{{ route('cart.index') }}" class="header-btn" style="position: relative;" title="Panier">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                            $cart = Session::get('cart', []);
                            $cartCount = !empty($cart) ? array_sum(array_column($cart, 'quantity')) : 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="cart-count-badge" style="position: absolute; top: -5px; right: -5px; background: var(--accent); color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 11px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    
                    @guest
                        <a href="{{ route('login') }}" class="header-btn" title="Connexion">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                        <a href="{{ route('register') }}" class="header-btn" title="Inscription">
                            <i class="fas fa-user-plus"></i>
                        </a>
                    @else
                        <div style="position: relative; display: inline-block;">
                            <button class="header-btn" id="userMenuBtn" title="{{ Auth::user()->name }}">
                                <i class="fas fa-user"></i>
                            </button>
                            <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 10px; background: white; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); min-width: 200px; z-index: 1000;">
                                <div style="padding: 15px; border-bottom: 1px solid #eee;">
                                    <strong>{{ Auth::user()->name }}</strong>
                                    <br>
                                    <small style="color: #999;">{{ Auth::user()->role }}</small>
                                </div>
                                <a href="{{ route('profile.show') }}" 
                                   style="display: block; padding: 12px 15px; color: #333; transition: all 0.3s;"
                                   onmouseover="this.style.background='#f8f9fa'"
                                   onmouseout="this.style.background='transparent'">
                                    <i class="fas fa-user-edit"></i> Mon Profil
                                </a>
                                <a href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   style="display: block; padding: 12px 15px; color: #e94560; transition: all 0.3s;"
                                   onmouseover="this.style.background='#f8f9fa'"
                                   onmouseout="this.style.background='transparent'">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <div class="mobile-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Messages Flash -->
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('logojpeg.jpeg') }}" alt="ClothesZC">
                    </a>
                    <p>Votre destination mode pour des vêtements tendance et de qualité. Exprimez votre style avec
                        ClothesZC.</p>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4 class="footer-title">Navigation</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="{{ route('produits.index') }}">Boutique</a></li>
                        <li><a href="{{ route('about') }}">À Propos</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-title">Aide</h4>
                    <ul class="footer-links">
                        <li><a href="#">Livraison</a></li>
                        <li><a href="#">Retours</a></li>
                        <li><a href="#">Guide des tailles</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <div class="footer-col footer-contact">
                    <h4 class="footer-title">Contact</h4>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Rue de la Mode, Paris</p>
                    <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
                    <p><i class="fas fa-envelope"></i> contact@clotheszc.com</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} ClothesZC. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function () {
            const header = document.getElementById('header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Menu déroulant utilisateur
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');
        
        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.style.display = userDropdown.style.display === 'none' ? 'block' : 'none';
            });

            // Fermer le menu en cliquant ailleurs
            document.addEventListener('click', function() {
                userDropdown.style.display = 'none';
            });

            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Auto-hide success messages
        window.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000); // 5 seconds
            });
        });
    </script>

    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>
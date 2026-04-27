<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub - Premium Fashion for Everyone</title>
    <meta name="description" content="FashionHub brings curated fashion trends, style guides, and premium wardrobe inspiration for modern shoppers.">
    <meta name="keywords" content="fashion, style, fashion blog, trends, wardrobe, shopping">
    <meta name="robots" content="index, follow">
    <meta name="author" content="FashionHub">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <link rel="icon" type="image/png" href="{{ asset('assets/images/fav-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/fav-icon.png') }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="FashionHub">
    <meta property="og:title" content="FashionHub - Premium Fashion for Everyone">
    <meta property="og:description" content="FashionHub brings curated fashion trends, style guides, and premium wardrobe inspiration for modern shoppers.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/images/logo/logo.png') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="FashionHub - Premium Fashion for Everyone">
    <meta name="twitter:description" content="FashionHub brings curated fashion trends, style guides, and premium wardrobe inspiration for modern shoppers.">
    <meta name="twitter:image" content="{{ asset('assets/images/logo/logo.png') }}">

    @stack('meta')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/common.css') }}">
    @stack('css')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-shopping-bag"></i> FashionHub

                <!-- <img src="logo/logo.png" width="auto" height="54px" alt="FashionHub Logo"
                    class="navbar-logo"> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                <div class="navbar-icons">
                    <a href="#"><i class="fas fa-search"></i></a>
                    <a href="{{ route('login') }}"><i class="fas fa-user"></i></a>
                    <a href="{{ route('wishlist') }}" title="WishList" class="position-relative">
                        <i class="fas fa-heart"></i>
                        @php $wishlistCount = count(session('wishlist', [])); @endphp
                        @if ($wishlistCount > 0)
                            <span class="wishlist-badge">{{ $wishlistCount }}</span>
                        @else
                            <span class="wishlist-badge" style="display:none;">0</span>
                        @endif
                    </a>
                    @php $cartCount = count(session('cart', [])); @endphp
                    <button type="button" class="cart-toggle-btn" data-bs-toggle="offcanvas"
                        data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas" aria-label="Open cart">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge">{{ $cartCount }}</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{ $slot }}

    <!-- Cart Offcanvas -->
    <div class="offcanvas offcanvas-end cart-offcanvas" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header cart-offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">
                <i class="fas fa-shopping-bag me-2"></i>Your Cart
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if ($cartCount > 0)
                <div class="cart-offcanvas-count">{{ $cartCount }} item{{ $cartCount > 1 ? 's' : '' }} added to cart</div>
                <p class="cart-offcanvas-note">Review your selected products and continue to the full cart page.</p>
            @else
                <div class="cart-offcanvas-empty">
                    <div class="cart-offcanvas-empty-icon"><i class="fas fa-shopping-bag"></i></div>
                    <h6>Your cart is empty</h6>
                    <p>Add stylish products from our collections and they will appear here.</p>
                </div>
            @endif

            <div class="cart-offcanvas-actions">
                <a href="{{ route('cart') }}" class="btn btn-primary w-100">View Cart</a>
                <a href="{{ route('shop') }}" class="btn btn-outline w-100 mt-2">Continue Shopping</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><img src="{{ asset('assets/images/logo.png') }}" width="230" alt="FashionHub Logo"></h5>
                    <p>Your premier destination for curated fashion collections. Discover timeless elegance and modern
                        trends, handpicked for you.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-link"></i> Quick Links</h5>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('shop') }}">Shop</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-headset"></i> Support</h5>
                    <ul>
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Shipping Info</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-file-contract"></i> Legal</h5>
                    <ul>
                        <li><a href="{{ route('terms.of.condition') }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-envelope"></i> Contact</h5>
                    <ul>
                        <li>123 Fashion St, NY 10001</li>
                        <li>+1 (555) 123-4567</li>
                        <li>info@fashionhub.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} FashionHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <div class="nav-item">
            <a href="{{ route('shop') }}" class="nav-link">
                <i class="fas fa-store"></i>
                <span>Shop</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('wishlist') }}" class="nav-link">
                <i class="fas fa-heart"></i>
                <span>Wishlist</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-bars"></i>
                <span>Menu</span>
            </a>
        </div>
        <div class="nav-item">
            <button type="button" class="nav-link cart-toggle-btn-mobile" data-bs-toggle="offcanvas"
                data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas" aria-label="Open cart">
                <i class="fas fa-shopping-cart"></i>
                <span class="mobile-nav-badge">{{ $cartCount }}</span>
                <span>Cart</span>
            </button>
        </div>
        <div class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">
                <i class="fas fa-user"></i>
                <span>Account</span>
            </a>
        </div>
    </nav>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('js')
</body>

</html>

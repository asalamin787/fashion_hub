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
                    @php
                        $cartService = app(\App\Services\CartService::class);
                        $cart = $cartService->getCart()->loadMissing('items.product');
                        $cartCount = (int) $cart->items->sum('quantity');
                    @endphp
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
        <div class="offcanvas-header cart-offcanvas-header" style="background: linear-gradient(135deg, #865749 0%, #6d3f35 100%); border-bottom: none;">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel" style="color: white; font-weight: 700; font-size: 18px;">
                <i class="fas fa-shopping-bag me-2"></i>Your Cart
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="padding: 0;">
            <div style="flex: 1; overflow-y: auto;">
                @if ($cartCount > 0)
                    {{-- <div class="cart-offcanvas-count" style="padding: 20px; background: linear-gradient(135deg, rgba(134, 87, 73, 0.1) 0%, rgba(134, 87, 73, 0.05) 100%); border-bottom: 1px solid #eee;">
                        <div style="font-size: 20px; font-weight: 700; color: #865749;">{{ $cartCount }} item{{ $cartCount > 1 ? 's' : '' }}</div>
                        <p class="cart-offcanvas-note" style="margin: 8px 0 0 0; color: #666; font-size: 14px;">added to cart</p>
                    </div> --}}

                    <div style="padding: 16px 14px 12px 14px; max-height: 488px; overflow-y: auto;">
                        @foreach ($cart->items as $item)
                            @php
                                $offcanvasImage = $item->image && !str_starts_with($item->image, 'http')
                                    ? asset('storage/' . ltrim($item->image, '/'))
                                    : $item->image;
                                $offcanvasLineTotal = number_format((float) $item->price * $item->quantity, 2);
                            @endphp

                            <div style="display: flex; gap: 12px; padding: 12px; background: #fff; border: 1px solid #f0e6e1; border-radius: 10px; margin-bottom: 10px;">
                                <div style="width: 64px; height: 64px; border-radius: 8px; overflow: hidden; border: 1px solid #f1e9e5; flex-shrink: 0; background: #fff;">
                                    <img src="{{ $offcanvasImage ?: 'https://via.placeholder.com/64x64?text=Item' }}" alt="{{ $item->product_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>

                                <div style="flex: 1; min-width: 0;">
                                    <p style="margin: 0; color: #2c3e50; font-size: 14px; font-weight: 700; line-height: 1.35;">{{ $item->product_name }}</p>
                                    @if (filled($item->variant_label))
                                        <p style="margin: 3px 0 0 0; color: #7b6a63; font-size: 12px;">{{ $item->variant_label }}</p>
                                    @endif
                                    <div style="margin-top: 8px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                        <span style="font-size: 12px; color: #6c757d;">Qty: {{ $item->quantity }}</span>
                                        <span style="font-size: 13px; color: #865749; font-weight: 700;">${{ $offcanvasLineTotal }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="cart-offcanvas-empty" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px 20px; text-align: center; min-height: 300px;">
                        <div class="cart-offcanvas-empty-icon" style="font-size: 64px; color: #865749; opacity: 0.6; margin-bottom: 16px;"><i class="fas fa-shopping-bag"></i></div>
                        <h6 style="margin: 0 0 8px 0; color: #2c3e50; font-weight: 700; font-size: 16px;">Your cart is empty</h6>
                        <p style="margin: 0; color: #666; font-size: 13px; line-height: 1.6;">Add stylish products from our collections and they will appear here.</p>
                    </div>
                @endif
            </div>

            <div class="cart-offcanvas-actions" style="padding: 20px; border-top: 1px solid #eee; background: #f8f9fa;">
                @if ($cartCount > 0)
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; color: #4b4b4b; font-size: 14px; font-weight: 600;">
                        <span>Subtotal</span>
                        <span style="color: #865749; font-size: 16px; font-weight: 800;">${{ number_format((float) $cart->items->sum(fn($cartItem) => (float) $cartItem->price * $cartItem->quantity), 2) }}</span>
                    </div>
                @endif
                <a href="{{ route('cart') }}" class="btn btn-primary w-100" style="background-color: #865749; border: none; padding: 12px; font-weight: 600; border-radius: 4px; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#6d3f35'" onmouseout="this.style.backgroundColor='#865749'">View Full Cart</a>
                <a href="{{ route('shop') }}" class="btn btn-outline w-100 mt-2" style="border: 2px solid #865749; color: #865749; padding: 10px; font-weight: 600; border-radius: 4px; background: white; text-decoration: none; display: block; text-align: center; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f5f0ee'" onmouseout="this.style.backgroundColor='white'">Continue Shopping</a>
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

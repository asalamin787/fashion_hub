@php
    $socialLinks = \App\Models\Setting::group('social');
    $siteLinks = \App\Models\Setting::group('site');
    $seoLinks = \App\Models\Setting::group('seo');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoLinks->get('meta_title') ?? 'FashionHub - Premium Fashion for Everyone' }}</title>
    <meta name="description"
        content="{{ $seoLinks->get('meta_description') ?? 'FashionHub brings curated fashion trends, style guides, and premium wardrobe inspiration for modern shoppers.' }}">
    <meta name="keywords" content="{{ $seoLinks->get('meta_keywords') ?? 'fashion, style, fashion blog, trends, wardrobe, shopping' }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="FashionHub">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="icon" type="image/png"
        href="{{ Storage::url($siteLinks->get('favicon') ?? 'assets/images/fav-icon.png') }}">
    <link rel="shortcut icon" href="{{ Storage::url($siteLinks->get('favicon') ?? 'assets/images/fav-icon.png') }}">
    <link rel="apple-touch-icon" href="{{ Storage::url($siteLinks->get('favicon') ?? 'assets/images/fav-icon.png') }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="FashionHub">
    <meta property="og:title" content="{{ $seoLinks->get('meta_title') ?? 'FashionHub - Premium Fashion for Everyone' }}">
    <meta property="og:description"
        content="{{ $seoLinks->get('meta_description') ?? 'FashionHub brings curated fashion trends, style guides, and premium wardrobe inspiration for modern shoppers.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ Storage::url($siteLinks->get('og_image') ?? 'assets/images/logo/logo.png') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="FashionHub - Premium Fashion for Everyone">
    <meta name="twitter:description"
        content="FashionHub brings curated fashion trends, style guides, and premium wardrobe inspiration for modern shoppers.">
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
                {{-- <i class="fas fa-shopping-bag"></i> FashionHub --}}

                <img src="{{ Storage::url($siteLinks->get('nav_logo') ?? 'assets/images/logo/logo.png') }}"
                    width="auto" height="54px" alt="FashionHub Logo" class="navbar-logo">
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
                    <a href="{{ auth()->check() ? route('account.dashboard') : route('login') }}"><i
                            class="fas fa-user"></i></a>
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

    {{-- <div class="container">
        <x-flash-messages />
    </div> --}}

    {{ $slot }}

    <!-- Cart Offcanvas -->
    <div class="offcanvas offcanvas-end cart-offcanvas" tabindex="-1" id="cartOffcanvas"
        aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header cart-offcanvas-header"
            style="background: linear-gradient(135deg, #865749 0%, #6d3f35 100%); border-bottom: none;">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel"
                style="color: white; font-weight: 700; font-size: 18px;">
                <i class="fas fa-shopping-bag me-2"></i>Your Cart
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="cart-offcanvas-content" data-cart-offcanvas-content>
            @include('components.cart-offcanvas-content', ['cart' => $cart, 'cartCount' => $cartCount])
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><img src="{{ Storage::url($siteLinks->get('footer_logo') ?? 'assets/images/logo/logo.png') }}"
                            width="230" alt="FashionHub Logo"></h5>
                    <p>Your premier destination for curated fashion collections. Discover timeless elegance and modern
                        trends, handpicked for you.</p>

                    <div class="footer-social">
                        @if ($socialLinks->get('facebook'))
                            <a href="{{ $socialLinks->get('facebook') }}" aria-label="Facebook" target="_blank"
                                rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if ($socialLinks->get('instagram'))
                            <a href="{{ $socialLinks->get('instagram') }}" aria-label="Instagram" target="_blank"
                                rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if ($socialLinks->get('twitter'))
                            <a href="{{ $socialLinks->get('twitter') }}" aria-label="Twitter" target="_blank"
                                rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if ($socialLinks->get('pinterest'))
                            <a href="{{ $socialLinks->get('pinterest') }}" aria-label="Pinterest" target="_blank"
                                rel="noopener noreferrer"><i class="fab fa-pinterest"></i></a>
                        @endif
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
                        <li><a href="{{ auth()->check() ? route('account.orders') : route('login') }}">Track Order</a>
                        </li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Shipping Info</a></li>
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-file-contract"></i> Legal</h5>
                    <ul>
                        <li><a href="{{ route('terms.of.condition') }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('cookie.policy') }}">Cookie Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5><i class="fas fa-envelope"></i> Contact</h5>
                    <ul>
                        <li>{{ $siteLinks->get('address') ?? '123 Fashion St, NY 10001' }}</li>
                        <li>{{ $siteLinks->get('phone') ?? '+1 (555) 123-4567' }}</li>
                        <li>{{ $siteLinks->get('site-email') ?? 'info@fashionhub.com' }}</li>
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
            <a href="{{ auth()->check() ? route('account.dashboard') : route('login') }}" class="nav-link">
                <i class="fas fa-user"></i>
                <span>Account</span>
            </a>
        </div>
    </nav>

    <!-- Toast Notifications -->
    <div id="toastContainer" aria-live="polite" aria-atomic="true"></div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        #toastContainer {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
            max-width: 340px;
        }

        .fh-toast {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.18);
            pointer-events: auto;
            animation: fhToastIn 0.3s ease;
            min-width: 240px;
        }

        .fh-toast.fh-toast-success {
            background: linear-gradient(135deg, #865749, #6d3f35);
        }

        .fh-toast.fh-toast-error {
            background: linear-gradient(135deg, #dc3545, #b02030);
        }

        .fh-toast.fh-toast-info {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
        }

        .fh-toast.fh-toast-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .fh-flash-stack {
            display: grid;
            gap: 12px;
        }

        .fh-inline-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 18px;
            border-radius: 18px;
            border: 1px solid transparent;
            box-shadow: 0 14px 30px rgba(63, 34, 26, 0.08);
            background: #fff;
        }

        .fh-inline-alert-icon {
            font-size: 18px;
            line-height: 1;
            margin-top: 2px;
        }

        .fh-inline-alert-copy {
            flex: 1;
            color: #4a342f;
            font-size: 14px;
            line-height: 1.6;
        }

        .fh-inline-alert-success {
            background: #f5f0ec;
            border-color: rgba(134, 87, 73, 0.2);
        }

        .fh-inline-alert-success .fh-inline-alert-icon {
            color: #865749;
        }

        .fh-inline-alert-error {
            background: #fff4f4;
            border-color: rgba(220, 53, 69, 0.18);
        }

        .fh-inline-alert-error .fh-inline-alert-icon {
            color: #dc3545;
        }

        .fh-inline-alert-warning {
            background: #fff9ed;
            border-color: rgba(245, 158, 11, 0.2);
        }

        .fh-inline-alert-warning .fh-inline-alert-icon {
            color: #d97706;
        }

        .fh-inline-alert-info {
            background: #f4f8ff;
            border-color: rgba(13, 110, 253, 0.18);
        }

        .fh-inline-alert-info .fh-inline-alert-icon {
            color: #0d6efd;
        }

        .fh-toast-icon {
            font-size: 16px;
            flex-shrink: 0;
        }

        .fh-toast-msg {
            flex: 1;
            line-height: 1.4;
        }

        .fh-toast-fade {
            opacity: 0;
            transition: opacity 0.35s ease;
        }

        @keyframes fhToastIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    <script>
        window.showToast = function(message, type) {
            type = type || 'success';

            const container = document.getElementById('toastContainer');

            if (!container) {
                return;
            }

            const iconMap = {
                success: '✓',
                error: '✕',
                info: 'ℹ',
                warning: '!'
            };
            const toast = document.createElement('div');
            toast.className = 'fh-toast fh-toast-' + type;
            toast.innerHTML =
                '<span class="fh-toast-icon">' + (iconMap[type] || '✓') + '</span>' +
                '<span class="fh-toast-msg">' + message + '</span>';

            container.appendChild(toast);

            setTimeout(function() {
                toast.classList.add('fh-toast-fade');
                setTimeout(function() {
                    toast.remove();
                }, 370);
            }, 3000);
        };

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-flash-toast="true"]').forEach(function(element) {
                const message = element.getAttribute('data-flash-message');
                const type = element.getAttribute('data-flash-type') || 'info';

                if (message) {
                    window.showToast(message, type);
                }
            });
        });
    </script>

    <script>
        document.addEventListener('submit', async function(event) {
            const form = event.target.closest('.ajax-add-to-cart-form');

            if (!form) {
                return;
            }

            event.preventDefault();

            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonHtml = submitButton ? submitButton.innerHTML : null;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new FormData(form),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Unable to add product to cart.');
                }

                document.querySelectorAll('.cart-badge, .mobile-nav-badge').forEach(function(element) {
                    element.textContent = data.cart_count ?? 0;
                });

                document.querySelectorAll('.wishlist-badge').forEach(function(element) {
                    const wishlistCount = data.wishlist_count ?? 0;
                    element.textContent = wishlistCount;
                    element.style.display = wishlistCount > 0 ? 'inline-flex' : 'none';
                });

                const offcanvasContent = document.querySelector('[data-cart-offcanvas-content]');

                if (offcanvasContent && data.cart_offcanvas_html) {
                    offcanvasContent.innerHTML = data.cart_offcanvas_html;
                }

                window.showToast(data.message || 'Product added to cart.', 'success');

                if (data.removed_from_wishlist && data.product_id) {
                    document.querySelectorAll(`.wishlist-toggle-btn[data-product-id="${data.product_id}"] i`)
                        .forEach(function(icon) {
                            icon.classList.add('far');
                            icon.classList.remove('fas');
                        });

                    const wishlistItem = document.querySelector(
                        `.wishlist-item[data-product-id="${data.product_id}"]`);

                    if (wishlistItem) {
                        wishlistItem.style.transition = 'opacity 0.3s';
                        wishlistItem.style.opacity = '0';

                        setTimeout(function() {
                            wishlistItem.remove();

                            if (typeof updateWishlistCount === 'function') {
                                updateWishlistCount();
                            }
                        }, 300);
                    }
                }
            } catch (error) {
                console.error('Cart add failed:', error);
                window.showToast(error.message || 'Unable to add product to cart.', 'error');
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonHtml;
                }
            }
        });
    </script>

    @stack('js')
</body>

</html>

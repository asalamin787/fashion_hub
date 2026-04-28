<x-app>
    @push('meta')
        <title>My Wishlist | FashionHub</title>
        <meta name="description" content="Your saved favourite items on FashionHub.">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/wishlist.css') }}">
    @endpush

    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-heart"></i> My Wishlist</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Wishlist</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Wishlist Section -->
    <section class="wishlist-section">
        <div class="container">
            @if ($products->isNotEmpty())
                <div class="wishlist-header">
                    <div class="wishlist-summary">
                        <h4>Your Saved Items</h4>
                        <div class="wishlist-count">
                            <strong>{{ $products->count() }}</strong> {{ Str::plural('item', $products->count()) }} in your wishlist
                        </div>
                    </div>
                    <div class="wishlist-actions">
                        <button class="btn btn-outline clear-wishlist-btn" id="clearWishlistBtn">
                            <i class="fas fa-trash"></i> Clear All
                        </button>
                    </div>
                </div>

                <div class="wishlist-products-grid" id="wishlistGrid">
                    @foreach ($products as $product)
                        <div class="wishlist-item" data-product-id="{{ $product->id }}">
                            <div class="wishlist-card product-card">
                                <button class="remove-btn wishlist-toggle-btn"
                                    data-product-id="{{ $product->id }}"
                                    data-toggle-url="{{ route('wishlist.toggle', $product) }}"
                                    title="Remove from wishlist"
                                    aria-label="Remove from wishlist">
                                    <i class="fas fa-times"></i>
                                </button>

                                <div class="wishlist-image product-image">
                                    <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">

                                    @if (filled($product->badge))
                                        <span class="product-badge">{{ $product->badge }}</span>
                                    @endif

                                    <div class="product-overlay">
                                        <a href="{{ route('product.details', $product) }}"
                                            class="btn btn-sm btn-primary product-action-btn"
                                            aria-label="Quick view">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($product->has_variants)
                                            <a href="{{ route('product.details', $product) }}"
                                                class="btn btn-sm btn-secondary product-action-btn"
                                                aria-label="Select options">
                                                <i class="fas fa-cart-plus"></i>
                                            </a>
                                        @else
                                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline-block ajax-add-to-cart-form">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-sm btn-secondary product-action-btn"
                                                    aria-label="Add to cart">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <div class="wishlist-content product-info">
                                    @if ($product->category)
                                        <span class="product-category-label">{{ $product->category->name }}</span>
                                    @endif
                                    <h5 class="wishlist-title product-title">
                                        <a href="{{ route('product.details', $product) }}">{{ $product->name }}</a>
                                    </h5>
                                    <div class="wishlist-price product-price">
                                        ${{ number_format((float) ($product->sale_price ?? $product->base_price ?? 0), 2) }}
                                        @if ((float) ($product->sale_price ?? 0) > 0 && (float) ($product->base_price ?? 0) > (float) ($product->sale_price ?? 0))
                                            <span class="product-price-old">${{ number_format((float) $product->base_price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-wishlist-content">
                    <div class="empty-wishlist-icon">
                        <i class="far fa-heart"></i>
                    </div>
                    <h2>Your Wishlist is Empty</h2>
                    <p>Save your favourite items here to buy them later.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </section>

    @push('js')
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function renderEmptyWishlistState() {
                const template = document.getElementById('emptyWishlistTemplate');
                const container = document.querySelector('.wishlist-section .container');

                if (template && container) {
                    container.innerHTML = template.innerHTML;
                }
            }

            async function toggleWishlist(url, btnEl) {
                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                    });
                    const data = await res.json();

                    // Update navbar badge count
                    document.querySelectorAll('.wishlist-badge').forEach(el => {
                        el.textContent = data.count;
                        el.style.display = data.count > 0 ? 'inline-flex' : 'none';
                    });

                    // Remove card from page
                    if (!data.in_wishlist && btnEl) {
                        const colEl = btnEl.closest('.wishlist-item');
                        colEl.style.transition = 'opacity 0.3s';
                        colEl.style.opacity = '0';
                        setTimeout(() => {
                            colEl.remove();
                            updateWishlistCount();
                        }, 300);
                    }
                } catch (e) {
                    console.error('Wishlist toggle failed:', e);
                }
            }

            function updateWishlistCount() {
                const items = document.querySelectorAll('.wishlist-item');
                const countEl = document.querySelector('.wishlist-count');
                if (countEl) {
                    const n = items.length;
                    countEl.innerHTML = `<strong>${n}</strong> ${n === 1 ? 'item' : 'items'} in your wishlist`;
                }
                if (items.length === 0) {
                    renderEmptyWishlistState();
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.wishlist-toggle-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        toggleWishlist(this.dataset.toggleUrl, this);
                    });
                });

                const clearBtn = document.getElementById('clearWishlistBtn');
                if (clearBtn) {
                    clearBtn.addEventListener('click', async function () {
                        const btns = [...document.querySelectorAll('.wishlist-toggle-btn')];
                        for (const btn of btns) {
                            await toggleWishlist(btn.dataset.toggleUrl, btn);
                        }
                    });
                }
            });
        </script>
    @endpush

    <template id="emptyWishlistTemplate">
        <div class="empty-wishlist-content">
            <div class="empty-wishlist-icon">
                <i class="far fa-heart"></i>
            </div>
            <h2>Your Wishlist is Empty</h2>
            <p>Save your favourite items here to buy them later.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> Start Shopping
            </a>
        </div>
    </template>
</x-app>
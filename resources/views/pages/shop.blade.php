<x-app>
    @push('meta')
        <title>Shop Collection | FashionHub</title>
        <meta name="description"
            content="Browse FashionHub's curated collection of premium clothing, accessories, bags, and shoes for every style.">
        <meta name="keywords" content="fashion shop, premium clothing, fashion accessories, bags, shoes">
        <meta property="og:title" content="Shop Collection | FashionHub">
        <meta property="og:description"
            content="Browse FashionHub's curated collection of premium clothing, accessories, bags, and shoes for every style.">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:type" content="website">
        <meta name="twitter:title" content="Shop Collection | FashionHub">
        <meta name="twitter:description"
            content="Browse FashionHub's curated collection of premium clothing, accessories, bags, and shoes for every style.">
    @endpush

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
    @endpush

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Shop Our Collection</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <button class="filter-toggle-btn" onclick="toggleFilter()">
                <i class="fas fa-filter"></i> Filter Products
            </button>

            <div class="filter-overlay" onclick="toggleFilter()"></div>

            <div class="row">
                <!-- Filter Sidebar -->
                <div class="col-lg-3">
                    <div class="filter-sidebar">
                        <h4 class="filter-title">Filters</h4>

                        <form id="filterForm" method="GET" action="{{ route('shop') }}">
                            <!-- Category Filter -->
                            <div class="filter-section">
                                <h6>Category</h6>
                                @forelse ($categories as $category)
                                    <div class="filter-option">
                                        <input type="checkbox" id="cat{{ $category->id }}" name="categories[]"
                                            value="{{ $category->slug }}"
                                            {{ in_array($category->slug, $selectedCategories, true) ? 'checked' : '' }}>
                                        <label for="cat{{ $category->id }}">{{ $category->name }}
                                            ({{ $category->products_count }})</label>
                                    </div>
                                @empty
                                    <p class="text-muted small">No categories available</p>
                                @endforelse
                            </div>

                            <!-- Price Filter -->
                            <div class="filter-section">
                                <h6>Price Range</h6>
                                <div class="price-range">
                                    <input type="number" name="min_price" placeholder="Min"
                                        value="{{ $selectedMinPrice ?? '' }}" min="0">
                                    <span>-</span>
                                    <input type="number" name="max_price" placeholder="Max"
                                        value="{{ $selectedMaxPrice ?? '' }}" min="0">
                                </div>
                            </div>

                            <!-- Badge Filter -->
                            <div class="filter-section">
                                <h6>Product Type</h6>
                                @forelse ($availableBadges as $badge)
                                    <div class="filter-option">
                                        <input type="checkbox" id="badge{{ $loop->index }}" name="badges[]"
                                            value="{{ $badge }}"
                                            {{ in_array($badge, $selectedBadges) ? 'checked' : '' }}>
                                        <label for="badge{{ $loop->index }}">{{ $badge }}</label>
                                    </div>
                                @empty
                                    <p class="text-muted small">No badges available</p>
                                @endforelse
                            </div>

                            <!-- Brand Filter -->
                            <div class="filter-section">
                                <h6>Brand</h6>
                                @forelse ($brands as $brand)
                                    <div class="filter-option">
                                        <input type="checkbox" id="brand{{ $brand->id }}" name="brands[]"
                                            value="{{ $brand->id }}"
                                            {{ in_array($brand->id, $selectedBrands) ? 'checked' : '' }}>
                                        <label for="brand{{ $brand->id }}">{{ $brand->name }}</label>
                                    </div>
                                @empty
                                    <p class="text-muted small">No brands available</p>
                                @endforelse
                            </div>

                            <div class="filter-apply">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                <a href="{{ route('shop') }}" class="btn btn-light filter-reset">Reset All</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <!-- Products Header -->
                    <div class="products-header">
                        <div class="products-count">
                            Showing
                            <strong>{{ ($products->currentPage() - 1) * $products->perPage() + 1 }}</strong>-<strong>{{ min($products->currentPage() * $products->perPage(), $products->total()) }}</strong>
                            of <strong>{{ $products->total() }}</strong> products
                        </div>
                        <div class="products-sort">
                            <label>Sort by:</label>
                            <select
                                onchange="const params = new URLSearchParams(window.location.search); params.set('sort_by', this.value); window.location = '{{ route('shop') }}?' + params.toString();">
                                <option value="featured" {{ $sortBy === 'featured' ? 'selected' : '' }}>Featured
                                </option>
                                <option value="price_low" {{ $sortBy === 'price_low' ? 'selected' : '' }}>Price: Low to
                                    High</option>
                                <option value="price_high" {{ $sortBy === 'price_high' ? 'selected' : '' }}>Price: High
                                    to Low</option>
                                <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="best_selling" {{ $sortBy === 'best_selling' ? 'selected' : '' }}>Best
                                    Selling</option>
                                <option value="top_rated" {{ $sortBy === 'top_rated' ? 'selected' : '' }}>Top Rated
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="products-grid">
                        @forelse ($products as $product)
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">
                                    @if (filled($product->badge))
                                        <span class="product-badge">{{ $product->badge }}</span>
                                    @endif
                                    <div class="product-overlay">
                                        <a href="{{ route('product.details', $product) }}"
                                            class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($product->has_variants)
                                            <a href="{{ route('product.details', $product) }}"
                                                class="btn btn-sm btn-secondary product-action-btn"
                                                aria-label="Select options">
                                                <i class="fas fa-cart-plus"></i>
                                            </a>
                                        @else
                                            <form action="{{ route('cart.add') }}" method="POST"
                                                class="d-inline-block ajax-add-to-cart-form">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                    class="btn btn-sm btn-secondary product-action-btn"
                                                    aria-label="Add to cart">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button"
                                            class="btn btn-sm btn-secondary product-action-btn wishlist-toggle-btn"
                                            data-product-id="{{ $product->id }}"
                                            data-toggle-url="{{ route('wishlist.toggle', $product) }}"
                                            aria-label="Add to wishlist">
                                            <i
                                                class="{{ in_array($product->id, session('wishlist', [])) ? 'fas' : 'far' }} fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h5 class="product-title">{{ $product->name }}</h5>
                                    <div class="product-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <div class="product-price">
                                        ${{ number_format((float) ($product->sale_price ?? ($product->base_price ?? 0)), 2) }}
                                        @if (
                                            (float) ($product->sale_price ?? 0) > 0 &&
                                                (float) ($product->base_price ?? 0) > (float) ($product->sale_price ?? 0))
                                            <span
                                                class="product-price-old">${{ number_format((float) $product->base_price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="shop-empty-state">
                                <div class="shop-empty-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h4>No Products Found</h4>
                                <p>Your selected filters did not match any products. Try resetting filters or broadening
                                    your search.</p>
                                <a href="{{ route('shop') }}" class="btn btn-primary">Reset Filters</a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        <nav aria-label="Page navigation">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            function toggleFilter() {
                const sidebar = document.querySelector('.filter-sidebar');
                const overlay = document.querySelector('.filter-overlay');
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }

            // Handle filter form auto-submit on checkbox change
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.getElementById('filterForm');
                if (filterForm) {
                    const filterInputs = filterForm.querySelectorAll('input[type="checkbox"], input[type="number"]');
                    filterInputs.forEach(input => {
                        input.addEventListener('change', function() {
                            filterForm.submit();
                        });
                    });
                }

                // Wishlist toggle buttons
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                document.querySelectorAll('.wishlist-toggle-btn').forEach(btn => {
                    btn.addEventListener('click', async function(e) {
                        e.preventDefault();
                        const icon = this.querySelector('i');
                        try {
                            const res = await fetch(this.dataset.toggleUrl, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                },
                            });
                            const data = await res.json();

                            // Toggle heart icon filled/outline
                            icon.classList.toggle('fas', data.in_wishlist);
                            icon.classList.toggle('far', !data.in_wishlist);

                            // Update navbar badge
                            document.querySelectorAll('.wishlist-badge').forEach(el => {
                                el.textContent = data.count;
                                el.style.display = data.count > 0 ? 'inline-flex' : 'none';
                            });
                        } catch (e) {
                            console.error('Wishlist toggle failed:', e);
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app>

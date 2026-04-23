<x-app>
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
            <!-- Wishlist Count -->
            <div class="wishlist-header">
                <h4>Your Saved Items <span class="wishlist-count">(6 Items)</span></h4>
                <button class="btn btn-outline clear-wishlist-btn">
                    <i class="fas fa-trash"></i> Clear All
                </button>
            </div>

            <!-- Wishlist Grid -->
            <div class="row g-4">
                <!-- Wishlist Item 1 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="wishlist-card product-card">
                        <button class="remove-btn" title="Remove from wishlist">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="wishlist-image product-image">
                            <img src="https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?w=400"
                                alt="Product">
                            <span class="badge-sale">-20%</span>
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 1]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="wishlist-content product-info">
                            <h5 class="wishlist-title product-title">Classic Leather Jacket</h5>
                            <div class="wishlist-rating product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(4.5)</span>
                            </div>
                            <div class="wishlist-price product-price">
                                <span class="current-price">$159.99</span>
                                <span class="original-price product-price-old">$199.99</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Item 2 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="wishlist-card product-card">
                        <button class="remove-btn" title="Remove from wishlist">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="wishlist-image product-image">
                            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400"
                                alt="Product">
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 2]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="wishlist-content product-info">
                            <h5 class="wishlist-title product-title">Elegant Summer Dress</h5>
                            <div class="wishlist-rating product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <div class="wishlist-price product-price">
                                <span class="current-price">$89.99</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Item 3 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="wishlist-card product-card">
                        <button class="remove-btn" title="Remove from wishlist">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="wishlist-image product-image">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400" alt="Product">
                            <span class="badge-new">New</span>
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 3]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="wishlist-content product-info">
                            <h5 class="wishlist-title product-title">Premium Running Shoes</h5>
                            <div class="wishlist-rating product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(4.0)</span>
                            </div>
                            <div class="wishlist-price product-price">
                                <span class="current-price">$129.99</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Item 4 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="wishlist-card product-card">
                        <button class="remove-btn" title="Remove from wishlist">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="wishlist-image product-image">
                            <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400" alt="Product">
                            <span class="badge-sale">-30%</span>
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 4]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="wishlist-content product-info">
                            <h5 class="wishlist-title product-title">Designer Handbag</h5>
                            <div class="wishlist-rating product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(4.7)</span>
                            </div>
                            <div class="wishlist-price product-price">
                                <span class="current-price">$209.99</span>
                                <span class="original-price product-price-old">$299.99</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Item 5 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="wishlist-card product-card">
                        <button class="remove-btn" title="Remove from wishlist">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="wishlist-image product-image">
                            <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400"
                                alt="Product">
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 5]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="wishlist-content product-info">
                            <h5 class="wishlist-title product-title">Stylish Sunglasses</h5>
                            <div class="wishlist-rating product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <div class="wishlist-price product-price">
                                <span class="current-price">$49.99</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Item 6 -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="wishlist-card product-card">
                        <button class="remove-btn" title="Remove from wishlist">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="wishlist-image product-image">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400"
                                alt="Product">
                            <span class="badge-sale">-15%</span>
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 6]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
                                    <i class="fas fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="wishlist-content product-info">
                            <h5 class="wishlist-title product-title">Luxury Wristwatch</h5>
                            <div class="wishlist-rating product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(4.6)</span>
                            </div>
                            <div class="wishlist-price product-price">
                                <span class="current-price">$339.99</span>
                                <span class="original-price product-price-old">$399.99</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Empty Wishlist State (Hidden by default, show when wishlist is empty) -->
    <section class="empty-wishlist-section" style="display: none;">
        <div class="container">
            <div class="empty-wishlist-content">
                <div class="empty-wishlist-icon">
                    <i class="far fa-heart"></i>
                </div>
                <h2>Your Wishlist is Empty</h2>
                <p>Save your favorite items here to buy them later or share with friends.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i> Start Shopping
                </a>
            </div>
        </div>
    </section>
</x-app>

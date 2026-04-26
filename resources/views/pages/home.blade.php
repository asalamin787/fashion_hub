<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    @endpush

    <!-- Hero Carousel -->
    <section class="hero-carousel">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($sliders as $index => $slide)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($sliders as $index => $slide)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="hero-slide"
                            style="background-image: linear-gradient(rgba(45, 35, 38, 0.7), rgba(71, 61, 67, 0.7)), url('{{ $slide->background_image_url }}');">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="hero-content">
                                            @if (!empty($slide->subtitle))
                                                <p class="hero-subtitle">{{ $slide->subtitle }}</p>
                                            @endif
                                            <h1 class="hero-title">{{ $slide->title }}</h1>
                                            @if (!empty($slide->description))
                                                <p class="hero-description">{{ $slide->description }}</p>
                                            @endif
                                            <div class="hero-buttons">
                                                @if (!empty($slide->primary_button_text))
                                                    <a href="{{ $slide->primary_button_link ?: route('shop') }}"
                                                        class="btn btn-primary">{{ $slide->primary_button_text }}</a>
                                                @endif
                                                @if (!empty($slide->secondary_button_text))
                                                    <a href="{{ $slide->secondary_button_link ?: route('shop') }}"
                                                        class="btn btn-outline"
                                                        style="border: 2px solid rgba(255, 255, 255, 0.7); color: rgba(255, 255, 255, 0.7);">{{ $slide->secondary_button_text }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Shop by Category Slider Section -->
    <section class="shop-categories-section">
        <div class="container">
            <div class="section-title">
                <h2>Shop by Category</h2>
                <p>Explore our fashion collections</p>
            </div>
            @php($categorySlides = $homeCategories->chunk(4))
            <div id="categoriesCarousel" class="carousel slide category-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($categorySlides as $slide)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row">
                                @foreach ($slide as $category)
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="category-item-card">
                                            <div class="category-item-image"
                                                style="background-image: url('{{ $category->image_url }}');">
                                                <div class="category-item-overlay">
                                                    <div class="category-item-content">
                                                        <i class="{{ $category->icon ?: 'fas fa-tag' }} category-item-icon"></i>
                                                        <h3 class="category-item-title">{{ $category->name }}</h3>
                                                        <p class="category-item-count">
                                                            {{ number_format((int) $category->products_count) }}
                                                            {{ (int) $category->products_count === 1 ? 'Product' : 'Products' }}
                                                        </p>
                                                        <span class="category-item-btn">Shop Now <i
                                                                class="fas fa-arrow-right"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Carousel Controls -->
                @if ($categorySlides->count() > 1)
                    <button class="carousel-control-prev category-carousel-control-prev" type="button"
                        data-bs-target="#categoriesCarousel" data-bs-slide="prev">
                        <i class="fas fa-chevron-left"></i>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next category-carousel-control-next" type="button"
                        data-bs-target="#categoriesCarousel" data-bs-slide="next">
                        <i class="fas fa-chevron-right"></i>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif

                <!-- Carousel Indicators -->
                @if ($categorySlides->count() > 1)
                    <div class="carousel-indicators category-carousel-indicators">
                        @foreach ($categorySlides as $slide)
                            <button type="button" data-bs-target="#categoriesCarousel"
                                data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>
                <p>Handpicked items just for you</p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400"
                                alt="Product">
                            <span class="product-badge">New</span>
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 1]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Elegant Summer Dress</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <div class="product-price">
                                $129.99
                                <span class="product-price-old">$159.99</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=400"
                                alt="Product">
                            <span class="product-badge">Sale</span>
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 2]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Casual Denim Jacket</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <div class="product-price">$89.99</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400"
                                alt="Product">
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 3]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Classic White Sneakers</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-price">$79.99</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1611312449408-fcece27cdbb7?w=400"
                                alt="Product">
                            <span class="product-badge">Hot</span>
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 3]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Designer Handbag</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <div class="product-price">$199.99</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=400"
                                alt="Product">
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 3]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Slim Fit Blazer</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <div class="product-price">$149.99</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1617019114583-affb34d1b3cd?w=400"
                                alt="Product">
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 3]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Leather Boots</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-price">$169.99</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400"
                                alt="Product">
                            <span class="product-badge">New</span>
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 3]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Casual T-Shirt</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <div class="product-price">$39.99</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=400"
                                alt="Product">
                            <div class="product-overlay">
                                <a href="{{ route('product.details', ['id' => 3]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">Stylish Sunglasses</h5>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <div class="product-price">$59.99</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Arrivals Carousel -->
    <section class="new-arrivals-section">
        <div class="container">
            <div class="section-title">
                <h2>New Arrivals</h2>
                <p>Fresh styles just landed</p>
            </div>
            <div id="newArrivalsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=400"
                                            alt="Product">
                                        <span class="product-badge">New</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 1]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Floral Maxi Dress</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                        </div>
                                        <div class="product-price">$159.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1594633313593-bab3825d0caf?w=400"
                                            alt="Product">
                                        <span class="product-badge">New</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 2]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Striped Polo Shirt</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="far fa-star"></i>
                                        </div>
                                        <div class="product-price">$69.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?w=400"
                                            alt="Product">
                                        <span class="product-badge">New</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 3]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Leather Crossbody</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half-alt"></i>
                                        </div>
                                        <div class="product-price">$189.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=400"
                                            alt="Product">
                                        <span class="product-badge">New</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 4]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Athletic Sneakers</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                        </div>
                                        <div class="product-price">$119.99</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=400"
                                            alt="Product">
                                        <span class="product-badge">New</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 2]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Wool Overcoat</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half-alt"></i>
                                        </div>
                                        <div class="product-price">$249.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400"
                                            alt="Product">
                                        <span class="product-badge">New</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 2]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Graphic Hoodie</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="far fa-star"></i>
                                        </div>
                                        <div class="product-price">$89.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400"
                                            alt="Product">
                                        <span class="product-badge">New</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 3]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Smart Watch</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                        </div>
                                        <div class="product-price">$299.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=400"
                                            alt="Product">
                                        <span class="product-badge">New</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 4]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Aviator Sunglasses</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half-alt"></i>
                                        </div>
                                        <div class="product-price">$99.99</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#newArrivalsCarousel"
                    data-bs-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#newArrivalsCarousel"
                    data-bs-slide="next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="section-title">
                <h2>Trending Categories</h2>
                <p>Explore our most popular collections</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=500"
                            alt="Women's Fashion" class="category-image">
                        <div class="category-overlay">
                            <h3 class="category-name">Women's Fashion</h3>
                            <p class="category-count">250+ Products</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?w=500"
                            alt="Men's Fashion" class="category-image">
                        <div class="category-overlay">
                            <h3 class="category-name">Men's Fashion</h3>
                            <p class="category-count">180+ Products</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="category-card">
                        <img src="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=500"
                            alt="Accessories" class="category-image">
                        <div class="category-overlay">
                            <h3 class="category-name">Accessories</h3>
                            <p class="category-count">120+ Products</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Promotional Banners -->
    <section class="promo-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="promo-banner">
                        <div class="promo-content">
                            <h3 class="promo-title">Summer Sale</h3>
                            <p class="promo-text">Up to 50% off on selected items</p>
                            <a href="{{ route('shop') }}" class="btn btn-outline"
                                style="border: 2px solid rgba(255, 255, 255, 0.7); color: rgba(255, 255, 255, 0.7);">Shop
                                Now</a>
                        </div>
                        <div class="promo-image">
                            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600"
                                alt="Summer Sale">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="promo-banner" style="background-color: var(--accent-color);">
                        <div class="promo-content">
                            <h3 class="promo-title">New Arrivals</h3>
                            <p class="promo-text">Discover the latest trends in fashion</p>
                            <a href="{{ route('shop') }}" class="btn btn-outline"
                                style="border: 2px solid rgba(255, 255, 255, 0.7); color: rgba(255, 255, 255, 0.7);">Explore</a>
                        </div>
                        <div class="promo-image">
                            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=600"
                                alt="New Arrivals">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Best Sellers Section -->
    <section class="best-sellers-section">
        <div class="container">
            <div class="section-title">
                <h2>Best Sellers</h2>
                <p>Our customers' top picks</p>
            </div>
            <div id="bestSellersCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400"
                                            alt="Product">
                                        <span class="product-badge best-seller-badge">Best Seller</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 1]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Elegant Summer Dress</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half-alt"></i>
                                            <span class="rating-count">(245)</span>
                                        </div>
                                        <div class="product-price">$129.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400"
                                            alt="Product">
                                        <span class="product-badge best-seller-badge">Best Seller</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 2]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Classic White Sneakers</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                            <span class="rating-count">(512)</span>
                                        </div>
                                        <div class="product-price">$79.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1611312449408-fcece27cdbb7?w=400"
                                            alt="Product">
                                        <span class="product-badge best-seller-badge">Best Seller</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 4]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Designer Handbag</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half-alt"></i>
                                            <span class="rating-count">(387)</span>
                                        </div>
                                        <div class="product-price">$199.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1617019114583-affb34d1b3cd?w=400"
                                            alt="Product">
                                        <span class="product-badge best-seller-badge">Best Seller</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 2]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Leather Boots</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                            <span class="rating-count">(423)</span>
                                        </div>
                                        <div class="product-price">$169.99</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400"
                                            alt="Product">
                                        <span class="product-badge best-seller-badge">Best Seller</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 1]) }}" class="btn btn-sm btn-primary product-action-btn product-action-btn-label" aria-label="Quick view">
    <i class="fas fa-eye"></i>
    <span>Quick View</span>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Elegant Summer Dress</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half-alt"></i>
                                            <span class="rating-count">(245)</span>
                                        </div>
                                        <div class="product-price">$129.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400"
                                            alt="Product">
                                        <span class="product-badge best-seller-badge">Best Seller</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 2]) }}" class="btn btn-sm btn-primary product-action-btn product-action-btn-label" aria-label="Quick view">
    <i class="fas fa-eye"></i>
    <span>Quick View</span>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Classic White Sneakers</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                            <span class="rating-count">(512)</span>
                                        </div>
                                        <div class="product-price">$79.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1611312449408-fcece27cdbb7?w=400"
                                            alt="Product">
                                        <span class="product-badge best-seller-badge">Best Seller</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 4]) }}" class="btn btn-sm btn-primary product-action-btn product-action-btn-label" aria-label="Quick view">
    <i class="fas fa-eye"></i>
    <span>Quick View</span>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Designer Handbag</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half-alt"></i>
                                            <span class="rating-count">(387)</span>
                                        </div>
                                        <div class="product-price">$199.99</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1617019114583-affb34d1b3cd?w=400"
                                            alt="Product">
                                        <span class="product-badge best-seller-badge">Best Seller</span>
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', ['id' => 2]) }}" class="btn btn-sm btn-primary product-action-btn product-action-btn-label" aria-label="Quick view">
    <i class="fas fa-eye"></i>
    <span>Quick View</span>
</a>
<a href="{{ route('cart') }}" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to cart">
    <i class="fas fa-cart-plus"></i>
</a>
<a href="#" class="btn btn-sm btn-secondary product-action-btn" aria-label="Add to wishlist">
    <i class="fas fa-heart"></i>
</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">Leather Boots</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                            <span class="rating-count">(423)</span>
                                        </div>
                                        <div class="product-price">$169.99</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bestSellersCarousel"
                    data-bs-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bestSellersCarousel"
                    data-bs-slide="next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-title">
                <h2>What Our Customers Say</h2>
                <p>Real feedback from real customers</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Customer">
                        </div>
                        <p class="testimonial-text">"Amazing quality and fast delivery! The dress fits perfectly and
                            the
                            fabric is excellent. Will definitely shop here again."</p>
                        <h6 class="testimonial-author">Sarah Johnson</h6>
                        <p class="testimonial-role">Fashion Enthusiast</p>
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Customer">
                        </div>
                        <p class="testimonial-text">"Best online shopping experience! Great customer service and the
                            products are exactly as described. Highly recommended!"</p>
                        <h6 class="testimonial-author">Michael Chen</h6>
                        <p class="testimonial-role">Regular Customer</p>
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-image">
                            <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="Customer">
                        </div>
                        <p class="testimonial-text">"Love the variety and style! Every piece I've bought has been worth
                            it. The quality exceeds my expectations every time."</p>
                        <h6 class="testimonial-author">Emma Williams</h6>
                        <p class="testimonial-role">Style Blogger</p>
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Logos Section -->
    <section class="brands-section">
        <div class="container">
            <div class="section-title">
                <h2>Featured Brands</h2>
                <p>Our trusted partners</p>
            </div>
            <div class="row align-items-center">
                <div class="col-6 col-md-2 mb-4">
                    <div class="brand-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fd/Zara_Logo.svg" alt="ZARA">
                    </div>
                </div>
                <div class="col-6 col-md-2 mb-4">
                    <div class="brand-logo">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/HM-Logo.png" alt="H&M">
                    </div>
                </div>
                <div class="col-6 col-md-2 mb-4">
                    <div class="brand-logo">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Gucci-Logo.png" alt="GUCCI">
                    </div>
                </div>
                <div class="col-6 col-md-2 mb-4">
                    <div class="brand-logo">
                        <img src="https://1000logos.net/wp-content/uploads/2017/05/Prada-Logo.png" alt="PRADA">
                    </div>
                </div>
                <div class="col-6 col-md-2 mb-4">
                    <div class="brand-logo">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Chanel-Logo.png" alt="CHANEL">
                    </div>
                </div>
                <div class="col-6 col-md-2 mb-4">
                    <div class="brand-logo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="60" viewBox="0 0 150 60">
                            <text x="50%" y="50%" text-anchor="middle" dy=".3em" font-family="Arial, sans-serif"
                                font-size="28" font-weight="bold" fill="#333">DIOR</text>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Highlights Section -->
    <section class="blog-highlights-section">
        <div class="container">
            <div class="section-title">
                <h2>Fashion Tips & Trends</h2>
                <p>Latest from our blog</p>
            </div>
            <div class="row">
                @foreach ($blogHighlights as $post)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="blog-highlight-card">
                            <div class="blog-highlight-image">
                                <img src="{{ $post->featured_image_url ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=500' }}"
                                    alt="{{ $post->title }}">
                                <span class="blog-highlight-category">{{ $post->category ?: 'Fashion' }}</span>
                            </div>
                            <div class="blog-highlight-content">
                                <div class="blog-highlight-meta">
                                    <span><i class="far fa-calendar"></i>
                                        {{ optional($post->publish_date)->format('M d, Y') ?? 'Recently' }}</span>
                                    <span><i class="far fa-comment"></i> {{ (int) ($post->comments_count ?? 0) }} Comments</span>
                                </div>
                                <h4 class="blog-highlight-title">{{ \Illuminate\Support\Str::limit($post->title, 58) }}</h4>
                                <p class="blog-highlight-excerpt">{{ $post->excerpt ? \Illuminate\Support\Str::limit((string) $post->excerpt, 120) : \Illuminate\Support\Str::limit((string) ($post->content ?? ''), 120) }}</p>
                                <a href="{{ filled($post->slug ?? null) ? route('blog.details', ['blogPost' => $post->slug]) : route('blog') }}"
                                    class="blog-highlight-link">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Store Benefits Section -->
    <section class="store-benefits-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="benefit-card">
                        <div class="benefit-icon-wrapper">
                            <i class="fas fa-shipping-fast benefit-icon"></i>
                        </div>
                        <h4 class="benefit-title">Free Shipping</h4>
                        <p class="benefit-description">Free delivery on orders over $100. Fast and reliable shipping
                            worldwide.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="benefit-card">
                        <div class="benefit-icon-wrapper">
                            <i class="fas fa-undo-alt benefit-icon"></i>
                        </div>
                        <h4 class="benefit-title">Easy Returns</h4>
                        <p class="benefit-description">30-day hassle-free returns. Your satisfaction is our priority.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="benefit-card">
                        <div class="benefit-icon-wrapper">
                            <i class="fas fa-shield-alt benefit-icon"></i>
                        </div>
                        <h4 class="benefit-title">Secure Payment</h4>
                        <p class="benefit-description">100% secure payment with SSL encryption. Shop with confidence.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                    <div class="benefit-card">
                        <div class="benefit-icon-wrapper">
                            <i class="fas fa-headphones-alt benefit-icon"></i>
                        </div>
                        <h4 class="benefit-title">24/7 Support</h4>
                        <p class="benefit-description">Round-the-clock customer support. We're here to help anytime.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instagram Feed Section -->
    <section class="instagram-section">
        <div class="container-fluid px-0">
            <div class="section-title">
                <h2>{{ $instagramSectionTitle }}</h2>
                <p>{{ $instagramHandle }}</p>
            </div>
            <div class="instagram-marquee">
                <div class="instagram-track">
                    <div class="instagram-group">
                        @foreach ($instagramFeeds as $index => $feed)
                            <div class="instagram-item-wrapper">
                                <div class="instagram-item">
                                    <img src="{{ $feed->image_url }}" alt="Instagram Post {{ $index + 1 }}">
                                    <div class="instagram-overlay">
                                        <a href="{{ $feed->post_url ?: 'https://instagram.com' }}" class="instagram-link"
                                            aria-label="Open Instagram post {{ $index + 1 }}"
                                            title="Open Instagram post {{ $index + 1 }}" target="_blank"
                                            rel="noopener noreferrer">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="instagram-group" aria-hidden="true">
                        @foreach ($instagramFeeds as $feed)
                            <div class="instagram-item-wrapper">
                                <div class="instagram-item">
                                    <img src="{{ $feed->image_url }}" alt="">
                                    <div class="instagram-overlay">
                                        <a href="{{ $feed->post_url ?: 'https://instagram.com' }}" class="instagram-link"
                                            tabindex="-1" aria-hidden="true" title="Instagram post preview"
                                            target="_blank" rel="noopener noreferrer">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h2 class="newsletter-title">Subscribe to Our Newsletter</h2>
                <p class="newsletter-text">Get the latest updates on new products and exclusive offers</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Enter your email address" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </section>


    <!-- Newsletter Popup Modal -->
    <div class="modal fade" id="newsletterModal" tabindex="-1" aria-labelledby="newsletterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content newsletter-modal">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="newsletter-modal-content">
                        <div class="newsletter-modal-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3 class="newsletter-modal-title">Get 15% Off Your First Order!</h3>
                        <p class="newsletter-modal-text">Subscribe to our newsletter and receive exclusive deals,
                            fashion tips, and early access to new collections.</p>
                        <form class="newsletter-modal-form">
                            <input type="email" class="form-control" placeholder="Enter your email address"
                                required>
                            <button type="submit" class="btn btn-primary w-100">Subscribe Now</button>
                        </form>
                        <p class="newsletter-modal-privacy">We respect your privacy. Unsubscribe at any time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <!-- Newsletter Popup Script -->
        <script>
            // Show newsletter popup after 5 seconds
            setTimeout(function() {
                var newsletterModal = new bootstrap.Modal(document.getElementById('newsletterModal'));
                newsletterModal.show();
            }, 5000);
        </script>
    @endpush
</x-app>

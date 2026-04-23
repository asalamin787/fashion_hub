<x-app>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/product-details.css') }}">
    @endpush

    <section class="page-header">
        <div class="container">
            <h1>Product Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item active">Elegant Summer Dress</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="product-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-gallery">
                        <div class="main-image">
                            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800" alt="Product"
                                id="mainImage">
                        </div>
                        <div class="thumbnail-images">
                            <div class="thumbnail active"
                                onclick="changeImage(this, 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800')">
                                <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=200"
                                    alt="Thumbnail 1">
                            </div>
                            <div class="thumbnail"
                                onclick="changeImage(this, 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=800')">
                                <img src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=200"
                                    alt="Thumbnail 2">
                            </div>
                            <div class="thumbnail"
                                onclick="changeImage(this, 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800')">
                                <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=200"
                                    alt="Thumbnail 3">
                            </div>
                            <div class="thumbnail"
                                onclick="changeImage(this, 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=800')">
                                <img src="https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=200"
                                    alt="Thumbnail 4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-details-content">
                        <p class="product-category">Women's Clothing</p>
                        <h1 class="product-details-title">Elegant Summer Dress</h1>
                        <div class="product-rating-section">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(4.5) 245 Reviews</span>
                        </div>
                        <div class="product-details-price">
                            $129.99
                            <span class="price-old">$159.99</span>
                            <span class="discount-badge">19% OFF</span>
                        </div>
                        <p class="product-description">
                            This elegant summer dress features a flowing silhouette perfect for warm weather. Made from
                            premium breathable fabric, it offers both comfort and style. The timeless design makes it
                            suitable for various occasions, from casual outings to semi-formal events.
                        </p>
                        <div class="product-meta">
                            <div class="meta-item">
                                <span class="meta-label">Availability:</span>
                                <span class="meta-value"><span class="availability-badge in-stock">In
                                        Stock</span></span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">SKU:</span>
                                <span class="meta-value">DRESS-2024-001</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Category:</span>
                                <span class="meta-value">Women's Dresses</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Tags:</span>
                                <span class="meta-value">Summer, Casual, Elegant</span>
                            </div>
                        </div>
                        <div class="product-options">
                            <div class="option-group">
                                <label class="option-label">Size:</label>
                                <div class="size-selector">
                                    <button class="size-btn">XS</button>
                                    <button class="size-btn">S</button>
                                    <button class="size-btn active">M</button>
                                    <button class="size-btn">L</button>
                                    <button class="size-btn">XL</button>
                                </div>
                            </div>
                            <div class="option-group">
                                <label class="option-label">Color:</label>
                                <div class="color-selector">
                                    <button class="color-btn active" style="background-color: #4169E1;"></button>
                                    <button class="color-btn" style="background-color: #DC143C;"></button>
                                    <button class="color-btn" style="background-color: #000000;"></button>
                                    <button class="color-btn"
                                        style="background-color: #FFFFFF; border: 2px solid #ddd;"></button>
                                    <button class="color-btn" style="background-color: #865749;"></button>
                                </div>
                            </div>
                            <div class="option-group">
                                <label class="option-label">Quantity:</label>
                                <div class="quantity-selector">
                                    <div class="quantity-input">
                                        <button class="quantity-btn" onclick="updateQty(-1)"><i
                                                class="fas fa-minus"></i></button>
                                        <div class="quantity-value" id="quantity">1</div>
                                        <button class="quantity-btn" onclick="updateQty(1)"><i
                                                class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-add-cart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            <button class="btn btn-outline btn-wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                        <div class="product-features">
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-truck"></i></div>
                                <div class="feature-text">
                                    <strong>Free Shipping</strong>
                                    <span>On orders over $100</span>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-undo"></i></div>
                                <div class="feature-text">
                                    <strong>Easy Returns</strong>
                                    <span>30-day return policy</span>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                                <div class="feature-text">
                                    <strong>Secure Payment</strong>
                                    <span>100% secure checkout</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-tabs">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                            type="button">Reviews (245)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                            type="button">Shipping Info</button>
                    </li>
                </ul>
                <div class="tab-content" id="productTabContent">
                    <div class="tab-pane fade show active" id="description">
                        <h3>Product Description</h3>
                        <p>Experience the perfect blend of elegance and comfort with our Elegant Summer Dress. Crafted
                            from premium quality fabric, this dress is designed to keep you cool and stylish during warm
                            weather.</p>
                        <h4>Features:</h4>
                        <ul>
                            <li>Premium breathable fabric for maximum comfort</li>
                            <li>Flowing silhouette that flatters all body types</li>
                            <li>Perfect for casual and semi-formal occasions</li>
                            <li>Easy to care for - machine washable</li>
                            <li>Available in multiple colors and sizes</li>
                        </ul>
                        <h4>Material & Care:</h4>
                        <p>100% Premium Cotton. Machine wash cold with like colors. Tumble dry low. Do not bleach. Iron
                            on low heat if needed.</p>
                    </div>
                    <div class="tab-pane fade" id="reviews">
                        <div class="reviews-section">
                            <div class="review-summary">
                                <div class="average-rating">4.5</div>
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <p>Based on 245 reviews</p>
                            </div>
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-author">
                                        <div class="author-avatar">
                                            <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Customer">
                                        </div>
                                        <div class="author-info">
                                            <h6>Sarah Johnson</h6>
                                            <p class="review-date">June 15, 2024</p>
                                        </div>
                                    </div>
                                    <div class="review-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="review-text">Absolutely love this dress! The fabric is so comfortable and the
                                    fit is perfect. I've received so many compliments when wearing it. Highly recommend!
                                </p>
                            </div>
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-author">
                                        <div class="author-avatar">
                                            <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Customer">
                                        </div>
                                        <div class="author-info">
                                            <h6>Emma Williams</h6>
                                            <p class="review-date">June 10, 2024</p>
                                        </div>
                                    </div>
                                    <div class="review-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <p class="review-text">Great quality dress, fits true to size. The color is exactly as
                                    shown in the pictures. Very satisfied with my purchase.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="shipping">
                        <h3>Shipping Information</h3>
                        <p>We offer fast and reliable shipping options to ensure your order arrives safely and on time.
                        </p>
                        <h4>Shipping Options:</h4>
                        <ul>
                            <li><strong>Standard Shipping (5-7 business days):</strong> $10.00</li>
                            <li><strong>Express Shipping (2-3 business days):</strong> $20.00</li>
                            <li><strong>Next Day Delivery:</strong> $35.00</li>
                            <li><strong>Free Shipping:</strong> On orders over $100</li>
                        </ul>
                        <h4>Returns & Exchanges:</h4>
                        <p>We offer a 30-day return policy. Items must be unworn, unwashed, and in original condition
                            with tags attached.</p>
                    </div>
                </div>
            </div>

            <div class="related-products">
                <div class="section-title">
                    <h2>Related Products</h2>
                    <p>You might also like these items</p>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=400"
                                    alt="Product">
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 5]) }}" class="btn btn-sm btn-primary">Quick View</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Casual Denim Jacket</h5>
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
                                    <a href="{{ route('product.details', ['id' => 6]) }}" class="btn btn-sm btn-primary">Quick View</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Classic White Sneakers</h5>
                                <div class="product-price">$79.99</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1611312449408-fcece27cdbb7?w=400"
                                    alt="Product">
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 6]) }}" class="btn btn-sm btn-primary">Quick View</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Designer Handbag</h5>
                                <div class="product-price">$199.99</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1542272454315-7f6f8ec4a6f3?w=400"
                                    alt="Product">
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 7]) }}" class="btn btn-sm btn-primary">Quick View</a>
                                </div>
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Stylish Sunglasses</h5>
                                <div class="product-price">$59.99</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
<x-app>
    @push('meta')
        <title>Shop Collection | FashionHub</title>
        <meta name="description" content="Browse FashionHub's curated collection of premium clothing, accessories, bags, and shoes for every style.">
        <meta name="keywords" content="fashion shop, premium clothing, fashion accessories, bags, shoes">
        <meta property="og:title" content="Shop Collection | FashionHub">
        <meta property="og:description" content="Browse FashionHub's curated collection of premium clothing, accessories, bags, and shoes for every style.">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:type" content="website">
        <meta name="twitter:title" content="Shop Collection | FashionHub">
        <meta name="twitter:description" content="Browse FashionHub's curated collection of premium clothing, accessories, bags, and shoes for every style.">
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

                        <!-- Category Filter -->
                        <div class="filter-section">
                            <h6>Category</h6>
                            <div class="filter-option">
                                <input type="checkbox" id="cat1">
                                <label for="cat1">Women's Clothing</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="cat2">
                                <label for="cat2">Men's Clothing</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="cat3">
                                <label for="cat3">Accessories</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="cat4">
                                <label for="cat4">Shoes</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="cat5">
                                <label for="cat5">Bags</label>
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="filter-section">
                            <h6>Price Range</h6>
                            <div class="price-range">
                                <input type="number" placeholder="Min" value="0">
                                <span>-</span>
                                <input type="number" placeholder="Max" value="500">
                            </div>
                        </div>

                        <!-- Size Filter -->
                        <div class="filter-section">
                            <h6>Size</h6>
                            <div class="size-options">
                                <div class="size-option">XS</div>
                                <div class="size-option">S</div>
                                <div class="size-option active">M</div>
                                <div class="size-option">L</div>
                                <div class="size-option">XL</div>
                                <div class="size-option">XXL</div>
                            </div>
                        </div>

                        <!-- Color Filter -->
                        <div class="filter-section">
                            <h6>Color</h6>
                            <div class="color-options">
                                <div class="color-option" style="background-color: #000000;" title="Black"></div>
                                <div class="color-option" style="background-color: #FFFFFF; border: 1px solid #ddd;"
                                    title="White"></div>
                                <div class="color-option active" style="background-color: #865749;" title="Brown">
                                </div>
                                <div class="color-option" style="background-color: #C0876A;" title="Tan"></div>
                                <div class="color-option" style="background-color: #4169E1;" title="Blue"></div>
                                <div class="color-option" style="background-color: #DC143C;" title="Red"></div>
                                <div class="color-option" style="background-color: #228B22;" title="Green"></div>
                                <div class="color-option" style="background-color: #FFD700;" title="Gold"></div>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="filter-section">
                            <h6>Brand</h6>
                            <div class="filter-option">
                                <input type="checkbox" id="brand1">
                                <label for="brand1">FashionHub Premium</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="brand2">
                                <label for="brand2">Urban Style</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="brand3">
                                <label for="brand3">Elegant Wear</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="brand4">
                                <label for="brand4">Casual Chic</label>
                            </div>
                        </div>

                        <div class="filter-apply">
                            <button class="btn btn-primary">Apply Filters</button>
                            <button class="filter-reset">Reset All</button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <!-- Products Header -->
                    <div class="products-header">
                        <div class="products-count">
                            Showing <strong>1-12</strong> of <strong>48</strong> products
                        </div>
                        <div class="products-sort">
                            <label>Sort by:</label>
                            <select>
                                <option>Featured</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Newest</option>
                                <option>Best Selling</option>
                                <option>Top Rated</option>
                            </select>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="products-grid">
                        <!-- Product 1 -->
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

                        <!-- Product 2 -->
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

                        <!-- Product 3 -->
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

                        <!-- Product 4 -->
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1611312449408-fcece27cdbb7?w=400"
                                    alt="Product">
                                <span class="product-badge">Hot</span>
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
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <div class="product-price">$199.99</div>
                            </div>
                        </div>

                        <!-- Product 5 -->
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=400"
                                    alt="Product">
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 5]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
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

                        <!-- Product 6 -->
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1617019114583-affb34d1b3cd?w=400"
                                    alt="Product">
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 6]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
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

                        <!-- Product 7 -->
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=400"
                                    alt="Product">
                                <span class="product-badge">New</span>
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 7]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
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

                        <!-- Product 8 -->
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=400"
                                    alt="Product">
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 8]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
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

                        <!-- Product 9 -->
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=400"
                                    alt="Product">
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 9]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
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
                                <h5 class="product-title">Leather Wallet</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="product-price">$49.99</div>
                            </div>
                        </div>

                        <!-- Product 10 -->
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1603252109303-2751441dd157?w=400"
                                    alt="Product">
                                <span class="product-badge">Sale</span>
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 10]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
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
                                <h5 class="product-title">Striped Sweater</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="product-price">
                                    $69.99
                                    <span class="product-price-old">$99.99</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product 11 -->
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=400"
                                    alt="Product">
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 11]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
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
                                <h5 class="product-title">Vintage Watch</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <div class="product-price">$249.99</div>
                            </div>
                        </div>

                        <!-- Product 12 -->
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?w=400"
                                    alt="Product">
                                <span class="product-badge">Hot</span>
                                <div class="product-overlay">
                                    <a href="{{ route('product.details', ['id' => 12]) }}" class="btn btn-sm btn-primary product-action-btn" aria-label="Quick view">
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
                                <h5 class="product-title">Formal Trousers</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="product-price">$99.99</div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
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

            // Size option toggle
            document.querySelectorAll('.size-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Color option toggle
            document.querySelectorAll('.color-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        </script>
    @endpush
</x-app>

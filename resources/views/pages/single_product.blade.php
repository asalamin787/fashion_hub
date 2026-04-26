<x-app>
    @push('meta')
        <title>{{ $product->seo['meta_title'] ?? $product->name . ' | FashionHub' }}</title>
        <meta name="description" content="{{ $product->seo['meta_description'] ?? $product->short_description }}">
        @if (filled($product->seo['meta_keywords'] ?? null))
            <meta name="keywords" content="{{ $product->seo['meta_keywords'] }}">
        @endif
        <meta property="og:title" content="{{ $product->name }} | FashionHub">
        <meta property="og:description" content="{{ $product->short_description }}">
        <meta property="og:image" content="{{ $product->featured_image_url }}">
        <meta property="og:url" content="{{ request()->fullUrl() }}">
        <meta property="og:type" content="product">
    @endpush

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/product-details.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    @endpush

    {{-- Page Header --}}
    <section class="page-header">
        <div class="container">
            <h1>Product Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                    @if ($product->category)
                        <li class="breadcrumb-item">
                            <a
                                href="{{ route('shop', ['categories' => $product->category_id]) }}">{{ $product->category->name }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </section>

    {{-- Product Details --}}
    <section class="product-details-section">
        <div class="container">
            <div class="row">

                {{-- Gallery --}}
                <div class="col-lg-6">
                    @php
                        $baseGalleryImages = collect($product->gallery_images ?? [])
                            ->filter(fn($img) => filled($img))
                            ->map(function ($img) {
                                if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                                    return $img;
                                }
                                return asset('storage/' . ltrim($img, '/'));
                            });

                        $variantImages = collect($product->variants ?? [])
                            ->pluck('image')
                            ->filter(fn($img) => filled($img))
                            ->map(function ($img) {
                                if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                                    return $img;
                                }
                                return asset('storage/' . ltrim($img, '/'));
                            });

                        $galleryImages = collect([$product->featured_image_url])
                            ->merge($baseGalleryImages)
                            ->merge($variantImages)
                            ->filter(fn($img) => filled($img))
                            ->unique()
                            ->values();
                    @endphp
                    <div class="product-gallery">
                        {{-- Main Swiper --}}
                        <div class="swiper product-main-swiper">
                            <div class="swiper-wrapper">
                                @foreach ($galleryImages as $imgUrl)
                                    <div class="swiper-slide">
                                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>

                        {{-- Thumbs Swiper --}}
                        @if ($galleryImages->count() > 1)
                            <div class="swiper product-thumbs-swiper mt-3">
                                <div class="swiper-wrapper">
                                    @foreach ($galleryImages as $imgUrl)
                                        <div class="swiper-slide">
                                            <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="col-lg-6">
                    <div class="product-details-content">

                        @if ($product->category)
                            <p class="product-category">{{ $product->category->name }}</p>
                        @endif

                        <h1 class="product-details-title">{{ $product->name }}</h1>

                        @if ((float) $product->rating > 0)
                            @php
                                $rating = (float) $product->rating;
                                $fullStars = (int) floor($rating);
                                $halfStar = $rating - $fullStars >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            @endphp
                            <div class="product-rating-section">
                                <div class="rating-stars">
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @if ($halfStar)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                </div>
                                <span class="rating-count">({{ number_format($rating, 1) }})
                                    {{ number_format($product->sales_count) }} sold</span>
                            </div>
                        @endif

                        {{-- Price --}}
                        @if ($product->has_variants)
                            @php $priceRange = $product->price_range; @endphp
                            <div class="product-details-price" id="productPrice">
                                @if ($priceRange)
                                    @if ($priceRange['min'] === $priceRange['max'])
                                        ${{ number_format($priceRange['min'], 2) }}
                                    @else
                                        ${{ number_format($priceRange['min'], 2) }} &ndash;
                                        ${{ number_format($priceRange['max'], 2) }}
                                    @endif
                                @else
                                    <span class="text-muted">Select options</span>
                                @endif
                            </div>
                        @else
                            @php
                                $basePrice = (float) ($product->base_price ?? 0);
                                $salePrice = (float) ($product->sale_price ?? 0);
                                $isOnSale = $salePrice > 0 && $salePrice < $basePrice;
                                $discountPct = $isOnSale ? round((($basePrice - $salePrice) / $basePrice) * 100) : 0;
                            @endphp
                            <div class="product-details-price" id="productPrice">
                                ${{ number_format($isOnSale ? $salePrice : $basePrice, 2) }}
                                @if ($isOnSale)
                                    <span class="price-old">${{ number_format($basePrice, 2) }}</span>
                                    <span class="discount-badge">{{ $discountPct }}% OFF</span>
                                @endif
                            </div>
                        @endif

                        @if (filled($product->short_description))
                            <p class="product-description">{{ $product->short_description }}</p>
                        @endif

                        {{-- Meta --}}
                        <div class="product-meta">
                            <div class="meta-item">
                                <span class="meta-label">Availability:</span>
                                <span class="meta-value">
                                    @if ($product->has_variants)
                                        <span class="availability-badge" id="stockBadge">Select options</span>
                                    @elseif ($product->stock > 0)
                                        <span class="availability-badge in-stock">In Stock
                                            ({{ $product->stock }})</span>
                                    @else
                                        <span class="availability-badge out-of-stock">Out of Stock</span>
                                    @endif
                                </span>
                            </div>
                            @if ($product->brand)
                                <div class="meta-item">
                                    <span class="meta-label">Brand:</span>
                                    <span class="meta-value">{{ $product->brand->name }}</span>
                                </div>
                            @endif
                            @if ($product->category)
                                <div class="meta-item">
                                    <span class="meta-label">Category:</span>
                                    <span class="meta-value">{{ $product->category->name }}</span>
                                </div>
                            @endif
                            @if (filled($product->badge))
                                <div class="meta-item">
                                    <span class="meta-label">Badge:</span>
                                    <span class="meta-value">{{ $product->badge }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Variant Selectors --}}
                        @if ($product->has_variants && filled($product->attributes))
                            <div class="product-options" id="variantSelector"
                                data-variants="{{ json_encode($product->variants) }}" data-has-variants="true">

                                @foreach ($product->attributes as $attribute)
                                    @php
                                        $attrSlug = $attribute['slug'];
                                        $attrName = $attribute['name'];
                                        $displayType = $attribute['display_type'] ?? 'text';
                                        $values = $attribute['values'] ?? [];
                                    @endphp
                                    <div class="option-group">
                                        <label class="option-label">
                                            {{ $attrName }}:
                                            <span class="selected-value-label text-muted fw-normal"
                                                id="label-{{ $attrSlug }}"></span>
                                        </label>

                                        @if ($displayType === 'image')
                                            <div class="color-selector" data-attribute="{{ $attrSlug }}">
                                                @foreach ($values as $val)
                                                    @php
                                                        $imgSrc = $val['image'] ?? null;
                                                        $imgUrl = filled($imgSrc)
                                                            ? (str_starts_with($imgSrc, 'http')
                                                                ? $imgSrc
                                                                : asset('storage/' . ltrim($imgSrc, '/')))
                                                            : null;
                                                    @endphp
                                                    <button type="button" class="color-btn variant-option"
                                                        data-attribute="{{ $attrSlug }}"
                                                        data-value="{{ $val['value'] }}"
                                                        data-label="{{ $val['label'] }}" title="{{ $val['label'] }}"
                                                        @if ($imgUrl) style="background-image: url('{{ $imgUrl }}'); background-size: cover;" @endif>
                                                        @if (!$imgUrl)
                                                            {{ mb_substr($val['label'], 0, 1) }}
                                                        @endif
                                                    </button>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="size-selector" data-attribute="{{ $attrSlug }}">
                                                @foreach ($values as $val)
                                                    <button type="button" class="size-btn variant-option"
                                                        data-attribute="{{ $attrSlug }}"
                                                        data-value="{{ $val['value'] }}"
                                                        data-label="{{ $val['label'] }}">
                                                        {{ $val['label'] }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                <div class="option-group">
                                    <label class="option-label">Quantity:</label>
                                    <div class="quantity-selector">
                                        <div class="quantity-input">
                                            <button type="button" class="quantity-btn" onclick="updateQty(-1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <div class="quantity-value" id="quantity">1</div>
                                            <button type="button" class="quantity-btn" onclick="updateQty(1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="product-options">
                                <div class="option-group">
                                    <label class="option-label">Quantity:</label>
                                    <div class="quantity-selector">
                                        <div class="quantity-input">
                                            <button type="button" class="quantity-btn" onclick="updateQty(-1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <div class="quantity-value" id="quantity">1</div>
                                            <button type="button" class="quantity-btn" onclick="updateQty(1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

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

            {{-- Tabs --}}
            <div class="product-tabs">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button">Description</button>
                    </li>
                    @if ($product->has_variants && filled($product->variant_display_rows))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="variants-tab" data-bs-toggle="tab"
                                data-bs-target="#variants" type="button">
                                Variants ({{ count($product->variant_display_rows) }})
                            </button>
                        </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                            type="button">Shipping Info</button>
                    </li>
                </ul>
                <div class="tab-content" id="productTabContent">

                    {{-- Description --}}
                    <div class="tab-pane fade show active" id="description">
                        @if (filled($product->description))
                            {!! nl2br(e($product->description)) !!}
                        @elseif (filled($product->short_description))
                            <p>{{ $product->short_description }}</p>
                        @else
                            <p class="text-muted">No description available.</p>
                        @endif
                    </div>

                    {{-- Variants table --}}
                    @if ($product->has_variants && filled($product->variant_display_rows))
                        <div class="tab-pane fade" id="variants">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Variant</th>
                                            <th>SKU</th>
                                            <th>Price</th>
                                            <th>Sale Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->variant_display_rows as $variant)
                                            <tr>
                                                <td>
                                                    {{ $variant['combination_label'] }}
                                                    @if ($variant['is_default'] ?? false)
                                                        <span class="badge bg-primary ms-1">Default</span>
                                                    @endif
                                                </td>
                                                <td><code>{{ $variant['sku'] ?? '-' }}</code></td>
                                                <td>${{ number_format((float) ($variant['price'] ?? 0), 2) }}</td>
                                                <td>
                                                    @if (filled($variant['sale_price']) && (float) $variant['sale_price'] > 0)
                                                        ${{ number_format((float) $variant['sale_price'], 2) }}
                                                    @else
                                                        <span class="text-muted">&ndash;</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php $vStock = (int) ($variant['stock'] ?? 0); @endphp
                                                    @if ($vStock > 0)
                                                        <span
                                                            class="text-success fw-semibold">{{ $vStock }}</span>
                                                    @else
                                                        <span class="text-danger fw-semibold">0</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ ($variant['status'] ?? '') === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $variant['status'] ?? 'active' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    {{-- Shipping --}}
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
                        <h4>Returns &amp; Exchanges:</h4>
                        <p>We offer a 30-day return policy. Items must be unworn, unwashed, and in original condition
                            with tags attached.</p>
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if ($relatedProducts->isNotEmpty())
                <div class="related-products">
                    <div class="section-title">
                        <h2>Related Products</h2>
                        <p>You might also like these items</p>
                    </div>
                    <div class="row">
                        @foreach ($relatedProducts as $related)
                            @php
                                $relatedBasePrice = (float) ($related->base_price ?? 0);
                                $relatedSalePrice = (float) ($related->sale_price ?? 0);
                                if ($related->has_variants) {
                                    $relatedRange = $related->price_range;
                                    $relatedPriceDisplay = $relatedRange
                                        ? '$' . number_format($relatedRange['min'], 2)
                                        : '&ndash;';
                                } else {
                                    $effectiveRelated =
                                        $relatedSalePrice > 0 && $relatedSalePrice < $relatedBasePrice
                                            ? $relatedSalePrice
                                            : $relatedBasePrice;
                                    $relatedPriceDisplay = '$' . number_format($effectiveRelated, 2);
                                }
                            @endphp
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="{{ $related->featured_image_url }}" alt="{{ $related->name }}">
                                        @if ($related->badge)
                                            <span
                                                class="product-badge">{{ filled($related->badge) ? $related->badge : '' }}</span>
                                        @endif
                                        <div class="product-overlay">
                                            <a href="{{ route('product.details', $related->slug) }}"
                                                class="btn btn-sm btn-primary product-action-btn"
                                                aria-label="Quick view">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('cart') }}"
                                                class="btn btn-sm btn-secondary product-action-btn"
                                                aria-label="Add to cart">
                                                <i class="fas fa-cart-plus"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-secondary product-action-btn"
                                                aria-label="Add to wishlist">
                                                <i class="fas fa-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h5 class="product-title">{{ $related->name }}</h5>
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                        </div>
                                        <div class="product-price">
                                            ${{ number_format((float) ($related->sale_price ?? ($related->base_price ?? 0)), 2) }}
                                            @if (
                                                (float) ($related->sale_price ?? 0) > 0 &&
                                                    (float) ($related->base_price ?? 0) > (float) ($related->sale_price ?? 0))
                                                <span
                                                    class="product-price-old">${{ number_format((float) $related->base_price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            // Gallery Swiper
            (function() {
                const thumbsEl = document.querySelector('.product-thumbs-swiper');
                let thumbsSwiper = null;

                if (thumbsEl) {
                    thumbsSwiper = new Swiper('.product-thumbs-swiper', {
                        spaceBetween: 10,
                        slidesPerView: 4,
                        watchSlidesProgress: true,
                        slideToClickedSlide: true,
                    });
                }

                new Swiper('.product-main-swiper', {
                    spaceBetween: 0,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    thumbs: thumbsSwiper ? {
                        swiper: thumbsSwiper
                    } : undefined,
                });
            })();

            function updateQty(delta) {
                const el = document.getElementById('quantity');
                el.textContent = Math.max(1, (parseInt(el.textContent) || 1) + delta);
            }

            (function() {
                const selectorEl = document.getElementById('variantSelector');
                if (!selectorEl) return;

                // Wait for Swiper to be ready
                const mainSwiperEl = document.querySelector('.product-main-swiper');
                const getMainSwiper = () => mainSwiperEl && mainSwiperEl.swiper;
                const thumbsSwiperEl = document.querySelector('.product-thumbs-swiper');
                const getThumbsSwiper = () => thumbsSwiperEl && thumbsSwiperEl.swiper;

                const allVariants = JSON.parse(selectorEl.dataset.variants || '[]');
                const selectedAttributes = {};
                const storageBase = '{{ asset('storage') }}/';

                function resolveImageUrl(path) {
                    if (!path) return null;
                    if (path.startsWith('http://') || path.startsWith('https://')) return path;
                    return storageBase + path.replace(/^\//, '');
                }

                function normalizeUrl(url) {
                    if (!url) return '';
                    return url.replace(/\\/g, '/').replace(/%2F/gi, '/');
                }

                function setMainImageFallback(imgUrl) {
                    const swiper = getMainSwiper();
                    if (!swiper || !swiper.slides || swiper.slides.length === 0) {
                        return;
                    }

                    const firstMainImg = swiper.slides[0].querySelector('img');
                    if (firstMainImg) {
                        firstMainImg.src = imgUrl;
                    }

                    const thumbsSwiper = getThumbsSwiper();
                    if (thumbsSwiper && thumbsSwiper.slides && thumbsSwiper.slides.length > 0) {
                        const firstThumbImg = thumbsSwiper.slides[0].querySelector('img');
                        if (firstThumbImg) {
                            firstThumbImg.src = imgUrl;
                        }
                        thumbsSwiper.update();
                    }

                    swiper.update();
                    swiper.slideTo(0);
                }

                function findMatchingVariant() {
                    const keys = Object.keys(selectedAttributes);
                    return allVariants.find(v => {
                        const attrs = v.attributes || {};
                        return keys.every(slug => attrs[slug] === selectedAttributes[slug]);
                    }) || null;
                }

                function updateUI() {
                    const variant = findMatchingVariant();
                    const priceEl = document.getElementById('productPrice');
                    const stockBadge = document.getElementById('stockBadge');

                    if (!variant) {
                        if (priceEl) priceEl.innerHTML = '<span class="text-muted">Select all options</span>';
                        if (stockBadge) {
                            stockBadge.textContent = 'Select options';
                            stockBadge.className = 'availability-badge';
                        }
                        return;
                    }

                    if (priceEl) {
                        const price = parseFloat(variant.price || 0);
                        const salePrice = parseFloat(variant.sale_price || 0);
                        const isOnSale = salePrice > 0 && salePrice < price;
                        let html = '$' + (isOnSale ? salePrice : price).toFixed(2);
                        if (isOnSale) {
                            const pct = Math.round(((price - salePrice) / price) * 100);
                            html += ' <span class="price-old">$' + price.toFixed(2) + '</span>';
                            html += ' <span class="discount-badge">' + pct + '% OFF</span>';
                        }
                        priceEl.innerHTML = html;
                    }

                    if (stockBadge) {
                        const stock = parseInt(variant.stock || 0);
                        stockBadge.textContent = stock > 0 ? 'In Stock (' + stock + ')' : 'Out of Stock';
                        stockBadge.className = 'availability-badge ' + (stock > 0 ? 'in-stock' : 'out-of-stock');
                    }

                    if (variant.image) {
                        const imgUrl = resolveImageUrl(variant.image);
                        if (imgUrl) {
                            const swiper = getMainSwiper();
                            if (swiper) {
                                // Find matching slide index by src (normalized)
                                const target = normalizeUrl(imgUrl);
                                let matched = false;
                                const slides = swiper.slides;
                                for (let i = 0; i < slides.length; i++) {
                                    const img = slides[i].querySelector('img');
                                    if (img && normalizeUrl(img.src) === target) {
                                        swiper.slideTo(i);
                                        matched = true;
                                        break;
                                    }
                                }

                                if (!matched) {
                                    setMainImageFallback(imgUrl);
                                }
                            }
                        }
                    }
                }

                document.querySelectorAll('.variant-option').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const slug = this.dataset.attribute;
                        document.querySelectorAll('.variant-option[data-attribute="' + slug + '"]').forEach(
                            b => b.classList.remove('active'));
                        this.classList.add('active');
                        selectedAttributes[slug] = this.dataset.value;
                        const labelEl = document.getElementById('label-' + slug);
                        if (labelEl) labelEl.textContent = this.dataset.label;
                        updateUI();
                    });
                });

                // Auto-select default variant
                const defaultVariant = allVariants.find(v => v.is_default) || allVariants[0];
                if (defaultVariant && defaultVariant.attributes) {
                    Object.entries(defaultVariant.attributes).forEach(function([slug, value]) {
                        const btn = document.querySelector('.variant-option[data-attribute="' + slug +
                            '"][data-value="' + value + '"]');
                        if (btn) btn.click();
                    });
                }
            })();
        </script>
    @endpush
</x-app>

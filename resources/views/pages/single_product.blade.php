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
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline-block ajax-add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_variant_id" id="cartVariantId"
                                    value="{{ $product->default_variant['sku'] ?? '' }}">
                                <input type="hidden" name="quantity" id="cartQuantity" value="1">
                                <button class="btn btn-primary btn-add-cart" type="submit">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                            <button class="btn btn-outline btn-wishlist wishlist-toggle-btn"
                                data-product-id="{{ $product->id }}"
                                data-toggle-url="{{ route('wishlist.toggle', $product) }}"
                                aria-label="Add to wishlist">
                                <i
                                    class="{{ in_array($product->id, session('wishlist', [])) ? 'fas' : 'far' }} fa-heart"></i>
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
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                            type="button">Reviews ({{ $approvedReviews->count() }})</button>
                    </li>
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

                    <div class="tab-pane fade" id="reviews">

                        {{-- Rating summary bar --}}
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-4 border-bottom">
                            <div class="d-flex align-items-center gap-4">
                                <div class="text-center">
                                    <div class="display-4 fw-bold lh-1" style="color:var(--primary-color)">{{ number_format($product->approved_review_average, 1) }}</div>
                                    <div class="review-stars mt-1">
                                        @php $avg = (float) $product->approved_review_average; @endphp
                                        @for ($s = 1; $s <= 5; $s++)
                                            @if ($s <= floor($avg))
                                                <i class="fas fa-star" style="color:var(--primary-color)"></i>
                                            @elseif ($s - $avg < 1 && $s - $avg > 0)
                                                <i class="fas fa-star-half-alt" style="color:var(--primary-color)"></i>
                                            @else
                                                <i class="far fa-star" style="color:var(--primary-color)"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="small text-muted mt-1">{{ $approvedReviews->count() }} {{ Str::plural('review', $approvedReviews->count()) }}</div>
                                </div>
                            </div>

                            @auth
                                @if ($eligibleReviewItems->isNotEmpty())
                                    <button class="btn btn-primary rounded-pill px-4"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#reviewFormCollapse"
                                        aria-expanded="false"
                                        aria-controls="reviewFormCollapse">
                                        <i class="fas fa-pen me-2"></i>Write a Review
                                    </button>
                                @elseif (auth()->user()->orders()->exists())
                                    <span class="text-muted small">You have already reviewed this product.</span>
                                @else
                                    <span class="text-muted small">Purchase this product to leave a review.</span>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="fas fa-user me-2"></i>Sign in to Review
                                </a>
                            @endauth
                        </div>

                        {{-- Review submission form (collapsible) --}}
                        @auth
                            @if ($eligibleReviewItems->isNotEmpty())
                                <div class="collapse mb-4" id="reviewFormCollapse">
                                    <div class="p-4 rounded-4 border" style="background:#fdf9f6;">
                                        <h3 class="h5 mb-4">Share Your Experience</h3>
                                        <form action="{{ route('product.reviews.store', $product) }}" method="POST" enctype="multipart/form-data" id="reviewForm">
                                            @csrf

                                            @if ($eligibleReviewItems->count() > 1)
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Reviewing Order</label>
                                                    <select name="order_item_id" class="form-select" required>
                                                        <option value="">Select order</option>
                                                        @foreach ($eligibleReviewItems as $eligibleItem)
                                                            <option value="{{ $eligibleItem->id }}">
                                                                {{ $eligibleItem->order->order_number ?? 'Order' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <input type="hidden" name="order_item_id" value="{{ $eligibleReviewItems->first()->id }}">
                                            @endif

                                            {{-- Star rating picker --}}
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Your Rating <span class="text-danger">*</span></label>
                                                <div class="star-picker d-flex gap-1" id="starPicker">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <button type="button"
                                                            class="star-pick-btn border-0 bg-transparent p-0 fs-3"
                                                            data-value="{{ $i }}"
                                                            aria-label="{{ $i }} star{{ $i > 1 ? 's' : '' }}"
                                                            style="color:#ddd; cursor:pointer; transition:color .15s;">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="rating" id="ratingInput" required>
                                                <div class="invalid-feedback d-block" id="ratingError" style="display:none!important"></div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                                    placeholder="Sum up your experience in a line"
                                                    maxlength="150" value="{{ old('title') }}" required>
                                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Review <span class="text-danger">*</span></label>
                                                <textarea name="review" class="form-control @error('review') is-invalid @enderror"
                                                    rows="4" placeholder="Tell others what you think about this product..."
                                                    maxlength="2000" required>{{ old('review') }}</textarea>
                                                @error('review')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-semibold">Photos <span class="text-muted fw-normal">(optional)</span></label>
                                                <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                                <div class="form-text">Up to 5 images, max 2 MB each.</div>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                                    <i class="fas fa-check me-1"></i>Submit Review
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                                    data-bs-toggle="collapse" data-bs-target="#reviewFormCollapse">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        {{-- Reviews list --}}
                        @forelse ($approvedReviews as $review)
                            @php
                                $ratingVal = (int) $review->rating;
                            @endphp
                            <div class="border rounded-4 p-4 mb-3">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                    <div>
                                        <h4 class="h6 mb-1">{{ $review->title }}</h4>
                                        <div class="small text-muted">{{ $review->user?->name }} &bull; {{ $review->created_at->format('d M Y') }}</div>
                                    </div>
                                    <div class="review-stars text-nowrap">
                                        @for ($s = 1; $s <= 5; $s++)
                                            <i class="{{ $s <= $ratingVal ? 'fas' : 'far' }} fa-star small" style="color:var(--primary-color)"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-0 text-muted">{{ $review->review }}</p>
                            </div>
                        @empty
                            <div class="border rounded-4 p-5 text-center text-muted">
                                <i class="far fa-star fa-2x mb-3 d-block" style="color:var(--primary-color); opacity:.4"></i>
                                <h4 class="h6 mb-1">No reviews yet</h4>
                                <p class="mb-0 small">Be the first verified customer to share your experience.</p>
                            </div>
                        @endforelse
                    </div>

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
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $product->id }}">
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
                                                data-product-id="{{ $related->id }}"
                                                data-toggle-url="{{ route('wishlist.toggle', $related) }}"
                                                aria-label="Add to wishlist">
                                                <i
                                                    class="{{ in_array($related->id, session('wishlist', [])) ? 'fas' : 'far' }} fa-heart"></i>
                                            </button>
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
                const nextValue = Math.max(1, (parseInt(el.textContent) || 1) + delta);
                el.textContent = nextValue;

                const qtyInput = document.getElementById('cartQuantity');

                if (qtyInput) {
                    qtyInput.value = String(nextValue);
                }
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
                    const variantInput = document.getElementById('cartVariantId');

                    if (!variant) {
                        if (priceEl) priceEl.innerHTML = '<span class="text-muted">Select all options</span>';
                        if (stockBadge) {
                            stockBadge.textContent = 'Select options';
                            stockBadge.className = 'availability-badge';
                        }

                        if (variantInput) {
                            variantInput.value = '';
                        }

                        return;
                    }

                    if (variantInput) {
                        variantInput.value = variant.sku || '';
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
                } else {
                    const variantInput = document.getElementById('cartVariantId');

                    if (variantInput) {
                        variantInput.value = '';
                    }
                }
            })();

            // Star rating picker
            (function () {
                const picker = document.getElementById('starPicker');
                if (!picker) return;
                const input = document.getElementById('ratingInput');
                const btns = picker.querySelectorAll('.star-pick-btn');
                const primary = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim() || '#865749';

                function paint(count) {
                    btns.forEach((b, idx) => {
                        b.style.color = idx < count ? primary : '#ddd';
                    });
                }

                btns.forEach((btn, idx) => {
                    btn.addEventListener('mouseenter', () => paint(idx + 1));
                    btn.addEventListener('mouseleave', () => paint(parseInt(input.value) || 0));
                    btn.addEventListener('click', () => {
                        input.value = idx + 1;
                        paint(idx + 1);
                    });
                });

                // Auto-open form if there are validation errors
                @if ($errors->any())
                    const collapse = document.getElementById('reviewFormCollapse');
                    if (collapse) {
                        new bootstrap.Collapse(collapse, { show: true });
                    }
                    const savedRating = '{{ old('rating') }}';
                    if (savedRating) {
                        input.value = savedRating;
                        paint(parseInt(savedRating));
                    }
                @endif
            })();

            // Wishlist toggle
            (function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                document.querySelectorAll('.wishlist-toggle-btn').forEach(btn => {
                    btn.addEventListener('click', async function() {
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

                            icon.classList.toggle('fas', data.in_wishlist);
                            icon.classList.toggle('far', !data.in_wishlist);

                            document.querySelectorAll('.wishlist-badge').forEach(el => {
                                el.textContent = data.count;
                                el.style.display = data.count > 0 ? 'inline-flex' : 'none';
                            });

                            window.showToast(
                                data.in_wishlist ? 'Added to wishlist.' : 'Removed from wishlist.',
                                'success'
                            );
                        } catch (e) {
                            console.error('Wishlist toggle failed:', e);
                            window.showToast('Unable to update wishlist.', 'error');
                        }
                    });
                });
            })();
        </script>
    @endpush
</x-app>

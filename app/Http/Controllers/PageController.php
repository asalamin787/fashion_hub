<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogCommentRequest;
use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactMail;
use App\Models\AboutPage;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\InstagramFeed;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home()
    {
        $sliders = Slider::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($sliders->isEmpty()) {
            $sliders = collect([
                (object) [
                    'subtitle' => 'New Collection 2025',
                    'title' => 'Discover Your Style',
                    'description' => 'Explore our curated collection of premium fashion pieces that define elegance and sophistication.',
                    'background_image_url' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1920',
                    'primary_button_text' => 'Shop Now',
                    'primary_button_link' => route('shop'),
                    'secondary_button_text' => 'Learn More',
                    'secondary_button_link' => route('about'),
                ],
                (object) [
                    'subtitle' => 'Summer Collection',
                    'title' => 'Up to 50% Off',
                    'description' => 'Limited time offer on selected summer fashion items. Don\'t miss out on these amazing deals!',
                    'background_image_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920',
                    'primary_button_text' => 'Shop Sale',
                    'primary_button_link' => route('shop'),
                    'secondary_button_text' => 'View Collection',
                    'secondary_button_link' => route('shop'),
                ],
                (object) [
                    'subtitle' => 'Trending Now',
                    'title' => 'Fashion Forward',
                    'description' => 'Stay ahead with the latest trends in fashion. Express yourself with our exclusive designs.',
                    'background_image_url' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920',
                    'primary_button_text' => 'Explore Trends',
                    'primary_button_link' => route('shop'),
                    'secondary_button_text' => 'Fashion Tips',
                    'secondary_button_link' => route('blog'),
                ],
            ]);
        }

        $instagramFeeds = InstagramFeed::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($instagramFeeds->isEmpty()) {
            $instagramFeeds = collect([
                (object) [
                    'section_title' => 'Follow Us on Instagram',
                    'instagram_handle' => '@fashionhub',
                    'image_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400',
                    'post_url' => 'https://instagram.com/fashionhub',
                ],
                (object) [
                    'section_title' => 'Follow Us on Instagram',
                    'instagram_handle' => '@fashionhub',
                    'image_url' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=400',
                    'post_url' => 'https://instagram.com/fashionhub',
                ],
                (object) [
                    'section_title' => 'Follow Us on Instagram',
                    'instagram_handle' => '@fashionhub',
                    'image_url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400',
                    'post_url' => 'https://instagram.com/fashionhub',
                ],
                (object) [
                    'section_title' => 'Follow Us on Instagram',
                    'instagram_handle' => '@fashionhub',
                    'image_url' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=400',
                    'post_url' => 'https://instagram.com/fashionhub',
                ],
                (object) [
                    'section_title' => 'Follow Us on Instagram',
                    'instagram_handle' => '@fashionhub',
                    'image_url' => 'https://images.unsplash.com/photo-1485230895905-ec40ba36b9bc?w=400',
                    'post_url' => 'https://instagram.com/fashionhub',
                ],
                (object) [
                    'section_title' => 'Follow Us on Instagram',
                    'instagram_handle' => '@fashionhub',
                    'image_url' => 'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?w=400',
                    'post_url' => 'https://instagram.com/fashionhub',
                ],
            ]);
        }

        $instagramSectionTitle = (string) ($instagramFeeds->first()->section_title ?? 'Follow Us on Instagram');
        $instagramHandle = (string) ($instagramFeeds->first()->instagram_handle ?? '@fashionhub');

        $blogHighlights = BlogPost::query()
            ->published()
            ->orderByDesc('publish_date')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $featuredProducts = Product::query()
            ->where('status', 'active')
            ->where('is_featured', 1)
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->limit(12)
            ->get();
        // dd($featuredProducts);

        $newArrivalsProducts = Product::query()
            ->where('status', 'active')
            ->where('badge', 'New')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $bestSellersProducts = Product::query()
            ->where('status', 'active')
            ->where('badge', 'Best Seller')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $homeCategories = Category::query()
            ->select(['id', 'name', 'slug', 'icon', 'image', 'sort_order'])
            ->withCount([
                'products' => fn (Builder $query) => $query->where('status', 'active'),
            ])
            ->where('is_active', true)
            ->orderByDesc('products_count')
            ->orderBy('sort_order')
            ->orderBy('id')
            // ->limit(8)
            ->get();

        if ($homeCategories->isEmpty()) {
            $homeCategories = collect([
                (object) [
                    'name' => "Men's Fashion",
                    'slug' => 'mens-fashion',
                    'icon' => 'fas fa-male',
                    'image_url' => 'https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?w=600',
                    'products_count' => 180,
                ],
                (object) [
                    'name' => "Women's Fashion",
                    'slug' => 'womens-fashion',
                    'icon' => 'fas fa-female',
                    'image_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600',
                    'products_count' => 250,
                ],
                (object) [
                    'name' => 'Accessories',
                    'slug' => 'accessories',
                    'icon' => 'fas fa-gem',
                    'image_url' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=600',
                    'products_count' => 120,
                ],
                (object) [
                    'name' => 'Footwear',
                    'slug' => 'footwear',
                    'icon' => 'fas fa-shoe-prints',
                    'image_url' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600',
                    'products_count' => 95,
                ],
                (object) [
                    'name' => 'Bags & Purses',
                    'slug' => 'bags-purses',
                    'icon' => 'fas fa-shopping-bag',
                    'image_url' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600',
                    'products_count' => 75,
                ],
                (object) [
                    'name' => 'Eyewear',
                    'slug' => 'eyewear',
                    'icon' => 'fas fa-glasses',
                    'image_url' => 'https://images.unsplash.com/photo-1509319117443-4b901b5414cc?w=600',
                    'products_count' => 45,
                ],
                (object) [
                    'name' => 'Watches',
                    'slug' => 'watches',
                    'icon' => 'fas fa-watch',
                    'image_url' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=600',
                    'products_count' => 60,
                ],
                (object) [
                    'name' => 'Jewelry',
                    'slug' => 'jewelry',
                    'icon' => 'fas fa-ring',
                    'image_url' => 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=600',
                    'products_count' => 85,
                ],
            ]);
        }

        if ($blogHighlights->isEmpty()) {
            $blogHighlights = collect([
                (object) [
                    'title' => '10 Must-Have Pieces for Your Winter Wardrobe',
                    'slug' => null,
                    'category' => 'Fashion Tips',
                    'excerpt' => 'Discover the essential fashion items you need to stay stylish and warm this winter season.',
                    'featured_image_url' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920',
                    'publish_date' => now()->subDays(5),
                    'comments_count' => 24,
                ],
                (object) [
                    'title' => 'How to Mix and Match Patterns Like a Pro',
                    'slug' => null,
                    'category' => 'Style Guide',
                    'excerpt' => 'Learn the art of combining different patterns to create stunning and unique outfits.',
                    'featured_image_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=500',
                    'publish_date' => now()->subDays(8),
                    'comments_count' => 18,
                ],
                (object) [
                    'title' => '2025 Fashion Trends You Need to Know',
                    'slug' => null,
                    'category' => 'Trends',
                    'excerpt' => 'Stay ahead of the curve with these upcoming fashion trends that will dominate 2025.',
                    'featured_image_url' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=500',
                    'publish_date' => now()->subDays(10),
                    'comments_count' => 32,
                ],
            ]);
        }

        $trendingCategories = Category::query()
            ->select(['id', 'name', 'slug', 'icon', 'image', 'sort_order'])
            ->withCount([
                'products' => fn (Builder $query) => $query->where('status', 'active'),
            ])
            ->where('is_active', true)
            ->orderByDesc('products_count')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(3)
            ->get();

        if ($trendingCategories->isEmpty()) {
            $trendingCategories = $homeCategories
                ->sortByDesc('products_count')
                ->take(3)
                ->values();
        }

        $promoOffers = Offer::query()
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function (Builder $query): void {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->orderBy('starts_at')
            ->orderBy('id')
            ->limit(2)
            ->get();

        if ($promoOffers->isEmpty()) {
            $promoOffers = collect([
                (object) [
                    'title' => 'Summer Sale',
                    'code' => 'SUMMER50',
                    'description' => 'Up to 50% off on selected items',
                    'image_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600',
                ],
                (object) [
                    'title' => 'New Arrivals',
                    'code' => 'NEWARRIVAL20',
                    'description' => 'Discover the latest trends in fashion',
                    'image_url' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=600',
                ],
            ]);
        }

        return view('pages.home', [
            'sliders' => $sliders,
            'instagramFeeds' => $instagramFeeds,
            'instagramSectionTitle' => $instagramSectionTitle,
            'instagramHandle' => $instagramHandle,
            'homeCategories' => $homeCategories,
            'trendingCategories' => $trendingCategories,
            'blogHighlights' => $blogHighlights,
            'promoOffers' => $promoOffers,
            'featuredProducts' => $featuredProducts,
            'newArrivalsProducts' => $newArrivalsProducts,
            'bestSellersProducts' => $bestSellersProducts,
        ]);
    }

    public function shop()
    {
        $perPage = 20;

        $parseMultiValueQuery = static function (mixed $value): array {
            if (is_array($value)) {
                return array_values(array_filter(array_map(static fn (mixed $item): string => trim((string) $item), $value)));
            }

            if (! is_string($value)) {
                return [];
            }

            return array_values(array_filter(array_map('trim', explode(',', $value))));
        };

        // Get filter parameters from request
        $categoryTokens = $parseMultiValueQuery(request()->query('categories', []));

        $singleCategory = trim((string) request()->query('category', ''));
        if ($singleCategory !== '') {
            $categoryTokens[] = $singleCategory;
        }

        $categoryTokens = array_values(array_unique(array_filter($categoryTokens)));

        $numericCategoryIds = array_map(
            'intval',
            array_values(array_filter($categoryTokens, static fn ($token) => ctype_digit((string) $token)))
        );
        $slugCategoryTokens = array_values(array_filter($categoryTokens, static fn ($token) => ! ctype_digit((string) $token)));

        $resolvedCategories = Category::query()
            ->select(['id', 'slug'])
            ->when(! empty($numericCategoryIds), fn ($q) => $q->orWhereIn('id', $numericCategoryIds))
            ->when(! empty($slugCategoryTokens), fn ($q) => $q->orWhereIn('slug', $slugCategoryTokens))
            ->get();

        $categoryIds = $resolvedCategories->pluck('id')->map(fn ($id) => (int) $id)->values()->all();
        $selectedCategorySlugs = $resolvedCategories->pluck('slug')->filter()->values()->all();

        $categoryIds = empty($categoryIds) ? null : $categoryIds;

        $brandIds = $parseMultiValueQuery(request()->query('brands', []));
        $brandIds = $brandIds ? array_map('intval', array_filter($brandIds)) : null;

        $minPrice = request()->query('min_price');
        $minPrice = $minPrice ? (float) $minPrice : null;

        $maxPrice = request()->query('max_price');
        $maxPrice = $maxPrice ? (float) $maxPrice : null;

        $badges = $parseMultiValueQuery(request()->query('badges', []));
        $badges = $badges ?: null;

        $offerCodes = $parseMultiValueQuery(request()->query('offers', []));
        $offerCodes = $offerCodes ?: null;

        $singleOfferCode = trim((string) request()->query('offer', ''));
        if ($singleOfferCode !== '') {
            $offerCodes ??= [];
            $offerCodes[] = $singleOfferCode;
            $offerCodes = array_values(array_unique(array_filter($offerCodes)));
        }

        $sortBy = request()->query('sort_by', 'featured');

        // Build query with scopes
        $products = Product::query()
            ->active()
            ->byCategory($categoryIds)
            ->byBrand($brandIds)
            ->byBadge($badges)
            ->byOfferCode($offerCodes)
            ->byPriceRange($minPrice, $maxPrice)
            ->sort($sortBy)
            ->with(['category', 'brand'])
            ->select(['id', 'name', 'slug', 'featured_image', 'base_price', 'sale_price', 'badge', 'category_id', 'brand_id', 'created_at', 'is_featured', 'sales_count', 'rating', 'stock', 'has_variants'])
            ->paginate($perPage)
            ->withQueryString();

        // Get available filter options from database
        $categories = Category::query()
            ->where('is_active', true)
            ->withCount([
                'products' => fn (Builder $query) => $query->where('status', 'active'),
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $brands = Brand::query()
            ->orderBy('name')
            ->get();

        $availableBadges = Product::query()
            ->active()
            ->distinct()
            ->whereNotNull('badge')
            ->pluck('badge')
            ->values();

        return view('pages.shop', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'availableBadges' => $availableBadges,
            'selectedCategories' => $selectedCategorySlugs,
            'selectedBrands' => $brandIds ?? [],
            'selectedBadges' => $badges ?? [],
            'selectedMinPrice' => $minPrice,
            'selectedMaxPrice' => $maxPrice,
            'sortBy' => $sortBy,
            'totalProducts' => Product::active()->count(),
        ]);
    }

    public function productDetails(Product $product): View
    {
        abort_if($product->status !== 'active', 404);

        $product->load([
            'category',
            'brand',
            'approvedReviews.user',
        ]);

        $eligibleReviewItems = collect();

        if (Auth::check()) {
            $eligibleReviewItems = $product->orderItems()
                ->with(['order', 'reviews'])
                ->whereHas('order', fn (Builder $query) => $query->where('user_id', Auth::id()))
                ->get()
                ->filter(function ($item): bool {
                    return ! $item->reviews->contains('user_id', Auth::id());
                })
                ->values();
        }

        $relatedProducts = Product::query()
            ->active()
            ->where('id', '!=', $product->id)
            ->when($product->category_id !== null, fn ($q) => $q->where('category_id', $product->category_id))
            ->with(['category'])
            ->select(['id', 'name', 'slug', 'featured_image', 'base_price', 'sale_price', 'badge', 'category_id', 'has_variants', 'variants', 'rating'])
            ->orderByDesc('is_featured')
            ->orderByDesc('sales_count')
            ->limit(4)
            ->get();

        return view('pages.single_product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'approvedReviews' => $product->approvedReviews,
            'eligibleReviewItems' => $eligibleReviewItems,
        ]);
    }

    public function wishlist()
    {
        return view('pages.wishlist');
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function checkout()
    {
        return view('pages.checkout');
    }

    public function about()
    {
        $aboutPage = AboutPage::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        if ($aboutPage === null) {
            $aboutPage = (object) [
                'hero_title' => 'About FashionHub',
                'hero_subtitle' => 'Bringing you timeless style and exceptional quality since 2015',
                'story_title' => 'Our Story',
                'story_body' => "Founded in 2015, FashionHub began with a simple vision: to make high-quality, stylish fashion accessible to everyone.\n\nWe believe that fashion is more than just clothing-it's a form of self-expression.\n\nToday, we serve thousands of satisfied customers globally, offering an ever-expanding range of fashion-forward pieces that combine timeless elegance with contemporary trends.",
                'story_image_url' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=600',
                'values_title' => 'Our Values',
                'values_subtitle' => 'What drives us every day',
                'values_items' => [
                    [
                        'icon' => 'fas fa-gem',
                        'title' => 'Quality First',
                        'description' => 'We source only the finest materials and work with skilled artisans to ensure every piece meets our exacting standards.',
                    ],
                    [
                        'icon' => 'fas fa-leaf',
                        'title' => 'Sustainability',
                        'description' => 'We\'re committed to ethical fashion practices and sustainable production methods that respect our planet.',
                    ],
                    [
                        'icon' => 'fas fa-heart',
                        'title' => 'Customer Satisfaction',
                        'description' => 'Your happiness is our priority. We go above and beyond to ensure you love every purchase.',
                    ],
                ],
                'team_title' => 'Meet Our Team',
                'team_subtitle' => 'The faces behind FashionHub',
                'team_members' => [
                    [
                        'name' => 'Sarah Anderson',
                        'role' => 'Founder & CEO',
                        'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
                        'linkedin' => '#',
                        'twitter' => '#',
                        'instagram' => '#',
                    ],
                    [
                        'name' => 'Michael Chen',
                        'role' => 'Creative Director',
                        'image' => 'https://randomuser.me/api/portraits/men/22.jpg',
                        'linkedin' => '#',
                        'twitter' => '#',
                        'instagram' => '#',
                    ],
                    [
                        'name' => 'Emma Wilson',
                        'role' => 'Head of Marketing',
                        'image' => 'https://randomuser.me/api/portraits/women/44.jpg',
                        'linkedin' => '#',
                        'twitter' => '#',
                        'instagram' => '#',
                    ],
                    [
                        'name' => 'James Rodriguez',
                        'role' => 'Operations Manager',
                        'image' => 'https://randomuser.me/api/portraits/men/46.jpg',
                        'linkedin' => '#',
                        'twitter' => '#',
                        'instagram' => '#',
                    ],
                ],
                'stats_items' => [
                    ['value' => '10K+', 'label' => 'Happy Customers'],
                    ['value' => '500+', 'label' => 'Products'],
                    ['value' => '50+', 'label' => 'Countries'],
                    ['value' => '9+', 'label' => 'Years Experience'],
                ],
            ];
        }

        $storyParagraphs = collect(preg_split('/\r\n|\r|\n/', (string) ($aboutPage->story_body ?? '')))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->values();

        return view('pages.about', [
            'aboutPage' => $aboutPage,
            'storyParagraphs' => $storyParagraphs,
        ]);
    }

    public function blog()
    {
        $searchTerm = Str::of((string) request()->string('q'))->squish()->value();
        $searchTokens = Str::of($searchTerm)
            ->explode(' ')
            ->filter();

        $blogQuery = BlogPost::query()
            ->published()
            ->orderByDesc('publish_date')
            ->orderBy('sort_order')
            ->orderByDesc('id');

        if ($searchTokens->isNotEmpty()) {
            $blogQuery->where(function (Builder $query) use ($searchTokens): void {
                foreach ($searchTokens as $searchToken) {
                    $query->where(function (Builder $tokenQuery) use ($searchToken): void {
                        $tokenQuery
                            ->where('title', 'like', "%{$searchToken}%")
                            ->orWhere('excerpt', 'like', "%{$searchToken}%")
                            ->orWhere('content', 'like', "%{$searchToken}%")
                            ->orWhere('category', 'like', "%{$searchToken}%")
                            ->orWhere('author_name', 'like', "%{$searchToken}%")
                            ->orWhere('tags', 'like', "%{$searchToken}%");
                    });
                }
            });
        }

        $blogPosts = $blogQuery->paginate(3)->withQueryString();

        $recentPosts = BlogPost::query()
            ->published()
            ->orderByDesc('publish_date')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $categoryCounts = BlogPost::query()
            ->published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->selectRaw('category, COUNT(*) as aggregate')
            ->groupBy('category')
            ->orderByDesc('aggregate')
            ->pluck('aggregate', 'category')
            ->all();

        $popularTags = BlogPost::query()
            ->published()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->filter()
            ->unique()
            ->values()
            ->take(20);

        if ($blogPosts->isEmpty() && $searchTerm === '') {
            $fallbackPosts = collect([
                (object) [
                    'title' => '10 Must-Have Fashion Pieces for Winter 2024',
                    'slug' => 'must-have-fashion-pieces-winter-2024',
                    'category' => 'Fashion Trends',
                    'author_name' => 'Sarah Johnson',
                    'excerpt' => 'Discover the essential fashion pieces that will keep you stylish and warm this winter season. From cozy sweaters to elegant coats, we\'ve curated the perfect list for your wardrobe.',
                    'content' => 'Build your winter wardrobe around versatile layers, timeless outerwear, and practical accessories that balance comfort with modern style.',
                    'featured_image_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800',
                    'publish_date' => now()->subDays(10),
                    'comments_count' => 15,
                    'views_count' => 2500,
                    'tags' => ['Fashion', 'Winter', 'Trends'],
                ],
                (object) [
                    'title' => 'How to Style Your Wardrobe for Every Occasion',
                    'slug' => 'style-your-wardrobe-for-every-occasion',
                    'category' => 'Style Guide',
                    'author_name' => 'Emma Williams',
                    'excerpt' => 'Learn the art of versatile dressing with our comprehensive guide. Whether it\'s a casual brunch or a formal event, we\'ve got you covered with expert styling tips.',
                    'content' => 'Use capsule principles and event-based layering to get more outfit combinations from fewer pieces.',
                    'featured_image_url' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800',
                    'publish_date' => now()->subDays(15),
                    'comments_count' => 23,
                    'views_count' => 3100,
                    'tags' => ['Style', 'Wardrobe', 'Tips'],
                ],
                (object) [
                    'title' => 'Sustainable Fashion: Making Conscious Choices',
                    'slug' => 'sustainable-fashion-making-conscious-choices',
                    'category' => 'Sustainability',
                    'author_name' => 'Michael Chen',
                    'excerpt' => 'Explore the world of sustainable fashion and learn how to make eco-friendly choices without compromising on style. Discover brands and practices that make a difference.',
                    'content' => 'Prioritize long-lasting fabrics, responsible brands, and mindful purchasing decisions to reduce waste.',
                    'featured_image_url' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800',
                    'publish_date' => now()->subDays(20),
                    'comments_count' => 18,
                    'views_count' => 1800,
                    'tags' => ['Sustainable', 'Lifestyle', 'Fashion'],
                ],
            ]);

            $blogPosts = new LengthAwarePaginator(
                $fallbackPosts,
                $fallbackPosts->count(),
                3,
                1,
                ['path' => route('blog')],
            );

            $recentPosts = $fallbackPosts->take(3);
            $categoryCounts = $fallbackPosts
                ->groupBy('category')
                ->map(fn ($items): int => $items->count())
                ->sortDesc()
                ->all();
            $popularTags = $fallbackPosts
                ->pluck('tags')
                ->flatten()
                ->filter()
                ->unique()
                ->values();
        }

        return view('pages.blog', [
            'blogPosts' => $blogPosts,
            'recentPosts' => $recentPosts,
            'categoryCounts' => $categoryCounts,
            'popularTags' => $popularTags,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function blogDetails(?BlogPost $blogPost = null)
    {
        $blogPost ??= BlogPost::query()
            ->published()
            ->orderByDesc('publish_date')
            ->orderByDesc('id')
            ->first();

        $recentPosts = BlogPost::query()
            ->published()
            ->orderByDesc('publish_date')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $categoryCounts = BlogPost::query()
            ->published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->selectRaw('category, COUNT(*) as aggregate')
            ->groupBy('category')
            ->orderByDesc('aggregate')
            ->pluck('aggregate', 'category')
            ->all();

        $popularTags = BlogPost::query()
            ->published()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->filter()
            ->unique()
            ->values()
            ->take(20);

        $comments = collect();
        $approvedCommentsCount = 0;

        if ($blogPost instanceof BlogPost) {
            $blogPost->increment('views_count');
            $blogPost->refresh();

            $blogPost->load([
                'approvedComments' => fn ($query) => $query->latest()->limit(20),
            ]);

            $comments = $blogPost->approvedComments;
            $approvedCommentsCount = $blogPost->approvedComments()->count();

            $relatedPosts = BlogPost::query()
                ->published()
                ->whereKeyNot($blogPost->getKey())
                ->when(
                    filled($blogPost->category),
                    fn ($query) => $query->where('category', $blogPost->category),
                )
                ->orderByDesc('publish_date')
                ->orderByDesc('id')
                ->limit(3)
                ->get();
        } else {
            $blogPost = (object) [
                'title' => 'The Ultimate Guide to Fall Fashion Trends 2024',
                'slug' => 'ultimate-guide-fall-fashion-trends-2024',
                'category' => 'Fashion Trends',
                'author_name' => 'Sarah Johnson',
                'excerpt' => 'Discover the hottest fashion trends this fall season and learn how to incorporate them into your wardrobe with style and confidence.',
                'content' => "Fall is finally here, and with it comes a fresh wave of fashion trends that are set to dominate the season.\n\nAs the leaves change color and the air turns crisp, it\'s time to update your wardrobe with the latest trends.\n\nFocus on versatile layers, statement outerwear, and comfortable silhouettes to build looks you can wear every day.",
                'featured_image_url' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1200&h=600&fit=crop',
                'publish_date' => now()->subDays(5),
                'comments_count' => 15,
                'views_count' => 2500,
                'tags' => ['Fall Fashion', 'Trends 2024', 'Style Guide', 'Fashion Tips'],
            ];

            $relatedPosts = collect();
        }

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = collect($recentPosts)->take(3);
        }

        return view('pages.blog_details', [
            'blogPost' => $blogPost,
            'comments' => $comments,
            'approvedCommentsCount' => $approvedCommentsCount,
            'relatedPosts' => $relatedPosts,
            'recentPosts' => $recentPosts,
            'categoryCounts' => $categoryCounts,
            'popularTags' => $popularTags,
        ]);
    }

    public function storeBlogComment(StoreBlogCommentRequest $request, BlogPost $blogPost)
    {
        $blogPost->comments()->create([
            ...$request->validated(),
            'is_approved' => true,
        ]);

        $blogPost->increment('comments_count');

        return redirect()
            ->route('blog.details', ['blogPost' => $blogPost->slug])
            ->with('commentSubmitted', 'Your comment has been posted successfully.');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function storeContact(StoreContactRequest $request): RedirectResponse
    {
        $adminEmail = setting('mail.contact_receive_mail', config('mail.from.address'));

        Mail::to($adminEmail)->send(new ContactMail(
            senderName: $request->validated('name'),
            senderEmail: $request->validated('email'),
            mailSubject: $request->validated('subject'),
            messageBody: $request->validated('message'),
            submittedAt: now()->format('M j, Y · h:i A'),
        ));

        return back()->with('contact_success', 'Your message has been sent. We\'ll get back to you within 24 hours.');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy_policy');
    }

    public function termsOfCondition()
    {
        return view('pages.terms_of_condition');
    }

    public function searchProducts()
    {
        $query = request()->query('q', '');

        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'results' => [
                    'exact_matches' => [],
                    'related_products' => [],
                    'popular_products' => [],
                ],
            ]);
        }

        $searchTokens = array_filter(array_map('trim', explode(' ', $query)));
        $baseQuery = Product::query()
            ->where('status', 'active')
            ->with(['category', 'brand']);

        // Exact matches (exact name match)
        $exactMatches = (clone $baseQuery)
            ->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($query).'%'])
            ->limit(8)
            ->get();

        // Related products (category or brand match)
        $relatedIds = $exactMatches->pluck('id')->toArray();
        $relatedProducts = (clone $baseQuery)
            ->whereNotIn('id', $relatedIds)
            ->where(function (Builder $q) use ($searchTokens, $query): void {
                foreach ($searchTokens as $token) {
                    $q->orWhereRaw('LOWER(description) LIKE ?', ['%'.strtolower($token).'%'])
                        ->orWhereRaw('LOWER(short_description) LIKE ?', ['%'.strtolower($token).'%']);
                }
                $q->orWhereHas('category', function (Builder $q) use ($query): void {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($query).'%']);
                });
                $q->orWhereHas('brand', function (Builder $q) use ($query): void {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($query).'%']);
                });
            })
            ->limit(8)
            ->get();

        // Popular/trending products
        $allMatchIds = array_merge($relatedIds, $relatedProducts->pluck('id')->toArray());
        $popularProducts = (clone $baseQuery)
            ->whereNotIn('id', $allMatchIds)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $formatProduct = static function (Product $product): array {
            $displayPrice = $product->sale_price ?? $product->base_price ?? 0;
            $imageUrl = 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400';

            if ($product->featured_image) {
                $imageUrl = Storage::url('public/'.$product->featured_image);
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => number_format($displayPrice, 2),
                'image' => $imageUrl,
                'category' => $product->category?->name,
                'brand' => $product->brand?->name,
            ];
        };

        return response()->json([
            'success' => true,
            'results' => [
                'exact_matches' => $exactMatches->map($formatProduct)->values(),
                'related_products' => $relatedProducts->map($formatProduct)->values(),
                'popular_products' => $popularProducts->map($formatProduct)->values(),
            ],
        ]);
    }
}

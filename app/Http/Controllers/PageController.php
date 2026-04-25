<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogCommentRequest;
use App\Models\AboutPage;
use App\Models\BlogPost;
use App\Models\InstagramFeed;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

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

        return view('pages.home', [
            'sliders' => $sliders,
            'instagramFeeds' => $instagramFeeds,
            'instagramSectionTitle' => $instagramSectionTitle,
            'instagramHandle' => $instagramHandle,
        ]);
    }

    public function shop()
    {
        return view('pages.shop');
    }

    public function productDetails()
    {
        return view('pages.single_product');
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

        if ($blogPost instanceof BlogPost) {
            $blogPost->load([
                'approvedComments' => fn ($query) => $query->latest()->limit(20),
            ]);

            $comments = $blogPost->approvedComments;

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

    public function privacyPolicy()
    {
        return view('pages.privacy_policy');
    }

    public function termsOfCondition()
    {
        return view('pages.terms_of_condition');
    }
}

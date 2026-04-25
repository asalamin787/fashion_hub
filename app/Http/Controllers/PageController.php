<?php

namespace App\Http\Controllers;

use App\Models\InstagramFeed;
use App\Models\Slider;

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
        return view('pages.about');
    }

    public function blog()
    {
        return view('pages.blog');
    }

    public function blogDetails()
    {
        return view('pages.blog_details');
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
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

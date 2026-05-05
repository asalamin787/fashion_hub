<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StaticPageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.static_page', [
            'page' => $page,
            'safeContent' => sanitize_rich_content((string) $page->content),
        ]);
    }

    public function faq(): View
    {
        $categories = FaqCategory::query()
            ->published()
            ->with([
                'faqs' => fn ($query) => $query->published()->orderBy('sort_order')->orderBy('id'),
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('pages.faq', [
            'categories' => $categories,
            'metaTitle' => 'Frequently Asked Questions',
            'metaDescription' => Str::limit('Answers to common questions about orders, shipping, returns, and shopping at FashionHub.', 160),
        ]);
    }
}

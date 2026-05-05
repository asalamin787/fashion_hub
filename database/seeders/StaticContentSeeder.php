<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StaticContentSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'meta_title' => 'Terms and Conditions | FashionHub',
                'meta_description' => 'Read the terms governing orders, payments, shipping, returns, and use of FashionHub.',
                'content' => '<h2>Using FashionHub</h2><p>By shopping with FashionHub, you agree to provide accurate account, billing, and shipping information during checkout.</p><h2>Orders and payments</h2><p>Orders are subject to availability, payment authorization, and review for fraud prevention when required.</p><h2>Shipping and returns</h2><p>Estimated delivery times may vary by destination and demand. Return requests must follow the return conditions published by our store.</p>',
                'status' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'meta_title' => 'Privacy Policy | FashionHub',
                'meta_description' => 'Learn how FashionHub collects, stores, and protects your personal information.',
                'content' => '<h2>Information we collect</h2><p>We collect customer details required for account management, order processing, support, and fraud prevention.</p><h2>How data is used</h2><p>Your information is used to fulfill orders, provide support, improve the shopping experience, and meet legal obligations.</p><h2>Security</h2><p>FashionHub applies reasonable safeguards to protect your account and transaction data.</p>',
                'status' => true,
            ],
            [
                'title' => 'Cookie Policy',
                'slug' => 'cookie-policy',
                'meta_title' => 'Cookie Policy | FashionHub',
                'meta_description' => 'Understand how FashionHub uses cookies for storefront functionality and analytics.',
                'content' => '<h2>Why we use cookies</h2><p>Cookies help keep your cart, preferences, and browsing experience consistent across visits.</p><h2>Types of cookies</h2><p>We may use essential, functional, and analytics cookies to improve performance and convenience.</p><h2>Managing cookies</h2><p>You can control cookies through your browser settings, though some storefront features may be affected.</p>',
                'status' => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::query()->updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData,
            );
        }

        $faqData = [
            'Orders & Payments' => [
                ['question' => 'When is my order confirmed?', 'answer' => 'Your order is confirmed after checkout is completed and payment is accepted or your cash on delivery order is placed.', 'sort_order' => 1],
                ['question' => 'Can I pay by card or cash on delivery?', 'answer' => 'Yes. Available payment methods depend on your checkout selection and store configuration.', 'sort_order' => 2],
            ],
            'Shipping & Delivery' => [
                ['question' => 'How long does delivery take?', 'answer' => 'Standard delivery times depend on your shipping address and the products in your order.', 'sort_order' => 1],
                ['question' => 'How can I track my order?', 'answer' => 'Signed-in customers can review order status from their account dashboard once an order has been placed.', 'sort_order' => 2],
            ],
            'Returns & Support' => [
                ['question' => 'Who can I contact for help?', 'answer' => 'If you need support, reach out through the contact details listed in the storefront footer or your order email.', 'sort_order' => 1],
                ['question' => 'Can I return an item?', 'answer' => 'Return eligibility depends on product condition and the store return policy.', 'sort_order' => 2],
            ],
        ];

        foreach ($faqData as $categoryName => $faqs) {
            $category = FaqCategory::query()->updateOrCreate(
                ['slug' => Str::slug($categoryName)],
                [
                    'name' => $categoryName,
                    'sort_order' => count($faqs),
                    'status' => true,
                ],
            );

            foreach ($faqs as $faq) {
                Faq::query()->updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'question' => $faq['question'],
                    ],
                    [
                        'answer' => $faq['answer'],
                        'sort_order' => $faq['sort_order'],
                        'status' => true,
                    ],
                );
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Fashion Hub', 'type' => 'text', 'label' => 'Site Name', 'description' => 'Main website name', 'is_public' => true, 'sort_order' => 1],
            ['group' => 'general', 'key' => 'site_tagline', 'value' => 'Modern fashion for every season', 'type' => 'text', 'label' => 'Site Tagline', 'description' => 'Short brand slogan', 'is_public' => true, 'sort_order' => 2],
            ['group' => 'company', 'key' => 'company_email', 'value' => 'support@fashionhub.test', 'type' => 'text', 'label' => 'Company Email', 'description' => 'Primary support email', 'is_public' => true, 'sort_order' => 1],
            ['group' => 'company', 'key' => 'company_phone', 'value' => '+8801000000000', 'type' => 'text', 'label' => 'Company Phone', 'description' => 'Primary company contact number', 'is_public' => true, 'sort_order' => 2],
            ['group' => 'seo', 'key' => 'meta_title_default', 'value' => 'Fashion Hub - Premium Lifestyle Store', 'type' => 'text', 'label' => 'Default Meta Title', 'description' => 'Default SEO title for pages without custom title', 'is_public' => true, 'sort_order' => 1],
            ['group' => 'seo', 'key' => 'meta_description_default', 'value' => 'Discover premium fashion, bags, footwear and accessories with fast delivery.', 'type' => 'textarea', 'label' => 'Default Meta Description', 'description' => 'Default SEO description for pages', 'is_public' => true, 'sort_order' => 2],
            ['group' => 'payment', 'key' => 'currency_code', 'value' => 'BDT', 'type' => 'select', 'label' => 'Currency Code', 'description' => 'Default payment currency', 'is_public' => true, 'sort_order' => 1],
            ['group' => 'mail', 'key' => 'mail_from_name', 'value' => 'Fashion Hub', 'type' => 'text', 'label' => 'Mail From Name', 'description' => 'Sender name for transactional emails', 'is_public' => false, 'sort_order' => 1],
            ['group' => 'social', 'key' => 'facebook_url', 'value' => 'https://facebook.com/fashionhub', 'type' => 'text', 'label' => 'Facebook URL', 'description' => 'Official Facebook page URL', 'is_public' => true, 'sort_order' => 1],
            ['group' => 'invoice', 'key' => 'invoice_prefix', 'value' => 'INV-', 'type' => 'text', 'label' => 'Invoice Prefix', 'description' => 'Prefix for invoice numbers', 'is_public' => false, 'sort_order' => 1],
            ['group' => 'shipping', 'key' => 'default_shipping_fee', 'value' => '80', 'type' => 'number', 'label' => 'Default Shipping Fee', 'description' => 'Default shipping charge for standard delivery', 'is_public' => true, 'sort_order' => 1],
            ['group' => 'appearance', 'key' => 'primary_color', 'value' => '#865749', 'type' => 'color', 'label' => 'Primary Brand Color', 'description' => 'Primary color used across storefront', 'is_public' => true, 'sort_order' => 1],
            ['group' => 'security', 'key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'label' => 'Maintenance Mode', 'description' => 'Flag to toggle maintenance mode integrations', 'is_public' => false, 'sort_order' => 1],
        ];

        foreach ($settings as $setting) {
            Setting::query()->updateOrCreate(
                [
                    'group' => $setting['group'],
                    'key' => $setting['key'],
                ],
                $setting,
            );
        }
    }
}

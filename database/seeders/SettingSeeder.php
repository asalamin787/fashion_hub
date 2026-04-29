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
            ['group' => 'site', 'key' => 'title', 'display_name' => 'Site Title', 'value' => 'Fashion Hub', 'type' => 'text', 'details' => ['help' => 'Main website title used across the storefront.'], 'is_public' => true, 'order' => 1],
            ['group' => 'site', 'key' => 'description', 'display_name' => 'Site Description', 'value' => 'Modern fashion for every season.', 'type' => 'textarea', 'details' => ['help' => 'Short description shown in key brand sections.'], 'is_public' => true, 'order' => 2],
            ['group' => 'site', 'key' => 'logo', 'display_name' => 'Site Logo', 'value' => null, 'type' => 'image', 'details' => ['help' => 'Upload the primary logo used in the header.'], 'is_public' => true, 'order' => 3],
            ['group' => 'site', 'key' => 'favicon', 'display_name' => 'Favicon', 'value' => null, 'type' => 'image', 'details' => ['help' => 'Browser tab icon for the storefront.'], 'is_public' => true, 'order' => 4],
            ['group' => 'site', 'key' => 'email', 'display_name' => 'Site Email', 'value' => 'support@fashionhub.test', 'type' => 'email', 'details' => ['help' => 'Primary public contact email.'], 'is_public' => true, 'order' => 5],
            ['group' => 'site', 'key' => 'phone', 'display_name' => 'Site Phone', 'value' => '+8801000000000', 'type' => 'text', 'details' => ['help' => 'Primary public contact phone number.'], 'is_public' => true, 'order' => 6],
            ['group' => 'seo', 'key' => 'meta_title', 'display_name' => 'Default Meta Title', 'value' => 'Fashion Hub - Premium Lifestyle Store', 'type' => 'text', 'details' => ['help' => 'Default SEO title for pages without custom metadata.'], 'is_public' => true, 'order' => 1],
            ['group' => 'seo', 'key' => 'meta_description', 'display_name' => 'Default Meta Description', 'value' => 'Discover premium fashion, bags, footwear and accessories with fast delivery.', 'type' => 'textarea', 'details' => ['help' => 'Default SEO description for storefront pages.'], 'is_public' => true, 'order' => 2],
            ['group' => 'seo', 'key' => 'og_image', 'display_name' => 'Default OG Image', 'value' => null, 'type' => 'image', 'details' => ['help' => 'Fallback image used for social sharing cards.'], 'is_public' => true, 'order' => 3],
            ['group' => 'social', 'key' => 'facebook', 'display_name' => 'Facebook URL', 'value' => 'https://facebook.com/fashionhub', 'type' => 'url', 'details' => ['help' => 'Official Facebook page URL.'], 'is_public' => true, 'order' => 1],
            ['group' => 'social', 'key' => 'instagram', 'display_name' => 'Instagram URL', 'value' => 'https://instagram.com/fashionhub', 'type' => 'url', 'details' => ['help' => 'Official Instagram profile URL.'], 'is_public' => true, 'order' => 2],
            ['group' => 'social', 'key' => 'youtube', 'display_name' => 'YouTube URL', 'value' => 'https://youtube.com/@fashionhub', 'type' => 'url', 'details' => ['help' => 'Official YouTube channel URL.'], 'is_public' => true, 'order' => 3],
            ['group' => 'payment', 'key' => 'cod_enabled', 'display_name' => 'Cash on Delivery', 'value' => true, 'type' => 'toggle', 'details' => ['help' => 'Enable or disable cash on delivery.', 'options' => ['0' => 'Disabled', '1' => 'Enabled']], 'is_public' => false, 'order' => 1],
            ['group' => 'appearance', 'key' => 'primary_color', 'display_name' => 'Primary Color', 'value' => '#865749', 'type' => 'color', 'details' => ['help' => 'Primary brand color used in the storefront UI.'], 'is_public' => true, 'order' => 1],
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

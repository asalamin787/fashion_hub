<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('sanitize_rich_content')) {
    function sanitize_rich_content(string $content): string
    {
        $content = strip_tags($content, '<p><br><strong><em><ul><ol><li><h2><h3><h4><blockquote><a>');

        return preg_replace('/javascript\s*:/i', '', $content) ?? $content;
    }
}

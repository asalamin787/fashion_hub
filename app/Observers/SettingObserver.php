<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Str;

class SettingObserver
{
    public function saving(Setting $setting): void
    {
        $setting->group = Str::of((string) $setting->group)
            ->trim()
            ->lower()
            ->replace(' ', '_')
            ->replace('-', '_')
            ->toString();

        [$group, $key] = Setting::resolveGroupAndKey((string) $setting->key, $setting->group ?: 'site');

        $setting->group = $group;
        $setting->key = Setting::normalizeKey($key);
        $setting->type = in_array($setting->type, Setting::TYPES, true) ? $setting->type : 'text';
        $setting->display_name = filled($setting->display_name)
            ? (string) $setting->display_name
            : Str::of($setting->key)->replace(['.', '_', '-'], ' ')->title()->toString();
        $setting->details = Setting::normalizeDetails($setting->details);
        $setting->value = Setting::normalizeValueForStorage($setting->value, $setting->type);
        $setting->order ??= 0;

        // Keep legacy columns in sync until the older schema is removed.
        $setting->setAttribute('label', $setting->display_name);
        $setting->setAttribute('description', data_get($setting->details, 'help'));
        $setting->setAttribute('sort_order', $setting->order);
    }

    public function saved(Setting $setting): void
    {
        Setting::forgetCache();
    }

    public function deleted(Setting $setting): void
    {
        Setting::forgetCache();
    }
}

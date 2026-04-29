<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Setting extends Model
{
    public const GROUPS = [
        'site',
        'admin',
        'seo',
        'social',
        'payment',
        'mail',
        'appearance',
    ];

    public const TYPES = [
        'text',
        'textarea',
        'rich_text',
        'number',
        'email',
        'url',
        'password',
        'checkbox',
        'toggle',
        'select_dropdown',
        'radio_btn',
        'image',
        'file',
        'color',
        'date',
        'datetime',
        'json',
    ];

    protected static string $settingsCacheKey = 'system.settings.all';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'group',
        'key',
        'display_name',
        'value',
        'type',
        'details',
        'order',
        'is_public',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'details' => 'array',
            'is_public' => 'boolean',
            'order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Setting $setting): void {
            $setting->group = static::normalizeGroup((string) $setting->group);
            [$group, $key] = static::resolveGroupAndKey((string) $setting->key, $setting->group ?: 'site');

            $setting->group = $group;
            $setting->key = $key;
            $setting->type = in_array($setting->type, static::TYPES, true) ? $setting->type : 'text';
            $setting->display_name = filled($setting->display_name)
                ? (string) $setting->display_name
                : Str::of($setting->key)->replace(['.', '_', '-'], ' ')->title()->toString();
            $setting->details = static::normalizeDetails($setting->details);
            $setting->value = static::normalizeValueForStorage($setting->value, $setting->type);
            $setting->order ??= 0;
            $setting->setAttribute('label', $setting->display_name);
            $setting->setAttribute('description', data_get($setting->details, 'help'));
            $setting->setAttribute('sort_order', $setting->order);
        });

        static::saved(fn (): bool => static::forgetCache());
        static::deleted(fn (): bool => static::forgetCache());
    }

    public function scopeForGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    public function scopeOrdered(Builder $query, string $direction = 'asc'): Builder
    {
        return $query
            ->orderBy('group')
            ->orderBy('order', $direction)
            ->orderBy('id', $direction);
    }

    public function getDotKeyAttribute(): string
    {
        return $this->group.'.'.$this->key;
    }

    public function getHelpTextAttribute(): ?string
    {
        $help = data_get($this->details, 'help');

        return is_string($help) ? $help : null;
    }

    public function getFormattedValueAttribute(): string
    {
        return static::formatValueForDisplay($this->value, $this->type);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        [$group, $settingKey] = static::resolveGroupAndKey($key);

        $setting = static::cachedSettings()->first(
            fn (Setting $row): bool => $row->group === $group && $row->key === $settingKey,
        );

        if (! $setting instanceof Setting) {
            return $default;
        }

        return static::castValueForRuntime($setting->value, $setting->type);
    }

    public static function set(string $key, mixed $value, string $group = 'site'): Setting
    {
        [$resolvedGroup, $resolvedKey] = static::resolveGroupAndKey($key, $group);

        $setting = static::query()->updateOrCreate(
            [
                'group' => $resolvedGroup,
                'key' => $resolvedKey,
            ],
            [
                'display_name' => Str::of($resolvedKey)->replace(['.', '_', '-'], ' ')->title()->toString(),
                'type' => static::inferTypeFromValue($value),
                'value' => $value,
            ],
        );

        static::forgetCache();

        return $setting;
    }

    public static function group(string $group): Collection
    {
        return static::cachedSettings()
            ->filter(fn (Setting $row): bool => $row->group === $group)
            ->sortBy('order')
            ->mapWithKeys(fn (Setting $row): array => [$row->key => static::castValueForRuntime($row->value, $row->type)]);
    }

    public static function forgetCache(): bool
    {
        return Cache::forget(static::$settingsCacheKey);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function allGrouped(): array
    {
        return static::cachedSettings()
            ->groupBy('group')
            ->map(function (Collection $rows): array {
                return $rows
                    ->sortBy('order')
                    ->mapWithKeys(fn (Setting $row): array => [$row->key => static::castValueForRuntime($row->value, $row->type)])
                    ->all();
            })
            ->all();
    }

    /**
     * @return array{0: string, 1: string}
     */
    public static function resolveGroupAndKey(string $key, string $defaultGroup = 'site'): array
    {
        $key = trim($key);

        if (! str_contains($key, '.')) {
            return [static::normalizeGroup($defaultGroup), static::normalizeKey($key)];
        }

        [$group, $settingKey] = explode('.', $key, 2);

        return [static::normalizeGroup($group), static::normalizeKey($settingKey)];
    }

    public static function normalizeGroup(string $group): string
    {
        return Str::of($group)
            ->trim()
            ->lower()
            ->replace(' ', '_')
            ->replace('-', '_')
            ->toString();
    }

    public static function normalizeKey(string $key): string
    {
        return Str::of($key)
            ->trim()
            ->lower()
            ->replace(' ', '_')
            ->replace('-', '_')
            ->trim('.')
            ->toString();
    }

    public static function normalizeDetails(mixed $details): ?array
    {
        if (blank($details)) {
            return null;
        }

        if (is_string($details)) {
            $decoded = json_decode($details, true);

            return is_array($decoded) ? $decoded : null;
        }

        return is_array($details) ? $details : null;
    }

    protected static function cachedSettings(): Collection
    {
        try {
            $cachedPayload = Cache::get(static::$settingsCacheKey);
        } catch (\Throwable) {
            $cachedPayload = null;
        }

        if (is_array($cachedPayload)) {
            return static::hydrate($cachedPayload);
        }

        static::forgetCache();

        $freshPayload = static::query()
            ->ordered()
            ->get()
            ->map(fn (Setting $setting): array => $setting->getAttributes())
            ->all();

        Cache::put(static::$settingsCacheKey, $freshPayload, now()->addHour());

        return static::hydrate($freshPayload);
    }

    public static function normalizeValueForStorage(mixed $value, string $type): ?string
    {
        if (($type === 'password') && blank($value)) {
            return null;
        }

        if ($value === null || $value === '') {
            return null;
        }

        return match ($type) {
            'checkbox', 'toggle' => filter_var($value, FILTER_VALIDATE_BOOLEAN) ? '1' : '0',
            'number' => is_numeric($value) ? (string) $value : null,
            'json' => is_array($value)
                ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                : (json_decode((string) $value, true) !== null
                    ? (string) $value
                    : json_encode([(string) $value], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)),
            default => is_array($value) ? (string) collect($value)->filter()->first() : (string) $value,
        };
    }

    public static function castValueForRuntime(mixed $value, string $type): mixed
    {
        if ($value === null) {
            return match ($type) {
                'checkbox', 'toggle' => false,
                'json' => [],
                default => null,
            };
        }

        if (($type === 'json') && is_array($value)) {
            return $value;
        }

        $value = (string) $value;

        return match ($type) {
            'checkbox', 'toggle' => filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false,
            'number' => str_contains($value, '.') ? (float) $value : (int) $value,
            'json' => json_decode($value, true) ?? [],
            default => $value,
        };
    }

    public static function inferTypeFromValue(mixed $value): string
    {
        return match (true) {
            is_bool($value) => 'toggle',
            is_int($value), is_float($value) => 'number',
            is_array($value) => 'json',
            default => 'text',
        };
    }

    protected static function formatValueForDisplay(mixed $value, string $type): string
    {
        $runtimeValue = static::castValueForRuntime($value, $type);

        if ($runtimeValue === null || $runtimeValue === '') {
            return '-';
        }

        return match ($type) {
            'checkbox', 'toggle' => $runtimeValue ? 'Enabled' : 'Disabled',
            'json' => Str::limit((string) json_encode($runtimeValue, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 120),
            'password' => '••••••••',
            default => Str::limit((string) $runtimeValue, 120),
        };
    }
}

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
        'general',
        'company',
        'seo',
        'payment',
        'mail',
        'social',
        'invoice',
        'shipping',
        'appearance',
        'security',
    ];

    public const TYPES = [
        'text',
        'textarea',
        'number',
        'boolean',
        'select',
        'json',
        'image',
        'file',
        'color',
    ];

    protected static string $settingsCacheKey = 'system.settings.all';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'label',
        'description',
        'is_public',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Setting $setting): void {
            if (! in_array($setting->type, self::TYPES, true)) {
                $setting->type = 'text';
            }

            $setting->value = static::normalizeValueByType($setting->value, $setting->type);

            if (blank($setting->label)) {
                $setting->label = Str::of((string) $setting->key)->replace(['.', '_', '-'], ' ')->title()->toString();
            }
        });

        static::saved(fn (): bool => static::forgetCache());
        static::deleted(fn (): bool => static::forgetCache());
    }

    public function scopeForGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
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

        return static::castStoredValue($setting->value, $setting->type);
    }

    public static function set(string $key, mixed $value, string $group = 'general'): Setting
    {
        if (str_contains($key, '.')) {
            [$parsedGroup, $parsedKey] = static::resolveGroupAndKey($key);

            $group = $parsedGroup;
            $key = $parsedKey;
        }

        [$storedValue, $resolvedType] = static::normalizeForStorage($value);

        $setting = static::query()->updateOrCreate(
            [
                'group' => $group,
                'key' => $key,
            ],
            [
                'value' => $storedValue,
                'type' => $resolvedType,
                'label' => Str::of($key)->replace(['.', '_', '-'], ' ')->title()->toString(),
            ],
        );

        static::forgetCache();

        return $setting;
    }

    public static function group(string $group): Collection
    {
        return static::cachedSettings()
            ->filter(fn (Setting $row): bool => $row->group === $group)
            ->sortBy('sort_order')
            ->mapWithKeys(fn (Setting $row): array => [$row->key => static::castStoredValue($row->value, $row->type)]);
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
                    ->sortBy('sort_order')
                    ->mapWithKeys(fn (Setting $row): array => [$row->key => static::castStoredValue($row->value, $row->type)])
                    ->all();
            })
            ->all();
    }

    protected static function cachedSettings(): Collection
    {
        /** @var Collection<int, Setting> $settings */
        $settings = Cache::remember(
            static::$settingsCacheKey,
            now()->addHour(),
            fn (): Collection => static::query()
                ->orderBy('group')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        );

        return $settings;
    }

    /**
     * @return array{0: string, 1: string}
     */
    protected static function resolveGroupAndKey(string $key): array
    {
        if (! str_contains($key, '.')) {
            return ['general', $key];
        }

        $segments = explode('.', $key, 2);

        return [$segments[0], $segments[1]];
    }

    /**
     * @return array{0: string|null, 1: string}
     */
    protected static function normalizeForStorage(mixed $value): array
    {
        if (is_bool($value)) {
            return [$value ? '1' : '0', 'boolean'];
        }

        if (is_int($value) || is_float($value)) {
            return [(string) $value, 'number'];
        }

        if (is_array($value)) {
            return [json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR), 'json'];
        }

        if ($value === null) {
            return [null, 'text'];
        }

        return [(string) $value, 'text'];
    }

    protected static function castStoredValue(mixed $value, string $type): mixed
    {
        if ($value === null) {
            return null;
        }

        if ($type === 'json' && is_array($value)) {
            return $value;
        }

        $value = (string) $value;

        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false,
            'number' => str_contains($value, '.') ? (float) $value : (int) $value,
            'json' => json_decode($value, true) ?? [],
            default => $value,
        };
    }

    protected static function formatValueForDisplay(mixed $value, string $type): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        if (is_array($value)) {
            return Str::limit((string) json_encode($value), 120);
        }

        $value = (string) $value;

        return match ($type) {
            'boolean' => ((filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false) ? 'True' : 'False'),
            'json' => Str::limit((string) $value, 120),
            default => Str::limit($value, 120),
        };
    }

    protected static function normalizeValueByType(mixed $value, string $type): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN) ? '1' : '0',
            'number' => is_numeric($value) ? (string) $value : null,
            'json' => is_array($value)
                ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                : (json_decode((string) $value) !== null ? (string) $value : json_encode([(string) $value], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)),
            default => (string) $value,
        };
    }
}

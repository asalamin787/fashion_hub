<?php

namespace App\Services\Settings;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SettingManagerService
{
    /**
     * @return array<string, string>
     */
    public function getManagerGroups(): array
    {
        return [
            'site' => 'Site',
            'admin' => 'Admin',
            'seo' => 'SEO',
            'social' => 'Social',
            'payment' => 'Payment',
            'mail' => 'Mail',
            'appearance' => 'Appearance',
        ];
    }

    /**
     * @return Collection<string, EloquentCollection<int, Setting>>
     */
    public function getGroupedSettings(): Collection
    {
        $settings = Setting::query()
            ->ordered()
            ->get()
            ->groupBy('group');

        return collect($this->getManagerGroups())
            ->mapWithKeys(fn (string $label, string $group): array => [$group => $settings->get($group, new EloquentCollection)]);
    }

    /**
     * @return array{values: array<int, mixed>}
     */
    public function getPageState(): array
    {
        return [
            'values' => Setting::query()
                ->ordered()
                ->get()
                ->mapWithKeys(fn (Setting $setting): array => [$setting->id => $this->mapValueForForm($setting)])
                ->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getSettingFormData(Setting $setting): array
    {
        return [
            'group' => $setting->group,
            'key' => $setting->key,
            'display_name' => $setting->display_name,
            'type' => $setting->type,
            'details_json' => $setting->details ? json_encode($setting->details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null,
            'order' => $setting->order,
            'is_public' => $setting->is_public,
            'value' => $this->mapValueForForm($setting),
        ];
    }

    public function createSetting(array $data): Setting
    {
        return DB::transaction(function () use ($data): Setting {
            $payload = $this->normalizePayload($data);

            $this->ensureUniqueKeyOrFail($payload['key']);

            $setting = new Setting($payload);
            $setting->save();

            return $setting;
        });
    }

    public function updateSetting(Setting $setting, array $data): Setting
    {
        return DB::transaction(function () use ($setting, $data): Setting {
            $payload = $this->normalizePayload($data, $setting);

            $this->ensureUniqueKeyOrFail($payload['key'], $setting->getKey());

            $setting->fill($payload);
            $setting->save();

            return $setting->refresh();
        });
    }

    /**
     * @param  array<int|string, mixed>  $values
     */
    public function saveValues(array $values): void
    {
        DB::transaction(function () use ($values): void {
            Setting::query()
                ->ordered()
                ->get()
                ->each(function (Setting $setting) use ($values): void {
                    if (! array_key_exists($setting->id, $values)) {
                        return;
                    }

                    $value = $values[$setting->id];

                    if ($setting->type === 'password' && blank($value)) {
                        return;
                    }

                    $setting->value = $value;
                    $setting->save();
                });
        });
    }

    public function deleteSetting(Setting $setting): void
    {
        DB::transaction(fn (): bool => (bool) $setting->delete());
    }

    public function moveSetting(Setting $setting, string $direction): void
    {
        DB::transaction(function () use ($setting, $direction): void {
            $query = Setting::query()
                ->where('group', $setting->group)
                ->whereKeyNot($setting->getKey());

            $swapTarget = match ($direction) {
                'up' => $query->where('order', '<', $setting->order)->ordered('desc')->first(),
                'down' => $query->where('order', '>', $setting->order)->ordered()->first(),
                default => null,
            };

            if (! $swapTarget instanceof Setting) {
                return;
            }

            $currentOrder = $setting->order;
            $setting->order = $swapTarget->order;
            $swapTarget->order = $currentOrder;

            $setting->save();
            $swapTarget->save();
        });
    }

    public function reorderByDrop(int $draggedSettingId, int $targetSettingId): void
    {
        DB::transaction(function () use ($draggedSettingId, $targetSettingId): void {
            $dragged = Setting::query()->find($draggedSettingId);
            $target = Setting::query()->find($targetSettingId);

            if (! $dragged instanceof Setting || ! $target instanceof Setting) {
                return;
            }

            if ($dragged->is($target) || ($dragged->group !== $target->group)) {
                return;
            }

            $ordered = Setting::query()
                ->where('group', $target->group)
                ->ordered()
                ->get()
                ->values();

            $draggedIndex = $ordered->search(fn (Setting $setting): bool => $setting->is($dragged));
            $targetIndex = $ordered->search(fn (Setting $setting): bool => $setting->is($target));

            if (! is_int($draggedIndex) || ! is_int($targetIndex)) {
                return;
            }

            $draggedSetting = $ordered->pull($draggedIndex);
            $reordered = $ordered->values();
            $reordered->splice($targetIndex, 0, [$draggedSetting]);

            $reordered
                ->values()
                ->each(function (Setting $setting, int $index): void {
                    $setting->order = $index + 1;
                    $setting->save();
                });
        });
    }

    public function canMoveUp(Setting $setting): bool
    {
        return Setting::query()
            ->where('group', $setting->group)
            ->where('order', '<', $setting->order)
            ->exists();
    }

    public function canMoveDown(Setting $setting): bool
    {
        return Setting::query()
            ->where('group', $setting->group)
            ->where('order', '>', $setting->order)
            ->exists();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function normalizePayload(array $data, ?Setting $setting = null): array
    {
        $group = (string) ($data['group'] ?? $setting?->group ?? 'site');
        $key = (string) ($data['key'] ?? $setting?->key ?? '');

        [$group, $key] = Setting::resolveGroupAndKey($key, $group);

        return [
            'group' => $group,
            'key' => $key,
            'display_name' => (string) ($data['display_name'] ?? $setting?->display_name ?? ''),
            'type' => (string) ($data['type'] ?? $setting?->type ?? 'text'),
            'value' => $data['value'] ?? $setting?->value,
            'details' => $this->decodeDetails($data['details_json'] ?? $setting?->details),
            'order' => (int) ($data['order'] ?? $setting?->order ?? $this->getNextOrder($group)),
            'is_public' => (bool) ($data['is_public'] ?? $setting?->is_public ?? false),
        ];
    }

    protected function getNextOrder(string $group): int
    {
        return (int) Setting::query()->where('group', $group)->max('order') + 1;
    }

    protected function decodeDetails(mixed $details): ?array
    {
        if (blank($details)) {
            return null;
        }

        if (is_array($details)) {
            return Setting::normalizeDetails($details);
        }

        $decoded = json_decode((string) $details, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw ValidationException::withMessages([
                'details_json' => 'Details must be valid JSON.',
            ]);
        }

        return Setting::normalizeDetails($decoded);
    }

    protected function mapValueForForm(Setting $setting): mixed
    {
        return Setting::castValueForRuntime($setting->value, $setting->type);
    }

    protected function ensureUniqueKeyOrFail(string $key, ?int $ignoreId = null): void
    {
        $query = Setting::query()->where('key', $key);

        if ($ignoreId !== null) {
            $query->whereKeyNot($ignoreId);
        }

        if (! $query->exists()) {
            return;
        }

        throw ValidationException::withMessages([
            'key' => 'This key already exists. Please use a different key or edit the existing setting.',
        ]);
    }
}

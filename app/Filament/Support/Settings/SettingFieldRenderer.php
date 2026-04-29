<?php

namespace App\Filament\Support\Settings;

use App\Models\Setting;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class SettingFieldRenderer
{
    /**
     * @return array<string, string>
     */
    public static function getTypeOptions(): array
    {
        return [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'rich_text' => 'Rich Text',
            'number' => 'Number',
            'email' => 'Email',
            'url' => 'URL',
            'password' => 'Password',
            'checkbox' => 'Checkbox',
            'toggle' => 'Toggle',
            'select_dropdown' => 'Select Dropdown',
            'radio_btn' => 'Radio Button',
            'image' => 'Image',
            'file' => 'File',
            'color' => 'Color',
            'date' => 'Date',
            'datetime' => 'Datetime',
            'json' => 'JSON',
        ];
    }

    public static function makeManagerField(Setting $setting, string $statePath): Field
    {
        $component = match ($setting->type) {
            'textarea' => Textarea::make($statePath)->rows(4),
            'rich_text' => RichEditor::make($statePath)->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link', 'redo', 'undo']),
            'number' => TextInput::make($statePath)->numeric()->inputMode('decimal'),
            'email' => TextInput::make($statePath)->email(),
            'url' => TextInput::make($statePath)->url(),
            'password' => TextInput::make($statePath)->password()->revealable(),
            'checkbox' => Checkbox::make($statePath),
            'toggle' => Toggle::make($statePath)->inline(false),
            'select_dropdown' => Select::make($statePath)->native(false)->options(self::normalizeOptions(data_get($setting->details, 'options', []))),
            'radio_btn' => Radio::make($statePath)->options(self::normalizeOptions(data_get($setting->details, 'options', [])))->inline(),
            'image' => FileUpload::make($statePath)->image()->disk('public')->directory('settings/images')->visibility('public')->openable()->downloadable(),
            'file' => FileUpload::make($statePath)->disk('public')->directory('settings/files')->visibility('public')->openable()->downloadable(),
            'color' => ColorPicker::make($statePath),
            'date' => DatePicker::make($statePath)->native(false),
            'datetime' => DateTimePicker::make($statePath)->native(false),
            'json' => KeyValue::make($statePath)->keyLabel('Key')->valueLabel('Value')->reorderable(),
            default => TextInput::make($statePath),
        };

        return $component
            ->hiddenLabel()
            ->helperText(self::managerHelperText($setting));
    }

    /**
     * @return array<int, Field>
     */
    public static function makeDynamicValueFields(string $valueName = 'value', string $typeName = 'type', string $detailsName = 'details_json'): array
    {
        return [
            TextInput::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => in_array((string) $get($typeName), ['text', 'number', 'email', 'url', 'password'], true))
                ->email(fn (Get $get): bool => $get($typeName) === 'email')
                ->url(fn (Get $get): bool => $get($typeName) === 'url')
                ->numeric(fn (Get $get): bool => $get($typeName) === 'number')
                ->password(fn (Get $get): bool => $get($typeName) === 'password')
                ->revealable(fn (Get $get): bool => $get($typeName) === 'password'),
            Textarea::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'textarea')
                ->rows(5),
            RichEditor::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'rich_text')
                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link', 'redo', 'undo']),
            Checkbox::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'checkbox'),
            Toggle::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'toggle'),
            Select::make($valueName)
                ->label('Value')
                ->native(false)
                ->visible(fn (Get $get): bool => $get($typeName) === 'select_dropdown')
                ->options(fn (Get $get): array => self::extractOptionsFromJson((string) $get($detailsName))),
            Radio::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'radio_btn')
                ->inline()
                ->options(fn (Get $get): array => self::extractOptionsFromJson((string) $get($detailsName))),
            FileUpload::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'image')
                ->image()
                ->disk('public')
                ->directory('settings/images')
                ->visibility('public')
                ->openable()
                ->downloadable(),
            FileUpload::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'file')
                ->disk('public')
                ->directory('settings/files')
                ->visibility('public')
                ->openable()
                ->downloadable(),
            ColorPicker::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'color'),
            DatePicker::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'date')
                ->native(false),
            DateTimePicker::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'datetime')
                ->native(false),
            KeyValue::make($valueName)
                ->label('Value')
                ->visible(fn (Get $get): bool => $get($typeName) === 'json')
                ->keyLabel('Key')
                ->valueLabel('Value')
                ->reorderable(),
        ];
    }

    public static function managerHelperText(Setting $setting): Htmlable
    {
        if (blank($setting->help_text)) {
            return new HtmlString('');
        }

        return new HtmlString('<div class="text-xs text-gray-500 dark:text-gray-400">'.e($setting->help_text).'</div>');
    }

    /**
     * @return array<int, mixed>
     */
    protected static function extractOptionsFromJson(string $detailsJson): array
    {
        if (blank($detailsJson)) {
            return [];
        }

        $decoded = json_decode($detailsJson, true);

        if (! is_array($decoded)) {
            return [];
        }

        return self::normalizeOptions(data_get($decoded, 'options', []));
    }

    /**
     * @return array<string, string>
     */
    protected static function normalizeOptions(mixed $options): array
    {
        if (! is_array($options)) {
            return [];
        }

        $normalized = [];

        foreach ($options as $key => $option) {
            if (is_array($option)) {
                $value = (string) ($option['value'] ?? $key);
                $label = (string) ($option['label'] ?? $value);
                $normalized[$value] = $label;

                continue;
            }

            $normalized[(string) $key] = (string) $option;
        }

        return $normalized;
    }
}

<?php

namespace App\Filament\Resources\Settings\Schemas;

use App\Models\Setting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Validation\Rules\Unique;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Settings workspace')
                    ->description('Manage platform configuration from one centralized settings system.')
                    ->icon(Heroicon::Cog6Tooth)
                    ->components([
                        Tabs::make('Setting tabs')
                            ->persistTabInQueryString('settings-tab')
                            ->tabs([
                                Tab::make('Definition')
                                    ->icon(Heroicon::Identification)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        Select::make('group')
                                            ->required()
                                            ->native(false)
                                            ->options(array_combine(Setting::GROUPS, array_map(static fn (string $value): string => ucfirst($value), Setting::GROUPS)))
                                            ->default('general'),
                                        TextInput::make('key')
                                            ->required()
                                            ->maxLength(120)
                                            ->placeholder('site_name')
                                            ->helperText('Use snake_case, dot notation, or kebab-case keys (example: site_name, company.phone).')
                                            ->rules(['regex:/^[a-z0-9._-]+$/'])
                                            ->unique(
                                                ignoreRecord: true,
                                                modifyRuleUsing: fn (Unique $rule, Get $get): Unique => $rule->where('group', $get('group')),
                                            ),
                                        TextInput::make('label')
                                            ->required()
                                            ->maxLength(191)
                                            ->placeholder('Site Name'),
                                        Select::make('type')
                                            ->required()
                                            ->native(false)
                                            ->live()
                                            ->default('text')
                                            ->options(array_combine(Setting::TYPES, array_map(static fn (string $value): string => ucfirst($value), Setting::TYPES))),
                                        Textarea::make('description')
                                            ->rows(3)
                                            ->columnSpanFull()
                                            ->placeholder('Describe this setting for future admins.'),
                                    ]),
                                Tab::make('Value')
                                    ->icon(Heroicon::AdjustmentsHorizontal)
                                    ->columns(1)
                                    ->components([
                                        TextInput::make('value')
                                            ->label('Setting value')
                                            ->visible(fn (Get $get): bool => in_array((string) $get('type'), ['text', 'number', 'select', 'image', 'file', 'color'], true))
                                            ->placeholder(fn (Get $get): string => match ((string) $get('type')) {
                                                'number' => '100',
                                                'color' => '#865749',
                                                'image' => '/storage/settings/logo.png',
                                                'file' => '/storage/settings/terms.pdf',
                                                'select' => 'default-option',
                                                default => 'Enter setting value',
                                            })
                                            ->helperText(fn (Get $get): ?string => $get('type') === 'select' ? 'For select type, store the selected option key.' : null)
                                            ->rules(fn (Get $get): array => $get('type') === 'number' ? ['nullable', 'numeric'] : ['nullable']),
                                        Toggle::make('value')
                                            ->label('Boolean value')
                                            ->visible(fn (Get $get): bool => $get('type') === 'boolean')
                                            ->inline(false),
                                        Textarea::make('value')
                                            ->label('Setting value')
                                            ->visible(fn (Get $get): bool => in_array((string) $get('type'), ['textarea', 'json'], true))
                                            ->rows(fn (Get $get): int => $get('type') === 'json' ? 10 : 5)
                                            ->placeholder(fn (Get $get): string => $get('type') === 'json'
                                                ? '{"key": "value"}'
                                                : 'Enter long text value')
                                            ->helperText(fn (Get $get): ?string => $get('type') === 'json'
                                                ? 'Valid JSON is recommended for structured settings.'
                                                : null)
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Visibility')
                                    ->icon(Heroicon::Eye)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        Toggle::make('is_public')
                                            ->label('Public setting')
                                            ->default(false)
                                            ->helperText('Public settings may be used on the frontend or public APIs.'),
                                        TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(0)
                                            ->required(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

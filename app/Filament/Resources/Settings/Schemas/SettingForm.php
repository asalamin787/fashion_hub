<?php

namespace App\Filament\Resources\Settings\Schemas;

use App\Filament\Support\Settings\SettingFieldRenderer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

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
                                            ->options([
                                                'site' => 'Site',
                                                'admin' => 'Admin',
                                                'seo' => 'SEO',
                                                'social' => 'Social',
                                                'payment' => 'Payment',
                                                'mail' => 'Mail',
                                                'appearance' => 'Appearance',
                                            ])
                                            ->default('site'),
                                        TextInput::make('key')
                                            ->required()
                                            ->maxLength(120)
                                            ->placeholder('title')
                                            ->helperText('Store the setting key segment only. Example: title, favicon, cod_enabled.')
                                            ->rules(['regex:/^[a-z0-9._-]+$/'])
                                            ->unique(ignoreRecord: true),
                                        TextInput::make('display_name')
                                            ->required()
                                            ->maxLength(191)
                                            ->placeholder('Site Title'),
                                        Select::make('type')
                                            ->required()
                                            ->native(false)
                                            ->live()
                                            ->default('text')
                                            ->options(SettingFieldRenderer::getTypeOptions()),
                                        Textarea::make('details_json')
                                            ->label('Details JSON')
                                            ->rows(6)
                                            ->columnSpanFull()
                                            ->placeholder('{"help":"Shown under the input","options":{"cod":"Cash on Delivery"}}'),
                                    ]),
                                Tab::make('Value')
                                    ->icon(Heroicon::AdjustmentsHorizontal)
                                    ->columns(1)
                                    ->components(SettingFieldRenderer::makeDynamicValueFields()),
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
                                        TextInput::make('order')
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

<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product workspace')
                    ->description('Manage product content, media, pricing, attributes, and generated variants from one JSON-driven catalog record.')
                    ->icon(Heroicon::ShoppingBag)
                    ->components([
                        Tabs::make('Product tabs')
                            ->persistTabInQueryString('product-tab')
                            ->tabs([
                                Tab::make('Basic Info')
                                    ->icon(Heroicon::Identification)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        Section::make('Catalog basics')
                                            ->description('Set the core identity, merchandising category, and publishing status for this product.')
                                            ->columns([
                                                'default' => 1,
                                                'md' => 2,
                                            ])
                                            ->components([
                                                TextInput::make('name')
                                                    ->label('Product name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('Classic Crew Tee')
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function (?string $state, ?string $old, Set $set, Get $get): void {
                                                        $currentSlug = (string) $get('slug');
                                                        $oldSlug = Str::slug((string) $old);

                                                        if (blank($currentSlug) || ($currentSlug === $oldSlug)) {
                                                            $set('slug', Str::slug((string) $state));
                                                        }
                                                    })
                                                    ->columnSpanFull(),
                                                TextInput::make('slug')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('classic-crew-tee')
                                                    ->helperText('Use a stable URL slug for the storefront and internal references.')
                                                    ->unique(ignoreRecord: true),
                                                Select::make('category_id')
                                                    ->label('Category')
                                                    ->relationship('category', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->native(false)
                                                    ->placeholder('Select a category'),
                                                Select::make('brand_id')
                                                    ->label('Brand')
                                                    ->relationship('brand', 'name', fn (Builder $query): Builder => $query->where('is_active', true)->orderBy('sort_order'))
                                                    ->searchable()
                                                    ->preload()
                                                    ->native(false)
                                                    ->placeholder('Select a brand'),
                                                Select::make('status')
                                                    ->required()
                                                    ->native(false)
                                                    ->default('draft')
                                                    ->options([
                                                        'draft' => 'Draft',
                                                        'active' => 'Active',
                                                        'inactive' => 'Inactive',
                                                    ])
                                                    ->helperText('Draft keeps the product editable without exposing it to the storefront.'),
                                                Select::make('badge')
                                                    ->label('Product badge')
                                                    ->native(false)
                                                    ->placeholder('Auto (Sale/New)')
                                                    ->options([
                                                        'New' => 'New',
                                                        'Sale' => 'Sale',
                                                        'Best Seller' => 'Best Seller',
                                                        'Hot' => 'Hot',
                                                    ])
                                                    ->helperText('Optional storefront badge. Leave empty to use automatic badge logic.'),
                                                Toggle::make('has_variants')
                                                    ->label('This product has variants')
                                                    ->default(false)
                                                    ->live()
                                                    ->helperText('Enable this when pricing and stock are managed per variant instead of one simple SKU.'),
                                                Textarea::make('short_description')
                                                    ->rows(3)
                                                    ->placeholder('Short summary for cards, listings, and product snippets.')
                                                    ->columnSpanFull(),
                                                Textarea::make('description')
                                                    ->rows(8)
                                                    ->placeholder('Full merchandising description with fabric notes, fit details, and care guidance.')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Media')
                                    ->icon(Heroicon::Photo)
                                    ->columns(1)
                                    ->components([
                                        Section::make('Product media')
                                            ->description('Upload the primary product image and supporting gallery images with live previews.')
                                            ->columns([
                                                'default' => 1,
                                                'md' => 2,
                                            ])
                                            ->components([
                                                FileUpload::make('featured_image')
                                                    ->label('Featured image')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->directory('products/featured')
                                                    ->disk('public')
                                                    ->visibility('public')
                                                    ->helperText('Primary image used in tables, cards, and product detail hero areas.')
                                                    ->columnSpanFull(),
                                                FileUpload::make('gallery_images')
                                                    ->label('Gallery images')
                                                    ->multiple()
                                                    ->reorderable()
                                                    ->appendFiles()
                                                    ->image()
                                                    ->imageEditor()
                                                    ->directory('products/gallery')
                                                    ->disk('public')
                                                    ->visibility('public')
                                                    ->helperText('Optional supporting gallery for alternate angles and detail shots.')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Pricing & Stock')
                                    ->icon(Heroicon::Banknotes)
                                    ->columns(1)
                                    ->components([
                                        Section::make('Simple product pricing')
                                            ->description('These fields apply when variants are disabled, or can stay as fallback defaults when variants are later generated.')
                                            ->columns([
                                                'default' => 1,
                                                'md' => 3,
                                            ])
                                            ->components([
                                                Placeholder::make('pricing_mode')
                                                    ->label('Pricing mode')
                                                    ->content(fn (Get $get): string => $get('has_variants')
                                                        ? 'Variants are enabled. Product-level pricing is optional fallback data.'
                                                        : 'Simple pricing is active. Base price, sale price, and stock drive the storefront value.')
                                                    ->columnSpanFull(),
                                                TextInput::make('base_price')
                                                    ->label('Base price')
                                                    ->numeric()
                                                    ->inputMode('decimal')
                                                    ->placeholder('1200.00')
                                                    ->required(fn (Get $get): bool => ! $get('has_variants'))
                                                    ->visible(fn (Get $get): bool => ! $get('has_variants')),
                                                TextInput::make('sale_price')
                                                    ->label('Sale price')
                                                    ->numeric()
                                                    ->inputMode('decimal')
                                                    ->placeholder('999.00')
                                                    ->visible(fn (Get $get): bool => ! $get('has_variants'))
                                                    ->rule(function (Get $get): Closure {
                                                        return function (string $attribute, mixed $value, Closure $fail) use ($get): void {
                                                            $basePrice = static::toNumber($get('base_price'));
                                                            $salePrice = static::toNumber($value);

                                                            if ($basePrice !== null && $salePrice !== null && $salePrice > $basePrice) {
                                                                $fail('The sale price must be less than or equal to the base price.');
                                                            }
                                                        };
                                                    }),
                                                TextInput::make('stock')
                                                    ->label('Stock')
                                                    ->integer()
                                                    ->default(0)
                                                    ->minValue(0)
                                                    ->placeholder('0')
                                                    ->required(fn (Get $get): bool => ! $get('has_variants'))
                                                    ->visible(fn (Get $get): bool => ! $get('has_variants')),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Attributes')
                                    ->icon(Heroicon::Swatch)
                                    ->columns(1)
                                    ->components([
                                        Section::make('Variation attributes')
                                            ->description('Define variant drivers such as size or style. Each value becomes part of the generated variant combinations.')
                                            ->components([
                                                Repeater::make('attributes')
                                                    ->label('Attributes')
                                                    ->defaultItems(0)
                                                    ->itemLabel(fn (array $state): string => filled($state['name'] ?? null) ? (string) $state['name'] : 'Attribute')
                                                    ->schema([
                                                        TextInput::make('name')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->placeholder('Size')
                                                            ->live(onBlur: true)
                                                            ->afterStateUpdated(function (?string $state, ?string $old, Set $set, Get $get): void {
                                                                $currentSlug = (string) $get('slug');
                                                                $oldSlug = Str::slug((string) $old);

                                                                if (blank($currentSlug) || ($currentSlug === $oldSlug)) {
                                                                    $set('slug', Str::slug((string) $state));
                                                                }
                                                            }),
                                                        TextInput::make('slug')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->placeholder('size')
                                                            ->helperText('Lowercase JSON key used to map variant combinations.'),
                                                        Select::make('display_type')
                                                            ->required()
                                                            ->native(false)
                                                            ->default('text')
                                                            ->options([
                                                                'text' => 'Text',
                                                                'image' => 'Image',
                                                            ])
                                                            ->live()
                                                            ->helperText('Use image only when each attribute value needs its own thumbnail.'),
                                                        Repeater::make('values')
                                                            ->label('Attribute values')
                                                            ->defaultItems(1)
                                                            ->itemLabel(fn (array $state): string => filled($state['label'] ?? null) ? (string) $state['label'] : 'Value')
                                                            ->columns([
                                                                'default' => 1,
                                                                'md' => 3,
                                                            ])
                                                            ->schema([
                                                                TextInput::make('label')
                                                                    ->required()
                                                                    ->maxLength(255)
                                                                    ->placeholder('Small')
                                                                    ->live(onBlur: true)
                                                                    ->afterStateUpdated(function (?string $state, ?string $old, Set $set, Get $get): void {
                                                                        $currentValue = (string) $get('value');
                                                                        $oldValue = Str::slug((string) $old);

                                                                        if (blank($currentValue) || ($currentValue === $oldValue)) {
                                                                            $set('value', Str::slug((string) $state));
                                                                        }
                                                                    }),
                                                                TextInput::make('value')
                                                                    ->required()
                                                                    ->maxLength(255)
                                                                    ->placeholder('s')
                                                                    ->helperText('Stored JSON value used in variant attribute maps.'),
                                                                FileUpload::make('image')
                                                                    ->label('Value image')
                                                                    ->image()
                                                                    ->imageEditor()
                                                                    ->directory('products/attributes')
                                                                    ->disk('public')
                                                                    ->visibility('public')
                                                                    ->visible(fn (Get $get): bool => $get('../../display_type') === 'image'),
                                                            ])
                                                            ->columnSpanFull(),
                                                    ])
                                                    ->columns([
                                                        'default' => 1,
                                                        'md' => 3,
                                                    ])
                                                    ->helperText('Only text and image display types are supported. Duplicate attribute slugs are blocked on save.')
                                                    ->rule(function (): Closure {
                                                        return function (string $attribute, mixed $value, Closure $fail): void {
                                                            static::validateAttributesState(is_array($value) ? $value : [], $fail);
                                                        };
                                                    })
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Variants')
                                    ->icon(Heroicon::SquaresPlus)
                                    ->columns(1)
                                    ->components([
                                        Section::make('Generated variants')
                                            ->description('Generate every valid combination from the selected attributes. Matching combinations preserve existing SKU, price, stock, and image data.')
                                            ->headerActions([
                                                Action::make('generateVariants')
                                                    ->label('Generate Variants')
                                                    ->icon(Heroicon::Sparkles)
                                                    ->color('primary')
                                                    ->visible(fn (Get $get): bool => (bool) $get('has_variants'))
                                                    ->action(function (Get $get, Set $set): void {
                                                        $product = new Product([
                                                            'name' => $get('name'),
                                                            'slug' => $get('slug'),
                                                            'base_price' => $get('base_price'),
                                                            'sale_price' => $get('sale_price'),
                                                            'stock' => $get('stock') ?? 0,
                                                            'attributes' => $get('attributes') ?? [],
                                                            'variants' => $get('variants') ?? [],
                                                        ]);

                                                        $variants = $product->generateVariantsFromAttributes();

                                                        if ($variants === []) {
                                                            throw ValidationException::withMessages([
                                                                'attributes' => 'Add at least one attribute with one or more values before generating variants.',
                                                            ]);
                                                        }

                                                        $set('variants', $variants);
                                                    })
                                                    ->successNotificationTitle('Variants generated successfully.'),
                                            ])
                                            ->components([
                                                Placeholder::make('variants_hint')
                                                    ->label('Variant workflow')
                                                    ->content(fn (Get $get): string => $get('has_variants')
                                                        ? 'Generate variants after defining attributes. Edit pricing and stock per combination below.'
                                                        : 'Enable variants in Pricing & Stock to unlock generated variant management.')
                                                    ->columnSpanFull(),
                                                Repeater::make('variants')
                                                    ->label('Variants')
                                                    ->visible(fn (Get $get): bool => (bool) $get('has_variants'))
                                                    ->defaultItems(0)
                                                    ->addable(false)
                                                    ->reorderable(false)
                                                    ->itemLabel(fn (array $state): string => Product::formatVariantLabel($state))
                                                    ->schema([
                                                        Hidden::make('id'),
                                                        Hidden::make('attributes'),
                                                        Hidden::make('attribute_labels'),
                                                        Placeholder::make('combination_label')
                                                            ->label('Combination')
                                                            ->content(fn (Get $get): string => Product::formatAttributePairs(
                                                                is_array($get('attribute_labels')) ? $get('attribute_labels') : [],
                                                                is_array($get('attributes')) ? $get('attributes') : [],
                                                            ))
                                                            ->columnSpanFull(),
                                                        TextInput::make('sku')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->placeholder('CLASSIC-CREW-TEE-S-BLACK'),
                                                        TextInput::make('barcode')
                                                            ->maxLength(255)
                                                            ->placeholder('Optional barcode'),
                                                        Select::make('status')
                                                            ->required()
                                                            ->native(false)
                                                            ->default('active')
                                                            ->options([
                                                                'active' => 'Active',
                                                                'inactive' => 'Inactive',
                                                            ]),
                                                        TextInput::make('price')
                                                            ->required()
                                                            ->numeric()
                                                            ->inputMode('decimal')
                                                            ->placeholder('1200.00'),
                                                        TextInput::make('sale_price')
                                                            ->numeric()
                                                            ->inputMode('decimal')
                                                            ->placeholder('999.00')
                                                            ->rule(function (Get $get): Closure {
                                                                return function (string $attribute, mixed $value, Closure $fail) use ($get): void {
                                                                    $price = static::toNumber($get('price'));
                                                                    $salePrice = static::toNumber($value);

                                                                    if ($price !== null && $salePrice !== null && $salePrice > $price) {
                                                                        $fail('The sale price must be less than or equal to the variant price.');
                                                                    }
                                                                };
                                                            }),
                                                        DateTimePicker::make('sale_start_at')
                                                            ->seconds(false)
                                                            ->native(false),
                                                        DateTimePicker::make('sale_end_at')
                                                            ->seconds(false)
                                                            ->native(false)
                                                            ->rule(function (Get $get): Closure {
                                                                return function (string $attribute, mixed $value, Closure $fail) use ($get): void {
                                                                    $saleStartAt = static::toDate($get('sale_start_at'));
                                                                    $saleEndAt = static::toDate($value);

                                                                    if ($saleStartAt !== null && $saleEndAt !== null && $saleEndAt->lt($saleStartAt)) {
                                                                        $fail('The sale end date must be after or equal to the sale start date.');
                                                                    }
                                                                };
                                                            }),
                                                        TextInput::make('stock')
                                                            ->required()
                                                            ->integer()
                                                            ->minValue(0)
                                                            ->default(0),
                                                        TextInput::make('low_stock_alert')
                                                            ->required()
                                                            ->integer()
                                                            ->minValue(0)
                                                            ->default(0),
                                                        FileUpload::make('image')
                                                            ->label('Variant image')
                                                            ->image()
                                                            ->imageEditor()
                                                            ->directory('products/variants')
                                                            ->disk('public')
                                                            ->visibility('public')
                                                            ->columnSpanFull(),
                                                        Toggle::make('is_default')
                                                            ->label('Default variant')
                                                            ->helperText('Only one generated variant can be marked as the default storefront option.'),
                                                    ])
                                                    ->columns([
                                                        'default' => 1,
                                                        'md' => 3,
                                                    ])
                                                    ->helperText('Generated combinations stay unique by their attribute map. Duplicate defaults are blocked on save.')
                                                    ->rule(function (): Closure {
                                                        return function (string $attribute, mixed $value, Closure $fail): void {
                                                            static::validateVariantsState(is_array($value) ? $value : [], $fail);
                                                        };
                                                    })
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('SEO')
                                    ->icon(Heroicon::MagnifyingGlass)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        Section::make('Search metadata')
                                            ->description('Store essential SEO metadata in the product JSON payload for storefront rendering.')
                                            ->columns([
                                                'default' => 1,
                                                'md' => 2,
                                            ])
                                            ->components([
                                                TextInput::make('seo.meta_title')
                                                    ->label('Meta title')
                                                    ->maxLength(255)
                                                    ->placeholder('Classic Crew Tee | Fashion Hub'),
                                                TextInput::make('seo.canonical_url')
                                                    ->label('Canonical URL')
                                                    ->url()
                                                    ->placeholder('https://fashionhub.test/products/classic-crew-tee'),
                                                Textarea::make('seo.meta_description')
                                                    ->label('Meta description')
                                                    ->rows(4)
                                                    ->placeholder('Short SEO summary for search engine snippets.')
                                                    ->columnSpanFull(),
                                                TextInput::make('seo.meta_keywords')
                                                    ->label('Meta keywords')
                                                    ->placeholder('crew tee, cotton t-shirt, fashion basics')
                                                    ->helperText('Comma-separated keywords stored as plain text in the SEO JSON payload.')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function toNumber(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return round((float) $value, 2);
    }

    private static function toDate(mixed $value): ?Carbon
    {
        if (blank($value)) {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }

    private static function validateAttributesState(array $attributes, Closure $fail): void
    {
        $attributeSlugs = [];

        foreach ($attributes as $index => $attribute) {
            if (! is_array($attribute)) {
                continue;
            }

            $slug = Str::slug((string) ($attribute['slug'] ?? ''));

            if (blank($slug)) {
                continue;
            }

            if (in_array($slug, $attributeSlugs, true)) {
                $fail('Each attribute must use a unique slug. Duplicate slug found for attribute #'.($index + 1).'.');

                return;
            }

            $attributeSlugs[] = $slug;
            $valueKeys = [];

            foreach ($attribute['values'] ?? [] as $valueIndex => $value) {
                if (! is_array($value)) {
                    continue;
                }

                $valueKey = Str::slug((string) ($value['value'] ?? $value['label'] ?? ''));

                if (blank($valueKey)) {
                    continue;
                }

                if (in_array($valueKey, $valueKeys, true)) {
                    $fail('Each attribute value must be unique within the same attribute. Duplicate value found for attribute #'.($index + 1).' item #'.($valueIndex + 1).'.');

                    return;
                }

                $valueKeys[] = $valueKey;
            }
        }
    }

    private static function validateVariantsState(array $variants, Closure $fail): void
    {
        $keys = [];
        $defaultCount = 0;

        foreach ($variants as $index => $variant) {
            if (! is_array($variant)) {
                continue;
            }

            $key = Product::buildVariantKey(is_array($variant['attributes'] ?? null) ? $variant['attributes'] : []);

            if (filled($key) && in_array($key, $keys, true)) {
                $fail('Duplicate variant combinations are not allowed. Duplicate found at variant #'.($index + 1).'.');

                return;
            }

            if (filled($key)) {
                $keys[] = $key;
            }

            if ((bool) ($variant['is_default'] ?? false)) {
                $defaultCount++;
            }

            $price = static::toNumber($variant['price'] ?? null);
            $salePrice = static::toNumber($variant['sale_price'] ?? null);
            $saleStartAt = static::toDate($variant['sale_start_at'] ?? null);
            $saleEndAt = static::toDate($variant['sale_end_at'] ?? null);

            if ($price !== null && $salePrice !== null && $salePrice > $price) {
                $fail('Variant sale prices must be less than or equal to the variant price.');

                return;
            }

            if ($saleStartAt !== null && $saleEndAt !== null && $saleEndAt->lt($saleStartAt)) {
                $fail('Variant sale start dates must be before or equal to sale end dates.');

                return;
            }
        }

        if ($defaultCount > 1) {
            $fail('Only one variant can be marked as the default variant.');
        }
    }
}

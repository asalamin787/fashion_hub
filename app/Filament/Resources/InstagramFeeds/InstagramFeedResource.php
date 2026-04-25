<?php

namespace App\Filament\Resources\InstagramFeeds;

use App\Filament\Resources\InstagramFeeds\Pages\CreateInstagramFeed;
use App\Filament\Resources\InstagramFeeds\Pages\EditInstagramFeed;
use App\Filament\Resources\InstagramFeeds\Pages\ListInstagramFeeds;
use App\Filament\Resources\InstagramFeeds\Pages\ViewInstagramFeed;
use App\Filament\Resources\InstagramFeeds\Schemas\InstagramFeedForm;
use App\Filament\Resources\InstagramFeeds\Schemas\InstagramFeedInfolist;
use App\Filament\Resources\InstagramFeeds\Tables\InstagramFeedsTable;
use App\Models\InstagramFeed;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InstagramFeedResource extends Resource
{
    protected static ?string $model = InstagramFeed::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Instagram';

    protected static ?string $modelLabel = 'Instagram Feed';

    protected static ?string $pluralModelLabel = 'Instagram Feeds';

    protected static string|UnitEnum|null $navigationGroup = 'Catalog Management';

    protected static ?int $navigationSort = 8;

    protected static ?string $recordTitleAttribute = 'section_title';

    public static function form(Schema $schema): Schema
    {
        return InstagramFeedForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InstagramFeedInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstagramFeedsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInstagramFeeds::route('/'),
            'create' => CreateInstagramFeed::route('/create'),
            'view' => ViewInstagramFeed::route('/{record}'),
            'edit' => EditInstagramFeed::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }
}

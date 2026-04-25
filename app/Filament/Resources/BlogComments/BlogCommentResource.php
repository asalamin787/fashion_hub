<?php

namespace App\Filament\Resources\BlogComments;

use App\Filament\Resources\BlogComments\Pages\EditBlogComment;
use App\Filament\Resources\BlogComments\Pages\ListBlogComments;
use App\Filament\Resources\BlogComments\Schemas\BlogCommentForm;
use App\Filament\Resources\BlogComments\Tables\BlogCommentsTable;
use App\Models\BlogComment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BlogCommentResource extends Resource
{
    protected static ?string $model = BlogComment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static ?string $navigationLabel = 'Blog Comments';

    protected static ?string $modelLabel = 'Blog Comment';

    protected static ?string $pluralModelLabel = 'Blog Comments';

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BlogCommentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlogCommentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBlogComments::route('/'),
            'edit' => EditBlogComment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::query()->where('is_approved', false)->count();
    }
}

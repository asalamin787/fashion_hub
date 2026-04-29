<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SettingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Setting details')
                    ->icon(Heroicon::Cog6Tooth)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        TextEntry::make('group')
                            ->badge()
                            ->color('info'),
                        TextEntry::make('key')
                            ->badge()
                            ->copyable()
                            ->formatStateUsing(fn ($state, $record): string => $record->dot_key),
                        TextEntry::make('display_name'),
                        TextEntry::make('type')
                            ->badge()
                            ->color('warning'),
                        TextEntry::make('formatted_value')
                            ->label('Value')
                            ->columnSpanFull(),
                        TextEntry::make('help_text')
                            ->label('Help text')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        IconEntry::make('is_public')
                            ->label('Public')
                            ->boolean(),
                        TextEntry::make('order'),
                        TextEntry::make('created_at')
                            ->dateTime('d M Y, h:i A'),
                        TextEntry::make('updated_at')
                            ->dateTime('d M Y, h:i A'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

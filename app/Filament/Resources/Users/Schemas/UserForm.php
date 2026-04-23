<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Designer B')
                    ->description('A modern tabbed profile workspace with a guided flow from identity to permissions and contact intelligence.')
                    ->icon(Heroicon::Sparkles)
                    // ->aside()
                    ->components([
                        Tabs::make('Workflow tabs')
                            ->activeTab(1)
                            ->persistTabInQueryString('user-form-tab')
                            ->tabs([
                                Tab::make('Profile')
                                    ->icon(Heroicon::Identification)
                                    ->badge('Step 1')
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        TextInput::make('name')
                                            ->label('Full name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter full name')
                                            ->columnSpanFull(),
                                        TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('name@example.com')
                                            ->unique(ignoreRecord: true)
                                            ->columnSpanFull(),
                                        DatePicker::make('date_of_birth')
                                            ->label('Date of birth')
                                            ->native(false)
                                            ->closeOnDateSelection(),
                                        TextInput::make('phone')
                                            ->tel()
                                            ->maxLength(50)
                                            ->placeholder('+8801XXXXXXXXX'),
                                        TextInput::make('password')
                                            ->password()
                                            ->revealable()
                                            ->minLength(8)
                                            ->helperText(fn (string $operation): string => $operation === 'create'
                                                ? 'Set a secure password for the new account.'
                                                : 'Leave blank to keep current password.')
                                            ->required(fn (string $operation): bool => $operation === 'create')
                                            ->dehydrated(fn (?string $state): bool => filled($state))
                                            ->columnSpanFull(),
                                        FileUpload::make('avatar')
                                            ->label('Avatar image')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('users/avatars')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->maxSize(2048)
                                            ->preventFilePathTampering()
                                            ->getUploadedFileUsing(function (string $file): ?array {
                                                $path = storage_path('app/public/'.$file);

                                                if (! file_exists($path)) {
                                                    return null;
                                                }

                                                return [
                                                    'name' => basename($file),
                                                    'size' => filesize($path),
                                                    'type' => mime_content_type($path) ?: 'image/jpeg',
                                                    'url' => asset('storage/'.ltrim($file, '/')),
                                                ];
                                            })
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Access')
                                    ->icon(Heroicon::ShieldCheck)
                                    ->badge('Step 2')
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        Placeholder::make('access_summary')
                                            ->label('Admin rule')
                                            ->content('Only active admins can access the Filament admin panel.')
                                            ->columnSpanFull(),
                                        Select::make('role')
                                            ->label('Role')
                                            ->required()
                                            ->options([
                                                'admin' => 'Admin',
                                                'user' => 'Normal user',
                                            ])
                                            ->default('user')
                                            ->native(false),
                                        Toggle::make('is_active')
                                            ->label('Active account')
                                            ->helperText('Inactive users cannot log in to admin.')
                                            ->default(true),
                                        Textarea::make('admin_note')
                                            ->label('Admin note')
                                            ->placeholder('Optional internal note for admin users')
                                            ->rows(3)
                                            ->dehydrated(false)
                                            ->visible(fn (callable $get): bool => $get('role') === 'admin')
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Address')
                                    ->icon(Heroicon::MapPin)
                                    ->badge('Step 3')
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        TextInput::make('city')
                                            ->maxLength(255)
                                            ->placeholder('Dhaka'),
                                        TextInput::make('country')
                                            ->maxLength(255)
                                            ->placeholder('Bangladesh'),
                                        Textarea::make('address')
                                            ->rows(4)
                                            ->placeholder('House, road, area, postal code')
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Review')
                                    ->icon(Heroicon::ClipboardDocumentCheck)
                                    ->badge('Step 4')
                                    ->columns(1)
                                    ->components([
                                        Placeholder::make('review_hint')
                                            ->label('Before save')
                                            ->content('Confirm role, active status, and contact details before creating or updating this user record.'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

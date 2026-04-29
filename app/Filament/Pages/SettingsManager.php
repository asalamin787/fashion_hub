<?php

namespace App\Filament\Pages;

use App\Filament\Support\Settings\SettingFieldRenderer;
use App\Models\Setting;
use App\Services\Settings\SettingManagerService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions as SchemaActions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class SettingsManager extends Page
{
    protected string $view = 'filament.pages.settings-manager';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Settings Manager';

    protected static ?string $title = 'Settings Manager';

    protected static string|UnitEnum|null $navigationGroup = 'System Management';

    protected static ?int $navigationSort = 1;

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        abort_unless(static::canAccess(), 403);

        $this->fillForm();
    }

    public static function canAccess(): bool
    {
        return Filament::auth()->user()?->role === 'admin';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Form::make([
                    Tabs::make('Settings tabs')
                        ->persistTabInQueryString('settings-manager-tab')
                        ->tabs($this->getTabs()),
                ])
                    ->id('settings-manager-form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        SchemaActions::make([
                            $this->getSaveAction(),
                        ])
                            ->alignment(Alignment::End)
                            ->extraAttributes([
                                'class' => 'mt-4 border-t border-gray-200 pt-4 dark:border-gray-800',
                                'style' => 'margin-top: 10px; padding-top: 10px;',
                            ]),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('addSetting')
                ->label('Add New Setting')
                ->icon(Heroicon::Plus)
                ->color('primary')
                ->modalWidth(Width::FiveExtraLarge)
                ->stickyModalHeader()
                ->schema($this->getAddSettingSchema())
                ->action(function (array $data): void {
                    try {
                        $this->settingsService()->createSetting($data);
                    } catch (ValidationException $exception) {
                        Notification::make()
                            ->danger()
                            ->title('Could not create setting')
                            ->body((string) collect($exception->errors())->flatten()->first())
                            ->send();

                        return;
                    }

                    $this->fillForm();

                    Notification::make()
                        ->success()
                        ->title('Setting created')
                        ->body('The new setting has been added to the manager.')
                        ->send();

                    $this->redirect(static::getUrl(), navigate: true);
                }),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $this->settingsService()->saveValues($state['values'] ?? []);
        $this->fillForm();

        Notification::make()
            ->success()
            ->title('Settings saved')
            ->body('All setting values were updated successfully.')
            ->send();
    }

    public function reorderSettings(mixed $draggedSettingId, mixed $targetSettingId): void
    {
        $draggedSettingId = (int) $draggedSettingId;
        $targetSettingId = (int) $targetSettingId;

        if ($draggedSettingId < 1 || $targetSettingId < 1) {
            return;
        }

        $this->settingsService()->reorderByDrop($draggedSettingId, $targetSettingId);
        $this->fillForm();

        Notification::make()
            ->success()
            ->title('Settings reordered')
            ->body('The new setting order has been applied.')
            ->send();
    }

    public function getTitle(): string|Htmlable
    {
        return 'Settings Manager';
    }

    /**
     * @return array<int, Tab>
     */
    protected function getTabs(): array
    {
        return $this->settingsService()
            ->getGroupedSettings()
            ->map(function ($settings, string $group): Tab {
                $label = $this->settingsService()->getManagerGroups()[$group] ?? ucfirst($group);

                return Tab::make($label)
                    ->icon($this->resolveGroupIcon($group))
                    ->badge($settings->count())
                    ->badgeColor($settings->isEmpty() ? 'gray' : 'primary')
                    ->schema([
                        Section::make($label.' Settings')
                            ->description('Manage all '.strtolower($label).' settings from one place.')
                            ->icon($this->resolveGroupIcon($group))
                            ->compact()
                            ->schema($settings->isEmpty() ? [
                                Placeholder::make('empty_'.$group)
                                    ->hiddenLabel()
                                    ->content('No settings in this group yet. Use Add New Setting to create one.'),
                            ] : $settings->map(fn (Setting $setting): Grid => $this->makeSettingRow($setting))->all()),
                    ]);
            })
            ->values()
            ->all();
    }

    protected function makeSettingRow(Setting $setting): Grid
    {
        return Grid::make([
            'default' => 1,
            'xl' => 12,
        ])
            ->schema([
                Placeholder::make('meta_'.$setting->id)
                    ->hiddenLabel()
                    ->content($this->renderMetaContent($setting))
                    ->columnSpan([
                        'default' => 1,
                        'xl' => 3,
                    ]),
                SettingFieldRenderer::makeManagerField($setting, 'values.'.$setting->id)
                    ->columnSpan([
                        'default' => 1,
                        'xl' => 7,
                    ]),
                SchemaActions::make($this->getRowActions($setting))
                    ->alignment(Alignment::End)
                    ->columnSpan([
                        'default' => 1,
                        'xl' => 2,
                    ]),
            ])
            ->extraAttributes([
                'data-setting-row' => (string) $setting->id,
                'class' => 'group js-setting-row cursor-grab rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#865749]/35 hover:shadow-md active:cursor-grabbing dark:border-gray-800 dark:bg-gray-900',
            ]);
    }

    /**
     * @return array<int, Action>
     */
    protected function getRowActions(Setting $setting): array
    {
        return [
            Action::make('drag_hint_'.$setting->id)
                ->icon(Heroicon::Bars3)
                ->iconButton()
                ->tooltip('Drag and drop this row to reorder')
                ->color('gray')
                ->size('sm')
                ->action(static function (): void {})
                ->extraAttributes([
                    'data-drag-handle-for' => (string) $setting->id,
                    'draggable' => 'true',
                    'x-on:click.prevent' => '',
                    'style' => 'cursor: grab; touch-action: none;',
                ]),
            Action::make('edit_'.$setting->id)
                ->icon(Heroicon::PencilSquare)
                ->iconButton()
                ->tooltip('Edit setting metadata')
                ->size('sm')
                ->modalWidth(Width::FiveExtraLarge)
                ->stickyModalHeader()
                ->fillForm($this->settingsService()->getSettingFormData($setting))
                ->schema([
                    ...$this->getMetadataSchema(),
                    ...SettingFieldRenderer::makeDynamicValueFields(),
                ])
                ->action(function (array $data) use ($setting): void {
                    $this->settingsService()->updateSetting($setting, $data);
                    $this->fillForm();

                    Notification::make()
                        ->success()
                        ->title('Setting updated')
                        ->body('The setting metadata has been updated.')
                        ->send();
                }),
            Action::make('delete_'.$setting->id)
                ->icon(Heroicon::Trash)
                ->iconButton()
                ->tooltip('Delete setting')
                ->color('danger')
                ->size('sm')
                ->requiresConfirmation()
                ->modalDescription('This setting will be permanently removed from the manager.')
                ->action(function () use ($setting): void {
                    $this->settingsService()->deleteSetting($setting);
                    $this->fillForm();

                    Notification::make()
                        ->success()
                        ->title('Setting deleted')
                        ->body('The setting has been removed.')
                        ->send();

                    $this->redirect(static::getUrl(), navigate: true);
                }),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected function getAddSettingSchema(): array
    {
        return [
            Grid::make([
                'default' => 1,
                'md' => 2,
            ])
                ->schema([
                    Select::make('group')
                        ->required()
                        ->native(false)
                        ->options($this->settingsService()->getManagerGroups())
                        ->default('site'),
                    TextInput::make('key')
                        ->required()
                        ->maxLength(120)
                        ->placeholder('title')
                        ->helperText('Store only the key segment. The selected group becomes the prefix used by setting(group.key), and the key must be globally unique.'),
                ]),
            Grid::make([
                'default' => 1,
                'md' => 3,
            ])
                ->schema([
                    TextInput::make('display_name')
                        ->required()
                        ->maxLength(191)
                        ->placeholder('Site Title'),
                    Select::make('type')
                        ->required()
                        ->native(false)
                        ->options(SettingFieldRenderer::getTypeOptions())
                        ->default('text'),
                    TextInput::make('order')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                ]),
            Toggle::make('is_public')
                ->label('Public setting')
                ->default(false),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    protected function getMetadataSchema(): array
    {
        return [
            Grid::make([
                'default' => 1,
                'md' => 2,
            ])
                ->schema([
                    Select::make('group')
                        ->required()
                        ->native(false)
                        ->options($this->settingsService()->getManagerGroups())
                        ->default('site'),
                    TextInput::make('key')
                        ->required()
                        ->maxLength(120)
                        ->placeholder('title')
                        ->helperText('Store only the key segment. The selected group becomes the prefix used by setting(group.key).'),
                    TextInput::make('display_name')
                        ->required()
                        ->maxLength(191)
                        ->placeholder('Site Title'),
                    Select::make('type')
                        ->required()
                        ->native(false)
                        ->live()
                        ->options(SettingFieldRenderer::getTypeOptions())
                        ->default('text'),
                    Textarea::make('details_json')
                        ->label('Details JSON')
                        ->rows(6)
                        ->placeholder('{"help":"Shown below field","options":{"cod":"Cash on Delivery"}}')
                        ->columnSpanFull(),
                    TextInput::make('order')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                    Toggle::make('is_public')
                        ->label('Public setting')
                        ->default(false),
                ]),
        ];
    }

    protected function fillForm(): void
    {
        $this->form->fill($this->settingsService()->getPageState());
    }

    protected function getSaveAction(): Action
    {
        return Action::make('save')
            ->label('Save All Settings')
            ->icon(Heroicon::CheckCircle)
            ->iconPosition(IconPosition::After)
            ->color('primary')
            ->size('lg')
            ->extraAttributes([
                'class' => 'mt-2 rounded-xl px-6 font-semibold shadow-md shadow-orange-500/20 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/25',
                'style' => 'margin-top: 8px; border-radius: 12px; box-shadow: 0 10px 24px -14px rgba(234, 88, 12, 0.65);',
            ])
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    /**
     * @return array<string, int>
     */
    public function getOverviewStats(): array
    {
        $groupedSettings = $this->settingsService()->getGroupedSettings();

        return [
            'total' => $groupedSettings->sum(fn ($settings): int => $settings->count()),
            'public' => $groupedSettings->sum(fn ($settings): int => $settings->where('is_public', true)->count()),
            'groups' => $groupedSettings->filter(fn ($settings): bool => $settings->isNotEmpty())->count(),
        ];
    }

    protected function settingsService(): SettingManagerService
    {
        return app(SettingManagerService::class);
    }

    protected function renderMetaContent(Setting $setting): Htmlable
    {
        return new HtmlString(
            '<div class="space-y-2">'
            .'<div class="flex items-center">'
            .'<div class="text-sm font-semibold text-gray-950 dark:text-gray-100">'.e($setting->display_name).'</div>'
            .'</div>'
            .'</div>'
        );
    }

    protected function resolveGroupIcon(string $group): string
    {
        return match ($group) {
            'site' => 'heroicon-o-globe-alt',
            'admin' => 'heroicon-o-shield-check',
            'seo' => 'heroicon-o-magnifying-glass',
            'social' => 'heroicon-o-users',
            'payment' => 'heroicon-o-credit-card',
            'mail' => 'heroicon-o-envelope',
            'appearance' => 'heroicon-o-swatch',
            default => 'heroicon-o-cog-6-tooth',
        };
    }
}

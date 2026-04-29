<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => '#865749',
                'warning' => '#C0876A',
                'success' => '#A76048',
                'gray' => '#958377',
            ])
            ->renderHook(
                'panels::head.start',
                fn () => <<<'HTML'
        <style>
            /* Hide scrollbar visually but keep scrolling functional */
            .fi-sidebar-nav {
                overflow-y: auto !important;
                scrollbar-width: none !important; /* Firefox */
                -ms-overflow-style: none !important; /* IE/Edge */
            }

            .fi-sidebar-nav::-webkit-scrollbar {
                display: none !important; /* Chrome/Safari */
            }
            .fi-sidebar-nav-group {
                font-weight: bold;
                color: #4F46E5; /* Example: Indigo */
                background: #F3F4F6;
                border-radius: 6px;
                margin-bottom: 8px;
                padding: 4px 8px;
            }
            .fi-sidebar-nav-group-label {
                font-size: 1.1em;
                letter-spacing: 0.5px;
            }
        </style>
    HTML
            )
            ->sidebarCollapsibleOnDesktop(true)
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Administration')
                    ->icon('heroicon-o-shield-check'),
                NavigationGroup::make()
                    ->label('Catalog Management')
                    ->icon('heroicon-o-squares-2x2'),
                NavigationGroup::make()
                    ->label('Content Management')
                    ->icon('heroicon-o-document-text'),
                NavigationGroup::make()
                    ->label('System Management')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            // ->sidebarWidth('14rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

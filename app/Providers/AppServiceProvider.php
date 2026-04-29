<?php

namespace App\Providers;

use App\Listeners\MergeGuestCartAfterLogin;
use App\Models\Setting;
use App\Observers\SettingObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $helpersPath = app_path('Support/helpers.php');

        if (file_exists($helpersPath)) {
            require_once $helpersPath;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, MergeGuestCartAfterLogin::class);

        Setting::observe(SettingObserver::class);
    }
}

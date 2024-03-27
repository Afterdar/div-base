<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Health\Facades\Health;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Health::checks([
            \Spatie\Health\Checks\Checks\DebugModeCheck::new(),
            \Spatie\Health\Checks\Checks\EnvironmentCheck::new(),
            \Spatie\Health\Checks\Checks\OptimizedAppCheck::new(),
            \Spatie\Health\Checks\Checks\CacheCheck::new(),
            \Spatie\Health\Checks\Checks\DatabaseSizeCheck::new(),
            \Spatie\Health\Checks\Checks\DatabaseCheck::new(),
            \Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck::new(),
            \Spatie\Health\Checks\Checks\FlareErrorOccurrenceCountCheck::new(),
        ]);
    }
}

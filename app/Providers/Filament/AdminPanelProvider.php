<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Backups;
use App\Filament\Pages\HealthCheckResults;
use Awcodes\Curator\CuratorPlugin;
use Awcodes\FilamentStickyHeader\StickyHeaderPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use FilipFonal\FilamentLogManager\FilamentLogManager;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use RickDBCN\FilamentEmail\FilamentEmail;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;

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
                'primary' => Color::Neutral,
            ])
            ->plugins([
                StickyHeaderPlugin::make()
                    ->floating(),
                FilamentShieldPlugin::make(),
                EnvironmentIndicatorPlugin::make()
                    ->color(fn() => match (app()->environment()) {
                        'prod' => Color::Emerald,
                        'local' => Color::Orange,
                    }),
                new FilamentEmail(),
                FilamentLogManager::make(),
                FilamentSpatieLaravelHealthPlugin::make()->usingPage(HealthCheckResults::class),
                FilamentSpatieLaravelBackupPlugin::make()
                    ->usingPage(Backups::class),
                CuratorPlugin::make()
                    ->label('Файлы')
                    ->pluralLabel('Файлы')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup('Система')
                    ->navigationCountBadge()
                    ->resource(\App\Filament\Resources\MediaResource::class),

            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

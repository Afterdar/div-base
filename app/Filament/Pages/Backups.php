<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackups;

class Backups extends BaseBackups
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    public static function getNavigationGroup(): ?string
    {
        return 'Система';
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Trang chủ Dashboard';

    public function getColumns(): int | string | array
    {
        return 3;
    }
}

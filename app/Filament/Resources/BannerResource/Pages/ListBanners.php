<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListBanners extends ListRecords
{
    protected static string $resource = BannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Đăng Banner quảng cáo mới')
                ->color('success')
                ->icon('heroicon-m-photo'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả Banner')
                ->badge(\App\Models\Banner::count())
                ->badgeColor('gray'),

            'active' => Tab::make('✔ Đang hiển thị')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
                ->badge(\App\Models\Banner::where('is_active', true)->count())
                ->badgeColor('success'),

            'inactive' => Tab::make('❌ Đang tạm ẩn')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false))
                ->badge(\App\Models\Banner::where('is_active', false)->count())
                ->badgeColor('danger'),
        ];
    }
}

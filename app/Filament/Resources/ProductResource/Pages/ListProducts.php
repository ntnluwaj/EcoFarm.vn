<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Thêm sản phẩm vật tư mới')
                ->color('success')
                ->icon('heroicon-m-plus-circle'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả sản phẩm')
                ->badge(\App\Models\Product::count())
                ->badgeColor('gray'),

            'pesticide' => Tab::make('Thuốc BVTV')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('category', fn($q) => $q->where('name', 'like', '%Thuốc%')))
                ->badge(\App\Models\Product::whereHas('category', fn($q) => $q->where('name', 'like', '%Thuốc%'))->count())
                ->badgeColor('info'),

            'fertilizer' => Tab::make('Phân Bón NPK & Hữu Cơ')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('category', fn($q) => $q->where('name', 'like', '%Phân%')))
                ->badge(\App\Models\Product::whereHas('category', fn($q) => $q->where('name', 'like', '%Phân%'))->count())
                ->badgeColor('warning'),

            'seeds' => Tab::make('Hạt Giống Lúa')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('category', fn($q) => $q->where('name', 'like', '%Hạt%')))
                ->badge(\App\Models\Product::whereHas('category', fn($q) => $q->where('name', 'like', '%Hạt%'))->count())
                ->badgeColor('success'),

            'low_stock' => Tab::make('🔥 Cảnh báo sắp hết (≤10)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('stock', '<=', 10))
                ->badge(\App\Models\Product::where('stock', '<=', 10)->count())
                ->badgeColor('danger'),
        ];
    }
}

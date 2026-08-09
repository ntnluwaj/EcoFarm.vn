<?php

namespace App\Filament\Resources\StockResource\Pages;

use App\Filament\Resources\StockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStocks extends ListRecords
{
    protected static string $resource = StockResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả vật tư')
                ->badge(\App\Models\Product::count())
                ->badgeColor('gray'),

            'safe' => Tab::make('✔ Tồn kho an toàn (>10)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('stock', '>', 10))
                ->badge(\App\Models\Product::where('stock', '>', 10)->count())
                ->badgeColor('success'),

            'low' => Tab::make('🔥 Sắp hết hàng (≤10)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('stock', '>', 0)->where('stock', '<=', 10))
                ->badge(\App\Models\Product::where('stock', '>', 0)->where('stock', '<=', 10)->count())
                ->badgeColor('warning'),

            'out_of_stock' => Tab::make('❌ Đã hết hàng (0)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('stock', 0))
                ->badge(\App\Models\Product::where('stock', 0)->count())
                ->badgeColor('danger'),
        ];
    }
}

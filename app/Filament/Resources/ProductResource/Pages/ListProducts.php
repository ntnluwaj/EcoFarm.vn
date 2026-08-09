<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
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
                ->label('Tạo mới Sản phẩm')
                ->icon('heroicon-o-plus')
                ->color('success'),
        ];
    }

    /**
     * 🌟 DÀN NÚT LỌC PIL TAB TƯƠNG TỰ ANH MẪU
     */
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả')
                ->badge(Product::count()),

            'pest' => Tab::make('Thuốc Trừ Sâu & Bệnh')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('category', fn($q) => $q->where('name', 'like', '%sâu%')->orWhere('name', 'like', '%bệnh%')))
                ->badge(Product::whereHas('category', fn($q) => $q->where('name', 'like', '%sâu%')->orWhere('name', 'like', '%bệnh%'))->count()),

            'fertilizer' => Tab::make('Phân bón & Dinh dưỡng')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('category', fn($q) => $q->where('name', 'like', '%phân bón%')->orWhere('name', 'like', '%dinh dưỡng%')))
                ->badge(Product::whereHas('category', fn($q) => $q->where('name', 'like', '%phân bón%')->orWhere('name', 'like', '%dinh dưỡng%'))->count()),

            'high_stock' => Tab::make('Tồn kho dồi dào')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('stock', '>', 50))
                ->badge(Product::where('stock', '>', 50)->count()),

            'low_stock' => Tab::make('Sắp hết hàng')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('stock', '<=', 50))
                ->badge(Product::where('stock', '<=', 50)->count()),
        ];
    }
}

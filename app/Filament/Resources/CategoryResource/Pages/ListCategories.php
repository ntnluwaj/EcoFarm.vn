<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Thêm danh mục phân loại mới')
                ->color('success')
                ->icon('heroicon-m-rectangle-stack'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả danh mục phân loại')
                ->badge(\App\Models\Category::count())
                ->badgeColor('gray'),

            'has_products' => Tab::make('✔ Đang có sản phẩm')
                ->modifyQueryUsing(fn (Builder $query) => $query->has('products'))
                ->badge(\App\Models\Category::has('products')->count())
                ->badgeColor('success'),
        ];
    }
}

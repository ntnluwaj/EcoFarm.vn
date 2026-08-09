<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Thêm thương hiệu / NSX mới')
                ->color('success')
                ->icon('heroicon-m-tag'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả thương hiệu')
                ->badge(\App\Models\Brand::count())
                ->badgeColor('gray'),

            'active_partners' => Tab::make('✔ Đối tác đang phân phối')
                ->modifyQueryUsing(fn (Builder $query) => $query->has('products'))
                ->badge(\App\Models\Brand::has('products')->count())
                ->badgeColor('success'),
        ];
    }
}

<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tạo mới Đơn hàng')
                ->icon('heroicon-o-plus')
                ->color('success'),
        ];
    }

    /**
     * 🌟 DÀN NÚT LỌC PIL TAB CHO ĐƠN HÀNG KHO VẬN
     */
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả đơn')
                ->badge(Order::count()),

            'pending' => Tab::make('Chờ xác nhận')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))
                ->badge(Order::where('status', 'pending')->count()),

            'processing' => Tab::make('Đang bốc xếp')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'processing'))
                ->badge(Order::where('status', 'processing')->count()),

            'shipping' => Tab::make('Xe đang giao')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'shipping'))
                ->badge(Order::where('status', 'shipping')->count()),

            'completed' => Tab::make('Đã hoàn thành')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed'))
                ->badge(Order::where('status', 'completed')->count()),
        ];
    }
}

<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
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
                ->label('+ Tạo phiếu đơn hàng mới')
                ->color('success')
                ->icon('heroicon-m-plus-circle'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả đơn hàng')
                ->badge(\App\Models\Order::count())
                ->badgeColor('gray'),

            'pending' => Tab::make('Chờ duyệt xuất kho')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))
                ->badge(\App\Models\Order::where('status', 'pending')->count())
                ->badgeColor('warning'),

            'processing' => Tab::make('Đang đóng gói')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'processing'))
                ->badge(\App\Models\Order::where('status', 'processing')->count())
                ->badgeColor('info'),

            'shipping' => Tab::make('Đang giao vận tải')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'shipping'))
                ->badge(\App\Models\Order::where('status', 'shipping')->count())
                ->badgeColor('primary'),

            'completed' => Tab::make('Hoàn thành bàn giao')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed'))
                ->badge(\App\Models\Order::where('status', 'completed')->count())
                ->badgeColor('success'),

            'cancelled' => Tab::make('Đã hủy đơn')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'cancelled'))
                ->badge(\App\Models\Order::where('status', 'cancelled')->count())
                ->badgeColor('danger'),
        ];
    }
}

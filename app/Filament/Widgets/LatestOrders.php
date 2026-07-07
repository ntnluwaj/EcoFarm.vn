<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Filament\Resources\OrderResource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 4;
    
    protected static ?string $heading = 'Đơn hàng mới nhận gần đây';
    
    protected int | string | array $columnSpan = 'full';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Order::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('id')
                    ->label('Mã đơn')
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->label('Khách hàng')
                    ->wrap(),
                TextColumn::make('customer_phone')
                    ->label('Số điện thoại'),
                TextColumn::make('total_amount')
                    ->label('Tổng tiền')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' VND'),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'primary' => 'shipping',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Chờ duyệt',
                        'processing' => 'Đang đóng gói',
                        'shipping' => 'Đang giao',
                        'completed' => 'Hoàn tất',
                        'cancelled' => 'Đã hủy',
                        default => $state,
                    })
                    ->label('Trạng thái'),
                TextColumn::make('created_at')
                    ->dateTime('H:i d/m/Y')
                    ->label('Thời gian'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Chi tiết')
                    ->url(fn (Order $record): string => OrderResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-m-eye')
                    ->color('success'),
               ]);
    }
}

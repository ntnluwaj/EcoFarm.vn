<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Filament\Resources\OrderResource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    public static function canView(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'staff']);
    }

    protected static ?int $sort = 4;
    
    protected static ?string $heading = 'Đơn hàng mới nhận gần đây';
    
    protected int | string | array $columnSpan = 2;

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Order::query()->latest()->limit(5)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('id')
                    ->label('MÃ ĐƠN')
                    ->weight('bold')
                    ->formatStateUsing(fn ($state) => '#ECF' . str_pad($state, 6, '0', STR_PAD_LEFT)),

                TextColumn::make('customer_name')
                    ->label('KHÁCH HÀNG & SĐT')
                    ->weight('bold')
                    ->description(fn (Order $record) => $record->customer_phone),

                TextColumn::make('total_amount')
                    ->label('TỔNG TIỀN')
                    ->money('VND')
                    ->weight('extrabold')
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('status')
                    ->label('TRẠNG THÁI')
                    ->html()
                    ->state(function (Order $record): string {
                        return match ($record->status) {
                            'pending' => '<span style="background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3; border-radius: 9999px; padding: 3px 10px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #ef4444; display: inline-block;"></span>Chờ duyệt</span>',
                            'processing' => '<span style="background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; border-radius: 9999px; padding: 3px 10px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>Đang đóng gói</span>',
                            'shipping' => '<span style="background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 9999px; padding: 3px 10px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #3b82f6; display: inline-block;"></span>Đang giao</span>',
                            'completed' => '<span style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; border-radius: 9999px; padding: 3px 10px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>Hoàn tất</span>',
                            default => '<span style="background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; border-radius: 9999px; padding: 3px 10px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;">Đã hủy</span>',
                        };
                    }),

                TextColumn::make('created_at')
                    ->dateTime('H:i d/m/Y')
                    ->label('THỜI GIAN'),
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

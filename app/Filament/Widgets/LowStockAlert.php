<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Filament\Resources\StockResource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockAlert extends BaseWidget
{
    public static function canView(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'staff']);
    }

    protected static ?int $sort = 7;
    
    protected static ?string $heading = 'Cảnh báo tồn kho sắp hết (Tồn <= 10)';
    
    protected int | string | array $columnSpan = 1;

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('stock', '<=', 10)
                    ->orWhereHas('variants', fn ($q) => $q->where('stock', '<=', 10))
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->label('TÊN VẬT TƯ')
                    ->weight('bold')
                    ->description(fn (Product $record) => 'Quy cách: ' . $record->packaging),

                TextColumn::make('category.name')
                    ->label('NGÀNH HÀNG')
                    ->badge()
                    ->color('success'),

                TextColumn::make('stock_status')
                    ->label('TỒN KHO GỐC')
                    ->html()
                    ->state(function (Product $record): string {
                        if ($record->stock <= 0) {
                            return '<span style="background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3; border-radius: 9999px; padding: 2px 8px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #ef4444; display: inline-block;"></span>Hết hàng (0)</span>';
                        } else {
                            return '<span style="background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; border-radius: 9999px; padding: 2px 8px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>Còn ' . $record->stock . ' ' . $record->unit . '</span>';
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('adjust')
                    ->label('Nhập hàng')
                    ->url(fn (Product $record): string => StockResource::getUrl('index'))
                    ->icon('heroicon-m-plus-circle')
                    ->color('warning'),
            ]);
    }
}

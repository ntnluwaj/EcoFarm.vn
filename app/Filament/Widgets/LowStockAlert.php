<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Filament\Resources\StockResource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockAlert extends BaseWidget
{
    protected static ?int $sort = 5;
    
    protected static ?string $heading = 'Cảnh báo tồn kho sắp hết (Tồn <= 10)';
    
    protected int | string | array $columnSpan = 'full';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('stock', '<=', 10)
                    ->orWhereHas('variants', fn ($q) => $q->where('stock', '<=', 10))
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Tên vật tư')
                    ->wrap(),
                TextColumn::make('category.name')
                    ->label('Ngành hàng'),
                TextColumn::make('stock')
                    ->label('Tồn kho gốc')
                    ->alignCenter(),
                TextColumn::make('variants_stock')
                    ->label('Chi tiết biến thể')
                    ->state(function (Product $record) {
                        if ($record->variants->count() > 0) {
                            return $record->variants->map(fn($v) => "{$v->capacity}: {$v->stock}")->join(' | ');
                        }
                        return 'Không có biến thể';
                    })
                    ->wrap(),
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

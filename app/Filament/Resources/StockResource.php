<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class StockResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Quản lý kho bãi';

    protected static ?string $modelLabel = 'kho bãi';

    protected static ?string $pluralModelLabel = 'Quản lý kho bãi';

    protected static ?string $navigationGroup = 'Vận hành & Kho bãi';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->label('Tên vật tư'),
                TextColumn::make('category.name')
                    ->label('Ngành hàng'),
                TextColumn::make('packaging')
                    ->label('Quy cách'),
                TextColumn::make('stock')
                    ->label('Số lượng tồn')
                    ->html()
                    ->state(function (Product $record) {
                        if ($record->variants()->count() > 0) {
                            $html = '<div style="display: flex; flex-direction: column; gap: 4px; padding: 4px 0;">';
                            foreach ($record->variants as $v) {
                                $colorClass = $v->stock <= 0 ? 'color: #dc2626; font-weight: bold;' : ($v->stock <= 10 ? 'color: #d97706; font-weight: bold;' : 'color: #16a34a; font-weight: bold;');
                                $html .= "<div><span style=\"font-size: 12px; color: #4b5563;\">{$v->capacity}:</span> <span style=\"{$colorClass} font-size: 13px;\">{$v->stock}</span></div>";
                            }
                            $html .= '</div>';
                            return $html;
                        }
                        
                        $colorClass = $record->stock <= 0 ? 'color: #dc2626; font-weight: bold;' : ($record->stock <= 10 ? 'color: #d97706; font-weight: bold;' : 'color: #16a34a; font-weight: bold;');
                        return "<span style=\"{$colorClass} font-size: 13px;\">{$record->stock}</span>";
                    }),
                TextColumn::make('unit')
                    ->label('Đơn vị'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Lọc theo ngành hàng'),
                Tables\Filters\Filter::make('low_stock')
                    ->label('Tồn kho sắp hết (<= 10)')
                    ->query(fn ($query) => $query->where(function ($q) {
                        $q->where('stock', '<=', 10)
                          ->orWhereHas('variants', fn ($qv) => $qv->where('stock', '<=', 10));
                    })),
            ])
            ->actions([
                Action::make('adjust')
                    ->label('Điều chỉnh kho')
                    ->icon('heroicon-m-adjustments-horizontal')
                    ->color('success')
                    ->form(function (Product $record) {
                        $fields = [];
                        
                        if ($record->variants()->count() > 0) {
                            $fields[] = Select::make('product_variant_id')
                                ->label('Chọn dung tích / biến thể')
                                ->options($record->variants->pluck('capacity', 'id'))
                                ->required();
                        }
                        
                        $fields[] = Select::make('type')
                            ->label('Loại điều chỉnh')
                            ->options([
                                'add' => 'Nhập thêm hàng (+)',
                                'subtract' => 'Xuất hao hụt/hỏng (-)',
                                'set' => 'Cập nhật số tồn thực tế (Set)',
                            ])
                            ->required();
                            
                        $fields[] = TextInput::make('quantity')
                            ->label('Số lượng')
                            ->numeric()
                            ->required()
                            ->minValue(0);
                            
                        $fields[] = TextInput::make('reason')
                            ->label('Lý do / Ghi chú')
                            ->placeholder('Ví dụ: Nhập lô hàng mới, Hàng hỏng do ẩm...');
                            
                        return $fields;
                    })
                    ->action(function (Product $record, array $data): void {
                        $qty = (int)$data['quantity'];
                        $type = $data['type'];
                        $variantId = $data['product_variant_id'] ?? null;
                        
                        if ($variantId) {
                            $variant = \App\Models\ProductVariant::find($variantId);
                            if ($variant) {
                                if ($type === 'add') {
                                    $variant->increment('stock', $qty);
                                    $msg = "Đã nhập thêm {$qty} sản phẩm (loại {$variant->capacity}) vào kho.";
                                } elseif ($type === 'subtract') {
                                    $oldStock = $variant->stock;
                                    $subtractQty = min($oldStock, $qty);
                                    $variant->decrement('stock', $subtractQty);
                                    $msg = "Đã xuất giảm {$subtractQty} sản phẩm (loại {$variant->capacity}) khỏi kho.";
                                } else {
                                    $variant->update(['stock' => $qty]);
                                    $msg = "Đã cập nhật tồn kho mới cho loại {$variant->capacity} là {$qty}.";
                                }
                            } else {
                                $msg = "Không tìm thấy biến thể.";
                            }
                        } else {
                            if ($type === 'add') {
                                $record->increment('stock', $qty);
                                $msg = "Đã nhập thêm {$qty} {$record->unit} vào kho.";
                            } elseif ($type === 'subtract') {
                                $oldStock = $record->stock;
                                $subtractQty = min($oldStock, $qty);
                                $record->decrement('stock', $subtractQty);
                                $msg = "Đã xuất giảm {$subtractQty} {$record->unit} khỏi kho.";
                            } else {
                                $record->update(['stock' => $qty]);
                                $msg = "Đã cập nhật tồn kho mới là {$qty} {$record->unit}.";
                            }
                        }

                        Notification::make()
                            ->title('Điều chỉnh kho thành công')
                            ->body($msg)
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Danh sách sản phẩm vật tư đóng gói';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live() // 🌟 Lắng nghe sự thay đổi khi Admin chọn mặt hàng vật tư
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        if (! $state) return;
                        
                        $product = \App\Models\Product::find($state);
                        if (! $product) return;

                        $set('product_variant_id', null); // Reset variant when product changes

                        // Tự động áp giá dựa trên phân loại biểu giá đang chọn hiện tại
                        if ($get('price_type') === 'wholesale') {
                            $set('unit_price', $product->price_wholesale ?: ($product->price * 0.9));
                        } else {
                            $set('unit_price', $product->price);
                        }
                    })
                    ->label('Tên mặt hàng vật tư'),

                Select::make('product_variant_id')
                    ->label('Dung tích / Trọng lượng')
                    ->options(function (Forms\Get $get) {
                        $productId = $get('product_id');
                        if (! $productId) return [];
                        return \App\Models\ProductVariant::where('product_id', $productId)
                            ->pluck('capacity', 'id');
                    })
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if (! $state) return;
                        $variant = \App\Models\ProductVariant::find($state);
                        if ($variant) {
                            $set('unit_price', $variant->price);
                        }
                    })
                    ->placeholder('Chọn dung tích (nếu có)'),

                Select::make('price_type')
                    ->options([
                        'retail' => 'Giá bán lẻ (B2C)',
                        'wholesale' => 'Giá sỉ đại lý (B2B)',
                    ])
                    ->required()
                    ->default('retail')
                    ->live() // 🌟 Tự động tính toán lại đơn giá khi Admin đổi loại biểu giá
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        $productId = $get('product_id');
                        if (! $productId) return;

                        // Nếu có chọn biến thể, dùng giá của biến thể
                        $variantId = $get('product_variant_id');
                        if ($variantId) {
                            $variant = \App\Models\ProductVariant::find($variantId);
                            if ($variant) {
                                $set('unit_price', $variant->price);
                                return;
                            }
                        }

                        $product = \App\Models\Product::find($productId);
                        if (! $product) return;

                        if ($state === 'wholesale') {
                            $set('unit_price', $product->price_wholesale ?: ($product->price * 0.9));
                        } else {
                            $set('unit_price', $product->price);
                        }
                    })
                    ->label('Phân loại biểu giá áp dụng'),

                TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->minValue(1)
                    ->label('Số lượng đặt mua'),

                TextInput::make('unit_price')
                    ->numeric()
                    ->required()
                    ->prefix('VND')
                    ->label('Đơn giá chốt tại thời điểm mua'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('product.name')
                    ->state(function ($record) {
                        $name = $record->product ? $record->product->name : '';
                        if ($record->productVariant) {
                            $name .= ' (' . $record->productVariant->capacity . ')';
                        }
                        return $name;
                    })
                    ->wrap()
                    ->label('Tên sản phẩm vật tư'),

                TextColumn::make('product.unit')
                    ->label('ĐVT'),

                TextColumn::make('quantity')
                    ->alignCenter()
                    ->label('Số lượng'),

                TextColumn::make('unit_price')
                    ->money('VND')
                    ->label('Đơn giá chốt'),

                TextColumn::make('price_type')
                    ->badge()
                    ->colors([
                        'primary' => 'retail',
                        'success' => 'wholesale',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'retail' => 'Giá lẻ',
                        'wholesale' => 'Giá sỉ',
                        default => $state,
                    })
                    ->label('Loại giá áp'),

                // Tính toán thành tiền tự động hiển thị ra bảng chi tiết (AC-01)
                TextColumn::make('subtotal')
                    ->state(function ($record): float {
                        return $record->quantity * $record->unit_price;
                    })
                    ->money('VND')
                    ->label('Thành tiền'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Thêm vật tư vào đơn'),
            ])
            ->actions([
                EditAction::make()
                    ->label('Sửa'),
                DeleteAction::make()
                    ->label('Xóa'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Xóa loạt lựa chọn'),
                ]),
            ]);
    }
}
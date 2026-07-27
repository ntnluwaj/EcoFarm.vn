<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Filament\Resources\VoucherResource\RelationManagers;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Quản lý bán hàng';
    protected static ?string $navigationLabel = 'Mã giảm giá (Vouchers)';
    protected static ?string $pluralLabel = 'Mã giảm giá';
    protected static ?string $modelLabel = 'Mã giảm giá';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Mã giảm giá')
                    ->placeholder('Ví dụ: ECF10')
                    ->maxLength(50),
                Forms\Components\Select::make('type')
                    ->options([
                        'percent' => 'Phần trăm (%)',
                        'fixed' => 'Số tiền cố định (đ)',
                    ])
                    ->required()
                    ->label('Loại giảm giá'),
                Forms\Components\TextInput::make('value')
                    ->numeric()
                    ->required()
                    ->label('Giá trị giảm')
                    ->placeholder('Ví dụ: 10 hoặc 50000'),
                Forms\Components\TextInput::make('min_order_amount')
                    ->numeric()
                    ->default(0)
                    ->label('Đơn hàng tối thiểu')
                    ->placeholder('Ví dụ: 100000'),
                Forms\Components\TextInput::make('max_uses')
                    ->numeric()
                    ->default(100)
                    ->required()
                    ->label('Lượt sử dụng tối đa'),
                Forms\Components\TextInput::make('uses')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->label('Số lượt đã dùng'),
                Forms\Components\DateTimePicker::make('expires_at')
                    ->label('Ngày hết hạn'),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->nullable()
                    ->placeholder('Áp dụng toàn đơn hàng')
                    ->label('Sản phẩm giới hạn áp dụng'),
                Forms\Components\TextInput::make('points_cost')
                    ->numeric()
                    ->nullable()
                    ->label('Điểm tích lũy để đổi')
                    ->placeholder('Bỏ trống nếu không cho phép đổi bằng điểm'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('Kích hoạt')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->label('Mã code')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn ($state) => $state === 'percent' ? 'Phần trăm (%)' : 'Số tiền cố định')
                    ->label('Loại giảm'),
                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(fn ($state, $record) => $record->type === 'percent' ? $state . '%' : number_format($state, 0, ',', '.') . 'đ')
                    ->label('Trị giá giảm'),
                Tables\Columns\TextColumn::make('min_order_amount')
                    ->money('VND')
                    ->label('Đơn tối thiểu'),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Sản phẩm áp dụng')
                    ->placeholder('Toàn bộ đơn hàng')
                    ->wrap(),
                Tables\Columns\TextColumn::make('points_cost')
                    ->label('Điểm đổi')
                    ->placeholder('Không hỗ trợ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('uses')
                    ->label('Đã dùng')
                    ->formatStateUsing(fn ($state, $record) => $state . ' / ' . $record->max_uses),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Hạn dùng'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Trạng thái'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVouchers::route('/'),
        ];
    }
}

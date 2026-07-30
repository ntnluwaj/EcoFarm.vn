<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GiftResource\Pages;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GiftResource extends Resource
{
    protected static ?string $model = Voucher::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'Khách hàng & Tư vấn';
    protected static ?string $navigationLabel = 'Kho quà tặng (Đổi điểm)';
    protected static ?string $pluralLabel = 'Kho quà tặng';
    protected static ?string $modelLabel = 'Mã quà tặng';
    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        // Chỉ lấy các mã giảm giá được thiết lập làm quà tặng đổi điểm (points_cost > 0)
        // và chưa thuộc sở hữu của bất kỳ khách hàng cá nhân nào (user_id is null)
        return parent::getEloquentQuery()
            ->whereNotNull('points_cost')
            ->whereNull('user_id');
    }

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'staff']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Mã quà tặng')
                    ->placeholder('Ví dụ: GIFT-100K')
                    ->maxLength(50),
                Forms\Components\Select::make('type')
                    ->options([
                        'percent' => 'Phần trăm (%)',
                        'fixed' => 'Số tiền cố định (đ)',
                    ])
                    ->required()
                    ->label('Loại quà tặng'),
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
                Forms\Components\TextInput::make('points_cost')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->label('Số điểm cần để đổi')
                    ->placeholder('Ví dụ: 100'),
                Forms\Components\TextInput::make('max_uses')
                    ->numeric()
                    ->default(100)
                    ->required()
                    ->label('Số lượng phát ra tối đa'),
                Forms\Components\TextInput::make('uses')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->label('Số lượt đã được đổi'),
                Forms\Components\DateTimePicker::make('expires_at')
                    ->label('Hạn đổi quà'),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->nullable()
                    ->placeholder('Áp dụng toàn đơn hàng')
                    ->label('Sản phẩm giới hạn áp dụng'),
                Forms\Components\Toggle::make('is_active')
                    ->default(fn () => auth()->user()?->role === 'admin')
                    ->disabled(fn () => auth()->user()?->role !== 'admin')
                    ->dehydrated(true)
                    ->label('Kích hoạt phát quà (Chỉ Admin phê duyệt)')
                    ->helperText(fn () => auth()->user()?->role !== 'admin' ? 'Quà tặng mới do nhân viên tạo sẽ mặc định ở trạng thái Chờ duyệt.' : null)
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
                    ->label('Mã quà')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Hạn đổi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(fn ($state, $record) => $record->type === 'percent' ? $state . '%' : number_format($state, 0, ',', '.') . 'đ')
                    ->label('Trị giá giảm'),
                Tables\Columns\TextColumn::make('min_order_amount')
                    ->money('VND')
                    ->label('Đơn tối thiểu'),
                Tables\Columns\TextColumn::make('points_cost')
                    ->label('Điểm đổi')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),
                Tables\Columns\TextColumn::make('uses')
                    ->label('Đã đổi / Tổng số')
                    ->formatStateUsing(fn ($state, $record) => $state . ' / ' . $record->max_uses),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Đang phát'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->label('Thao tác')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('success')
                ->button(),
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
            'index' => Pages\ManageGifts::route('/'),
        ];
    }
}

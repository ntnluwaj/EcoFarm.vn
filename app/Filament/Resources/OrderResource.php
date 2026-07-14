<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $navigationLabel = 'Quản lý Đơn hàng';

    protected static ?string $navigationGroup = 'Vận hành & Kho bãi';

    protected static ?int $navigationSort = 1;
    
    protected static ?string $modelLabel = 'Đơn hàng';
    
    protected static ?string $pluralModelLabel = 'Danh sách Đơn hàng';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin giao nhận hàng vật tư')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('customer_name')
                                ->required()
                                ->label('Họ tên người nhận thực tế'),

                            TextInput::make('customer_phone')
                                ->required()
                                ->tel()
                                ->label('Số điện thoại liên hệ'),
                        ]),

                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Mặc định: Khách mua vãng lai')
                            ->label('Tài khoản thành viên liên kết'),

                        Textarea::make('shipping_address')
                            ->required()
                            ->rows(2)
                            ->label('Địa chỉ chi tiết nhận hàng'),
                    ])->columnSpan(2),

                Section::make('Trạng thái & Tiến độ xử lý tài chính')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'pending' => 'Chờ xác nhận',
                                'processing' => 'Đang xử lý / Đóng gói',
                                'shipping' => 'Đang giao hàng',
                                'completed' => 'Hoàn tất đơn hàng',
                                'cancelled' => 'Đã hủy đơn hệ thống',
                            ])
                            ->required()
                            ->reactive()
                            ->label('Trạng thái vận đơn (Timeline)'),

                        Textarea::make('cancel_reason')
                            ->required(fn ($get) => $get('status') === 'cancelled')
                            ->placeholder('Bắt buộc ghi rõ lý do hủy: Khách đổi ý, hết hàng tồn kho...')
                            ->visible(fn ($get) => $get('status') === 'cancelled')
                            ->label('Lý do hủy đơn hàng'),

                        TextInput::make('total_amount')
                            ->numeric()
                            ->required()
                            ->prefix('VND')
                            ->default(0)
                            ->label('Tổng dòng tiền hóa đơn cuối'),

                        Grid::make(2)->schema([
                            Select::make('payment_method')
                                ->options([
                                    'COD' => 'Tiền mặt tại nhà (COD)',
                                    'VNPay' => 'Cổng điện tử VNPay',
                                    'VietQR' => 'Chuyển khoản VietQR',
                                ])
                                ->required()
                                ->label('Giải pháp thanh toán'),

                            Select::make('payment_status')
                                ->options([
                                    'unpaid' => 'Chưa thanh toán',
                                    'paid' => 'Đã thanh toán thành công',
                                    'refunded' => 'Đã hoàn tiền',
                                ])
                                ->required()
                                ->label('Tình trạng dòng tiền'),
                        ]),

                        TextInput::make('payment_transaction_id')
                            ->placeholder('Nhập mã giao dịch ngân hàng nếu có')
                            ->label('Mã giao dịch điện tử'),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('Mã đơn'),
                TextColumn::make('customer_name')->searchable()->wrap()->label('Người nhận'),
                TextColumn::make('customer_phone')->searchable()->label('Số điện thoại'),
                
                TextColumn::make('total_amount')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' VND')
                    ->sortable()
                    ->label('Tổng tiền'),
                TextColumn::make('payment_method')->label('Hình thức'),
                TextColumn::make('payment_status')
                    ->badge()
                    ->colors([
                        'danger' => 'unpaid',
                        'success' => 'paid',
                        'warning' => 'refunded',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unpaid' => 'Chưa trả',
                        'paid' => 'Đã trả',
                        'refunded' => 'Hoàn tiền',
                        default => $state,
                    })
                    ->label('Thanh toán'),

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
                    ->label('Trạng thái vận đơn'),

                TextColumn::make('created_at')->dateTime('H:i d/m/Y')->sortable()->label('Thời gian chốt đơn'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Đơn chờ xác nhận',
                        'processing' => 'Đơn đang đóng gói',
                        'shipping' => 'Đơn đang giao',
                        'completed' => 'Đơn hoàn tất',
                        'cancelled' => 'Đơn đã hủy',
                    ])
                    ->label('Lọc theo tiến trình vận đơn'),
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('print')
                    ->label('In phiếu')
                    ->icon('heroicon-m-printer')
                    ->color('success')
                    ->url(fn (Order $record): string => route('admin.orders.print', ['id' => $record->id]))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Gọi đường dẫn tuyệt đối chính xác để triệt tiêu lỗi ComponentNotFoundException
            \App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
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

    protected static ?string $recordTitleAttribute = 'customer_name';

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'staff']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('THÔNG TIN GIAO NHẬN VẬT TƯ KHO BÃI')
                    ->description('Quản lý thông tin nhà vườn, số điện thoại liên hệ và địa chỉ giao hàng thực tế')
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

                        TextInput::make('coupon_code')
                            ->disabled()
                            ->label('Mã giảm giá đã dùng'),

                        TextInput::make('discount_amount')
                            ->numeric()
                            ->prefix('VND')
                            ->disabled()
                            ->label('Số tiền chiết khấu'),

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
                TextColumn::make('id')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => '#ECF' . str_pad($state, 5, '0', STR_PAD_LEFT))
                    ->weight('black')
                    ->label('Mã đơn'),

                TextColumn::make('customer_name')
                    ->label('Khách hàng & SĐT')
                    ->searchable(['customer_name', 'customer_phone'])
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Order $record): string => $record->customer_phone ?? 'Chưa có SĐT')
                    ->wrap(),

                TextColumn::make('total_amount')
                    ->label('Tổng tiền & Thanh toán')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' VND')
                    ->sortable()
                    ->weight('black')
                    ->color('success')
                    ->description(fn (Order $record): string => match ($record->payment_status) {
                        'paid' => '✔ Đã trả (' . strtoupper($record->payment_method ?? 'COD') . ')',
                        'refunded' => '↺ Hoàn tiền',
                        default => '⏳ Chưa trả (' . strtoupper($record->payment_method ?? 'COD') . ')',
                    }),

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

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->label('Thời gian đặt'),

                TextColumn::make('cod_reconciled')
                    ->badge()
                    ->state(fn (Order $record): string => $record->payment_method !== 'COD' ? 'N/A' : ($record->cod_reconciled ? 'reconciled' : 'pending'))
                    ->colors([
                        'success' => 'reconciled',
                        'warning' => 'pending',
                        'gray' => 'N/A',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'reconciled' => 'Đã đối soát',
                        'pending' => 'Chờ đối soát',
                        'N/A' => 'Không có (VietQR)',
                        default => $state,
                    })
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Đối soát COD'),
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
                \Filament\Tables\Filters\Filter::make('pending_cod')
                    ->label('Chờ đối soát COD')
                    ->query(fn ($query) => $query->where('payment_method', 'COD')->where('cod_reconciled', false)),
                \Filament\Tables\Filters\Filter::make('reconciled_cod')
                    ->label('Đã đối soát COD')
                    ->query(fn ($query) => $query->where('payment_method', 'COD')->where('cod_reconciled', true)),
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    \Filament\Tables\Actions\Action::make('print')
                        ->label('In phiếu')
                        ->icon('heroicon-m-printer')
                        ->color('success')
                        ->url(fn (Order $record): string => route('admin.orders.print', ['id' => $record->id]))
                        ->openUrlInNewTab(),
                    EditAction::make(),
                ])
                ->label('Thao tác')
                ->icon('heroicon-m-ellipsis-horizontal')
                ->color('gray')
                ->button(),
            ])
            ->headerActions([
                \Filament\Tables\Actions\Action::make('export_csv')
                    ->label('Xuất báo cáo Excel (CSV)')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $records = Order::orderBy('id', 'desc')->get();
                        
                        $headers = [
                            'Content-Type' => 'text/csv; charset=UTF-8',
                            'Content-Disposition' => 'attachment; filename="Bao_cao_don_hang_' . date('Ymd_His') . '.csv"',
                        ];

                        $callback = function () use ($records) {
                            $file = fopen('php://output', 'w');
                            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                            
                            fputcsv($file, [
                                'Mã đơn hàng',
                                'Ngày đặt hàng',
                                'Họ tên khách hàng',
                                'Số điện thoại',
                                'Email nhận hóa đơn',
                                'Địa chỉ giao hàng',
                                'Tổng tiền thanh toán (VND)',
                                'Mã giảm giá',
                                'Số tiền giảm giá (VND)',
                                'Phương thức thanh toán',
                                'Trạng thái thanh toán',
                                'Trạng thái đơn hàng'
                            ]);

                            foreach ($records as $r) {
                                fputcsv($file, [
                                    '="' . 'ECF' . str_pad($r->id, 6, '0', STR_PAD_LEFT) . '"',
                                    '="' . ($r->created_at ? $r->created_at->format('H:i d/m/Y') : '') . '"',
                                    $r->customer_name,
                                    '="' . $r->customer_phone . '"',
                                    $r->customer_email,
                                    $r->shipping_address,
                                    $r->total_amount,
                                    '="' . ($r->coupon_code ?? '') . '"',
                                    $r->discount_amount,
                                    strtoupper($r->payment_method ?? ''),
                                    $r->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán',
                                    match($r->status) {
                                        'pending' => 'Chờ duyệt',
                                        'processing' => 'Đang gói',
                                        'shipping' => 'Đang giao',
                                        'completed' => 'Hoàn tất',
                                        'cancelled' => 'Đã hủy',
                                        default => $r->status
                                    }
                                ]);
                            }
                            fclose($file);
                        };

                        return response()->stream($callback, 200, $headers);
                    }),

                \Filament\Tables\Actions\Action::make('print_report')
                    ->label('In báo cáo Doanh thu (PDF)')
                    ->icon('heroicon-m-printer')
                    ->color('primary')
                    ->url(fn (): string => route('admin.reports.print'))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    \Filament\Tables\Actions\BulkAction::make('reconcile_cod')
                        ->label('Xác nhận đối soát COD')
                        ->icon('heroicon-m-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->payment_method === 'COD' && $record->status === 'completed' && !$record->cod_reconciled) {
                                    $record->update(['cod_reconciled' => true]);
                                    $count++;
                                }
                            }
                            if ($count > 0) {
                                \Filament\Notifications\Notification::make()
                                    ->title("Đối soát thành công!")
                                    ->body("Đã xác nhận đối soát hoàn tất cho {$count} đơn hàng COD.")
                                    ->success()
                                    ->send();
                            } else {
                                \Filament\Notifications\Notification::make()
                                    ->title("Không có đơn hàng nào hợp lệ!")
                                    ->body("Chỉ các đơn hàng COD đã hoàn tất ('completed') và chưa đối soát mới có thể chọn đối soát.")
                                    ->warning()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    \Filament\Tables\Actions\BulkAction::make('export_selected_csv')
                        ->label('Xuất đơn hàng đã chọn (CSV)')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->color('success')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $headers = [
                                'Content-Type' => 'text/csv; charset=UTF-8',
                                'Content-Disposition' => 'attachment; filename="Bao_cao_don_hang_chon_' . date('Ymd_His') . '.csv"',
                            ];

                            $callback = function () use ($records) {
                                $file = fopen('php://output', 'w');
                                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                                
                                fputcsv($file, [
                                    'Mã đơn hàng',
                                    'Ngày đặt hàng',
                                    'Họ tên khách hàng',
                                    'Số điện thoại',
                                    'Email nhận hóa đơn',
                                    'Địa chỉ giao hàng',
                                    'Tổng tiền thanh toán (VND)',
                                    'Mã giảm giá',
                                    'Số tiền giảm giá (VND)',
                                    'Phương thức thanh toán',
                                    'Trạng thái thanh toán',
                                    'Trạng thái đơn hàng'
                                ]);

                                foreach ($records as $r) {
                                    fputcsv($file, [
                                        '="' . 'ECF' . str_pad($r->id, 6, '0', STR_PAD_LEFT) . '"',
                                        '="' . ($r->created_at ? $r->created_at->format('H:i d/m/Y') : '') . '"',
                                        $r->customer_name,
                                        '="' . $r->customer_phone . '"',
                                        $r->customer_email,
                                        $r->shipping_address,
                                        $r->total_amount,
                                        '="' . ($r->coupon_code ?? '') . '"',
                                        $r->discount_amount,
                                        strtoupper($r->payment_method ?? ''),
                                        $r->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán',
                                        match($r->status) {
                                            'pending' => 'Chờ duyệt',
                                            'processing' => 'Đang gói',
                                            'shipping' => 'Đang giao',
                                            'completed' => 'Hoàn tất',
                                            'cancelled' => 'Đã hủy',
                                            default => $r->status
                                        }
                                    ]);
                                }
                                fclose($file);
                            };

                            return response()->stream($callback, 200, $headers);
                        }),
                    \Filament\Tables\Actions\BulkAction::make('bulk_processing')
                        ->label('Duyệt & Đóng gói hàng loạt')
                        ->icon('heroicon-m-cog-6-tooth')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'pending') {
                                    $record->update(['status' => 'processing']);
                                    $count++;
                                }
                            }
                            \Filament\Notifications\Notification::make()
                                ->title("Đã duyệt & bắt đầu đóng gói hàng loạt {$count} đơn hàng thành công!")
                                ->success()
                                ->send();
                        }),

                    \Filament\Tables\Actions\BulkAction::make('bulk_completed')
                        ->label('Hoàn tất đơn hàng loạt')
                        ->icon('heroicon-m-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if (in_array($record->status, ['processing', 'shipping'])) {
                                    $record->update([
                                        'status' => 'completed',
                                        'payment_status' => 'paid',
                                    ]);
                                    $count++;
                                }
                            }
                            \Filament\Notifications\Notification::make()
                                ->title("Đã xác nhận hoàn tất hàng loạt {$count} đơn hàng thành công!")
                                ->success()
                                ->send();
                        }),

                    \Filament\Tables\Actions\BulkAction::make('bulk_cancelled')
                        ->label('Hủy đơn hàng loạt')
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if (in_array($record->status, ['pending', 'processing'])) {
                                    $record->update(['status' => 'cancelled']);
                                    $count++;
                                }
                            }
                            \Filament\Notifications\Notification::make()
                                ->title("Đã hủy hàng loạt {$count} đơn hàng thành công!")
                                ->warning()
                                ->send();
                        }),
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

    public static function getGlobalSearchResultTitle(\Illuminate\Database\Eloquent\Model $record): string
    {
        return 'ECF' . str_pad($record->id, 6, '0', STR_PAD_LEFT) . ' - ' . $record->customer_name;
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
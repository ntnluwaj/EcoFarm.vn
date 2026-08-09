<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'Tài khoản';

    protected static ?string $navigationGroup = 'Khách hàng & Tư vấn';

    protected static ?int $navigationSort = 1;
    
    protected static ?string $modelLabel = 'Tài khoản';
    
    protected static ?string $pluralModelLabel = 'Danh sách Tài khoản';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'staff']);
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('THÔNG TIN TÀI KHOẢN NÔNG DÂN')
                    ->description('Nhập thông tin định danh cá nhân, email và phân quyền sử dụng hệ thống EcoFarm')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(3)->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('Ví dụ: Nguyễn Văn A')
                                ->label('Họ và tên người dùng *'),

                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(100)
                                ->placeholder('nguyenvana@gmail.com')
                                ->unique(ignoreRecord: true)
                                ->label('Địa chỉ Email (Đăng nhập) *'),

                            TextInput::make('phone')
                                ->tel()
                                ->nullable()
                                ->placeholder('09xx xxx xxx')
                                ->maxLength(15)
                                ->label('Số điện thoại liên hệ'),
                        ]),

                        \Filament\Forms\Components\Grid::make(3)->schema([
                            TextInput::make('password')
                                ->password()
                                ->dehydrated(fn ($state) => filled($state))
                                ->required(fn (string $context): bool => $context === 'create')
                                ->maxLength(255)
                                ->placeholder('••••••••')
                                ->label('Mật khẩu đăng nhập *'),

                            Select::make('role')
                                ->options([
                                    'customer' => 'Khách mua lẻ / Nông dân',
                                    'staff' => 'Nhân viên bán hàng',
                                    'engineer' => 'Kỹ sư nông nghiệp',
                                    'admin' => 'Quản trị viên',
                                ])
                                ->required()
                                ->label('Phân quyền tài khoản *'),

                            TextInput::make('reward_points')
                                ->numeric()
                                ->default(0)
                                ->suffix('Điểm')
                                ->label('Điểm tích lũy thành viên'),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Họ và tên'),
                TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),
                TextColumn::make('phone')
                    ->label('Số điện thoại'),
                TextColumn::make('reward_points')
                    ->sortable()
                    ->label('Điểm tích lũy'),
                TextColumn::make('role')
                    ->badge()
                    ->colors([
                        'success' => 'customer',
                        'warning' => 'agency',
                        'info' => 'staff',
                        'danger' => 'admin',
                        'primary' => 'engineer',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Quản trị viên',
                        'staff' => 'Nhân viên',
                        'customer' => 'Khách mua lẻ',
                        'engineer' => 'Kỹ sư nông nghiệp',
                        default => $state,
                    })
                    ->label('Vai trò hệ thống'),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'customer' => 'Khách lẻ',
                        'staff' => 'Nhân viên',
                        'engineer' => 'Kỹ sư nông nghiệp',
                        'admin' => 'Quản trị viên',
                    ])
                    ->label('Lọc theo vai trò'),
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    \Filament\Tables\Actions\EditAction::make(),
                    \Filament\Tables\Actions\DeleteAction::make(),
                ])
                ->label('Thao tác')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('success')
                ->button(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
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
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->label('Họ và tên người dùng'),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->label('Địa chỉ Email (Tài khoản đăng nhập)'),

                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255)
                    ->label('Mật khẩu đăng nhập'),

                TextInput::make('phone')
                    ->tel()
                    ->nullable()
                    ->maxLength(15)
                    ->label('Số điện thoại liên hệ'),

                Select::make('role')
                    ->options([
                        'customer' => 'Khách mua lẻ / Nông dân',
                        'staff' => 'Nhân viên bán hàng',
                        'engineer' => 'Kỹ sư nông nghiệp',
                        'admin' => 'Quản trị viên',
                    ])
                    ->required()
                    ->label('Phân quyền tài khoản hệ thống'),

                TextInput::make('reward_points')
                    ->numeric()
                    ->default(0)
                    ->label('Điểm tích lũy'),
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
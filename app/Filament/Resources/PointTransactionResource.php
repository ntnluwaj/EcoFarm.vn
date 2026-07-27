<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PointTransactionResource\Pages;
use App\Models\PointTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class PointTransactionResource extends Resource
{
    protected static ?string $model = PointTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationLabel = 'Nhật ký điểm thưởng';

    protected static ?string $pluralLabel = 'Nhật ký điểm thưởng';

    protected static ?string $modelLabel = 'Giao dịch điểm';

    protected static ?string $navigationGroup = 'Khách hàng & Tư vấn';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->label('Khách hàng'),
                Forms\Components\TextInput::make('points')
                    ->disabled()
                    ->label('Số điểm thay đổi'),
                Forms\Components\TextInput::make('transaction_type')
                    ->disabled()
                    ->label('Loại giao dịch'),
                Forms\Components\Textarea::make('description')
                    ->disabled()
                    ->label('Mô tả chi tiết'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Tài khoản')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('points')
                    ->label('Điểm thay đổi')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => ($state > 0 ? '+' : '') . $state)
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                    ->weight('bold'),
                TextColumn::make('transaction_type')
                    ->badge()
                    ->colors([
                        'success' => 'earn',
                        'warning' => 'redeem',
                        'danger' => 'refund',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'earn' => 'Tích lũy',
                        'redeem' => 'Đổi quà',
                        'refund' => 'Khấu trừ',
                        default => $state
                    })
                    ->label('Loại giao dịch'),
                TextColumn::make('description')
                    ->label('Mô tả chi tiết')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Thời gian')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('transaction_type')
                    ->options([
                        'earn' => 'Tích lũy',
                        'redeem' => 'Đổi quà',
                        'refund' => 'Khấu trừ',
                    ])
                    ->label('Lọc theo loại'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListPointTransactions::route('/'),
        ];
    }
}

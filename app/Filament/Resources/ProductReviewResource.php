<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductReviewResource\Pages;
use App\Models\ProductReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ProductReviewResource extends Resource
{
    protected static ?string $model = ProductReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Đánh giá từ khách';

    protected static ?string $navigationGroup = 'Danh mục & Sản phẩm';
    
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label('Sản phẩm vật tư')
                    ->disabled()
                    ->required(),
                Forms\Components\TextInput::make('reviewer_name')
                    ->label('Họ tên người đánh giá')
                    ->disabled(),
                Forms\Components\Select::make('rating')
                    ->options([
                        1 => '1 sao',
                        2 => '2 sao',
                        3 => '3 sao',
                        4 => '4 sao',
                        5 => '5 sao',
                    ])
                    ->label('Đánh giá')
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->label('Nội dung nhận xét')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label('Vật tư')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reviewer_name')
                    ->label('Người đánh giá')
                    ->searchable(),
                TextColumn::make('rating')
                    ->label('Số sao')
                    ->state(fn ($record) => str_repeat('⭐', $record->rating))
                    ->sortable(),
                TextColumn::make('comment')
                    ->label('Nhận xét')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Thời gian gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
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

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProductReviews::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductQuestionResource\Pages;
use App\Models\ProductQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ProductQuestionResource extends Resource
{
    protected static ?string $model = ProductQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'Hỏi đáp kỹ thuật';

    protected static ?string $navigationGroup = 'Danh mục & Sản phẩm';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label('Sản phẩm vật tư')
                    ->disabled()
                    ->required(),
                Forms\Components\TextInput::make('asker_name')
                    ->label('Họ tên nông dân hỏi')
                    ->disabled(),
                Forms\Components\Textarea::make('question')
                    ->label('Câu hỏi kỹ thuật đặt ra')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('answer')
                    ->label('Câu trả lời của Kỹ sư Nông học')
                    ->placeholder('Nhập chi tiết liều lượng bón tưới, lưu ý an toàn cho bà con nông dân...')
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
                TextColumn::make('asker_name')
                    ->label('Người hỏi')
                    ->searchable(),
                TextColumn::make('question')
                    ->label('Câu hỏi')
                    ->limit(40)
                    ->wrap(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->state(fn ($record) => !empty($record->answer) ? '✅ Đã giải đáp' : '⏳ Chờ trả lời')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '✅ Đã giải đáp' => 'success',
                        '⏳ Chờ trả lời' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Gửi lúc')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('unanswered')
                    ->label('Chưa giải đáp')
                    ->query(fn (\Illuminate\Database\Eloquent\Builder $query) => $query->whereNull('answer')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Trả lời'),
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
            'index' => Pages\ManageProductQuestions::route('/'),
        ];
    }
}

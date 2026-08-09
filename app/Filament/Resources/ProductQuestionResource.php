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

    protected static ?string $modelLabel = 'Hỏi đáp kỹ thuật';

    protected static ?string $pluralLabel = 'Danh sách Hỏi đáp kỹ thuật';

    protected static ?string $navigationGroup = 'Danh mục & Sản phẩm';

    protected static ?int $navigationSort = 4;

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'engineer']);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('THÔNG TIN HỎI ĐÁP SẢN PHẨM VẬT TƯ')
                    ->description('Xem chi tiết thắc mắc từ nhà vườn và trả lời tư vấn kỹ thuật từ Kỹ sư')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Select::make('product_id')
                                ->relationship('product', 'name')
                                ->label('Sản phẩm vật tư liên quan')
                                ->disabled(),

                            Forms\Components\TextInput::make('asker_name')
                                ->label('Họ tên nhà vườn đặt câu hỏi')
                                ->disabled(),
                        ]),

                        Forms\Components\Textarea::make('question')
                            ->label('Nội dung thắc mắc kỹ thuật của nhà vườn')
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('answer')
                            ->label('Câu trả lời giải đáp của Kỹ sư Nông học *')
                            ->placeholder('Nhập chi tiết liều lượng bón tưới, lưu ý an toàn cho nhà vườn tại đây...')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
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
                Tables\Actions\Action::make('answer')
                    ->label('Trả lời kỹ thuật')
                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                    ->color('success')
                    ->form([
                        Forms\Components\Textarea::make('answer')
                            ->label('Nội dung phản hồi giải đáp của Kỹ sư Nông học *')
                            ->placeholder('Nhập chi tiết liều lượng bón tưới, lưu ý an toàn...')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function (ProductQuestion $record, array $data): void {
                        $record->update(['answer' => $data['answer']]);
                        \Filament\Notifications\Notification::make()
                            ->title('Đã gửi câu trả lời kỹ thuật thành công!')
                            ->success()
                            ->send();
                    })
                    ->fillForm(fn (ProductQuestion $record): array => [
                        'answer' => $record->answer,
                    ]),

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
            'index' => Pages\ManageProductQuestions::route('/'),
        ];
    }
}

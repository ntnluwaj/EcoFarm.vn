<?php

namespace App\Filament\Widgets;

use App\Models\ProductQuestion;
use App\Filament\Resources\ProductQuestionResource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestProductQuestions extends BaseWidget
{
    public static function canView(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'engineer']);
    }

    protected static ?int $sort = 8;

    protected static ?string $heading = 'Câu hỏi sản phẩm mới nhận';

    protected int | string | array $columnSpan = 1;

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                ProductQuestion::query()->latest()->limit(5)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('asker_name')
                    ->label('Người hỏi')
                    ->wrap(),
                TextColumn::make('product.name')
                    ->label('Vật tư')
                    ->wrap(),
                TextColumn::make('answer')
                    ->badge()
                    ->state(fn (ProductQuestion $record) => $record->answer ? 'replied' : 'pending')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'replied',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Chờ trả lời',
                        'replied' => 'Đã trả lời',
                        default => $state,
                    })
                    ->label('Trạng thái'),
            ])
            ->actions([
                Tables\Actions\Action::make('reply')
                    ->label('Trả lời')
                    ->url(fn (): string => ProductQuestionResource::getUrl('index'))
                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                    ->color('success'),
            ]);
    }
}

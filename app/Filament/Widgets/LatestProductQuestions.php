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
                    ->label('NGƯỜI HỎI')
                    ->weight('bold'),

                TextColumn::make('product.name')
                    ->label('VẬT TƯ NÔNG NGHIỆP')
                    ->wrap(),

                TextColumn::make('answer')
                    ->label('TRẠNG THÁI')
                    ->html()
                    ->state(function (ProductQuestion $record): string {
                        return match ((bool) $record->answer) {
                            true => '<span style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; border-radius: 9999px; padding: 2px 8px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>Đã trả lời</span>',
                            false => '<span style="background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; border-radius: 9999px; padding: 2px 8px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>Chờ trả lời</span>',
                        };
                    }),
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

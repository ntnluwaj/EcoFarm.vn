<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Filament\Resources\ContactResource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestConsultations extends BaseWidget
{
    public static function canView(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'engineer']);
    }

    protected static ?int $sort = 6;

    protected static ?string $heading = 'Yêu cầu tư vấn mới nhận gần đây';

    protected int | string | array $columnSpan = 2;

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Contact::query()->latest()->limit(5)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->weight('bold'),

                TextColumn::make('name')
                    ->label('HỌ TÊN & SĐT')
                    ->weight('bold')
                    ->description(fn (Contact $record) => $record->phone),

                TextColumn::make('subject')
                    ->label('VẤN ĐỀ CẦN TƯ VẤN')
                    ->wrap(),

                TextColumn::make('status')
                    ->label('TRẠNG THÁI')
                    ->html()
                    ->state(function (Contact $record): string {
                        return match ($record->status) {
                            'replied' => '<span style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; border-radius: 9999px; padding: 3px 10px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>Đã phản hồi</span>',
                            default => '<span style="background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; border-radius: 9999px; padding: 3px 10px; font-weight: 600; font-size: 11px; display: inline-flex; align-items: center; gap: 5px; white-space: nowrap;"><span style="width: 6px; height: 6px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>Chờ phản hồi</span>',
                        };
                    }),

                TextColumn::make('created_at')
                    ->dateTime('H:i d/m/Y')
                    ->label('THỜI GIAN'),
            ])
            ->actions([
                Tables\Actions\Action::make('reply')
                    ->label('Phản hồi')
                    ->url(fn (Contact $record): string => ContactResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success'),
            ]);
    }
}

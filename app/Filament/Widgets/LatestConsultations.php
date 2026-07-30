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
        return in_array(auth()->user()?->role, ['admin', 'staff', 'engineer']);
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
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Họ tên')
                    ->wrap(),
                TextColumn::make('phone')
                    ->label('Số điện thoại'),
                TextColumn::make('subject')
                    ->label('Chủ đề')
                    ->wrap(),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'replied',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Chờ phản hồi',
                        'replied' => 'Đã phản hồi',
                        default => $state,
                    })
                    ->label('Trạng thái'),
                TextColumn::make('created_at')
                    ->dateTime('H:i d/m/Y')
                    ->label('Thời gian'),
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

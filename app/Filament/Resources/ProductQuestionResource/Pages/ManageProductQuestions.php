<?php

namespace App\Filament\Resources\ProductQuestionResource\Pages;

use App\Filament\Resources\ProductQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ManageProductQuestions extends ManageRecords
{
    protected static string $resource = ProductQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Thêm câu hỏi giải đáp mới')
                ->color('success')
                ->icon('heroicon-m-question-mark-circle'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả câu hỏi sản phẩm')
                ->badge(\App\Models\ProductQuestion::count())
                ->badgeColor('gray'),

            'pending' => Tab::make('🔥 Chờ kỹ sư giải đáp')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('answer'))
                ->badge(\App\Models\ProductQuestion::whereNull('answer')->count())
                ->badgeColor('warning'),

            'answered' => Tab::make('✔ Đã trả lời kỹ thuật')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('answer'))
                ->badge(\App\Models\ProductQuestion::whereNotNull('answer')->count())
                ->badgeColor('success'),
        ];
    }
}

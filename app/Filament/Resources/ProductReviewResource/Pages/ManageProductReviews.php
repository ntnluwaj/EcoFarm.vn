<?php

namespace App\Filament\Resources\ProductReviewResource\Pages;

use App\Filament\Resources\ProductReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ManageProductReviews extends ManageRecords
{
    protected static string $resource = ProductReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả đánh giá')
                ->badge(\App\Models\ProductReview::count())
                ->badgeColor('gray'),

            'five_star' => Tab::make('⭐ 5 Sao (Rất hài lòng)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('rating', 5))
                ->badge(\App\Models\ProductReview::where('rating', 5)->count())
                ->badgeColor('success'),

            'four_star' => Tab::make('👍 4 Sao (Tốt)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('rating', 4))
                ->badge(\App\Models\ProductReview::where('rating', 4)->count())
                ->badgeColor('info'),

            'low_rating' => Tab::make('⚠️ 1-3 Sao (Cần lưu ý)')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('rating', '<=', 3))
                ->badge(\App\Models\ProductReview::where('rating', '<=', 3)->count())
                ->badgeColor('warning'),
        ];
    }
}

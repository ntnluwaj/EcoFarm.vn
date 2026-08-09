<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả yêu cầu tư vấn')
                ->badge(\App\Models\Contact::count())
                ->badgeColor('gray'),

            'pending' => Tab::make('🔥 Chờ kỹ sư phản hồi')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))
                ->badge(\App\Models\Contact::where('status', 'pending')->count())
                ->badgeColor('warning'),

            'replied' => Tab::make('✔ Đã phản hồi kỹ thuật')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'replied'))
                ->badge(\App\Models\Contact::where('status', 'replied')->count())
                ->badgeColor('success'),
        ];
    }
}

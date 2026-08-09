<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Viết bài cẩm nang mới')
                ->color('success')
                ->icon('heroicon-m-document-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả bài viết')
                ->badge(\App\Models\Post::count())
                ->badgeColor('gray'),

            'published' => Tab::make('✔ Đã xuất bản')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('published_at'))
                ->badge(\App\Models\Post::whereNotNull('published_at')->count())
                ->badgeColor('success'),

            'draft' => Tab::make('📝 Bản nháp (Chờ duyệt)')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('published_at'))
                ->badge(\App\Models\Post::whereNull('published_at')->count())
                ->badgeColor('warning'),

            'farming_tech' => Tab::make('Kỹ thuật canh tác')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'Kỹ thuật canh tác'))
                ->badge(\App\Models\Post::where('category', 'Kỹ thuật canh tác')->count())
                ->badgeColor('info'),

            'pest_control' => Tab::make('Quản lý sâu bệnh hại')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'Quản lý sâu bệnh hại'))
                ->badge(\App\Models\Post::where('category', 'Quản lý sâu bệnh hại')->count())
                ->badgeColor('primary'),
        ];
    }
}

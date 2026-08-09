<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Tạo tài khoản người dùng mới')
                ->color('success')
                ->icon('heroicon-m-user-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả tài khoản')
                ->badge(\App\Models\User::count())
                ->badgeColor('gray'),

            'customer' => Tab::make('Bà con Nông dân')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'customer'))
                ->badge(\App\Models\User::where('role', 'customer')->count())
                ->badgeColor('success'),

            'engineer' => Tab::make('Kỹ sư Nông nghiệp')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'engineer'))
                ->badge(\App\Models\User::where('role', 'engineer')->count())
                ->badgeColor('primary'),

            'staff' => Tab::make('Nhân viên bán hàng')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'staff'))
                ->badge(\App\Models\User::where('role', 'staff')->count())
                ->badgeColor('info'),

            'admin' => Tab::make('Quản trị viên')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'admin'))
                ->badge(\App\Models\User::where('role', 'admin')->count())
                ->badgeColor('danger'),
        ];
    }
}

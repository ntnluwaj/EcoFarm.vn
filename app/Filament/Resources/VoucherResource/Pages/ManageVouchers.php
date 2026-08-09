<?php

namespace App\Filament\Resources\VoucherResource\Pages;

use App\Filament\Resources\VoucherResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ManageVouchers extends ManageRecords
{
    protected static string $resource = VoucherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Tạo mã ưu đãi khuyến mãi mới')
                ->color('success')
                ->icon('heroicon-m-ticket'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tất cả mã khuyến mãi')
                ->badge(\App\Models\Voucher::count())
                ->badgeColor('gray'),

            'active' => Tab::make('✔ Đang hiệu lực')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true)->where('end_date', '>=', Carbon::now()))
                ->badge(\App\Models\Voucher::where('is_active', true)->where('end_date', '>=', Carbon::now())->count())
                ->badgeColor('success'),

            'expired' => Tab::make('❌ Đã hết hạn / Khóa')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false)->orWhere('end_date', '<', Carbon::now()))
                ->badge(\App\Models\Voucher::where('is_active', false)->orWhere('end_date', '<', Carbon::now())->count())
                ->badgeColor('danger'),
        ];
    }
}

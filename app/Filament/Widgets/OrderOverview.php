<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    // Cài đặt thời gian tự động làm mới số liệu (sau mỗi 10 giây)
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        // 1. Tính tổng doanh thu thực tế từ các đơn hoàn thành
        $revenue = Order::where('status', 'completed')->sum('total_amount');

        // 2. Đếm số lượng đơn hàng đang chờ bốc xếp công tác
        $pendingOrders = Order::where('status', 'pending')->count();

        // 3. Thống kê số lượng khách hàng/nhà vườn đăng ký hệ thống
        $customerCount = User::where('role', 'customer')->count();

        return [
            Stat::make('Doanh thu hệ thống', number_format($revenue, 0, ',', '.') . ' VND')
                ->description('Tổng tiền từ đơn hàng hoàn tất')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->color('success'),

            Stat::make('Đơn hàng chờ duyệt', $pendingOrders . ' đơn')
                ->description('Cần bốc xếp & đóng gói gấp')
                ->descriptionIcon('heroicon-m-clock', IconPosition::Before)
                ->color($pendingOrders > 0 ? 'warning' : 'gray'),

            Stat::make('Nhà vườn đăng ký', $customerCount . ' thành viên')
                ->description('Hệ thống khách mua lẻ')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->color('info'),
        ];
    }
}
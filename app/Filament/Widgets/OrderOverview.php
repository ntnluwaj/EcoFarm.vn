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

    public static function canView(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'staff']);
    }

    protected function getStats(): array
    {
        $role = auth()->user()?->role;
        $stats = [];

        // 1. Doanh thu hệ thống - Chỉ dành cho admin
        if ($role === 'admin') {
            $revenue = Order::where('status', 'completed')->sum('total_amount');
            $stats[] = Stat::make('Doanh thu hệ thống', number_format($revenue, 0, ',', '.') . ' VND')
                ->description('Tổng tiền từ đơn hàng hoàn tất')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->color('success');
        }

        // 2. Đơn hàng chờ duyệt - Admin và Staff đều xem được
        if (in_array($role, ['admin', 'staff'])) {
            $pendingOrders = Order::where('status', 'pending')->count();
            $stats[] = Stat::make('Đơn hàng chờ duyệt', $pendingOrders . ' đơn')
                ->description('Cần bốc xếp & đóng gói gấp')
                ->descriptionIcon('heroicon-m-clock', IconPosition::Before)
                ->color($pendingOrders > 0 ? 'warning' : 'gray');
        }

        // 3. Nhà vườn đăng ký - Chỉ dành cho admin
        if ($role === 'admin') {
            $customerCount = User::where('role', 'customer')->count();
            $stats[] = Stat::make('Nhà vườn đăng ký', $customerCount . ' thành viên')
                ->description('Hệ thống khách mua lẻ')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->color('info');
        }

        return $stats;
    }
}
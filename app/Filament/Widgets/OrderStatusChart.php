<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    public static function canView(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'staff']);
    }

    public ?string $filter = 'all';

    protected function getFilters(): ?array
    {
        return [
            'all' => 'Tất cả thời gian',
            'today' => 'Hôm nay',
            'week' => '7 ngày qua',
            'month' => '30 ngày qua',
            'year' => 'Năm nay',
        ];
    }

    public function getHeading(): ?string
    {
        $filters = $this->getFilters();
        $activeFilter = $this->filter;
        
        return 'Tỷ lệ trạng thái đơn hàng (' . ($filters[$activeFilter] ?? 'Tất cả') . ')';
    }
    
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $query = Order::query();

        if ($activeFilter === 'today') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($activeFilter === 'week') {
            $query->where('created_at', '>=', now()->subDays(7)->startOfDay());
        } elseif ($activeFilter === 'month') {
            $query->where('created_at', '>=', now()->subDays(30)->startOfDay());
        } elseif ($activeFilter === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        $pending = (clone $query)->where('status', 'pending')->count();
        $processing = (clone $query)->where('status', 'processing')->count();
        $shipping = (clone $query)->where('status', 'shipping')->count();
        $completed = (clone $query)->where('status', 'completed')->count();
        $cancelled = (clone $query)->where('status', 'cancelled')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Số lượng đơn',
                    'data' => [$pending, $processing, $shipping, $completed, $cancelled],
                    'backgroundColor' => [
                        '#eab308', // warning yellow
                        '#06b6d4', // info cyan
                        '#3b82f6', // primary blue
                        '#22c55e', // success green
                        '#ef4444', // danger red
                    ],
                ],
            ],
            'labels' => ['Chờ duyệt', 'Đóng gói', 'Đang giao', 'Hoàn tất', 'Đã hủy'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

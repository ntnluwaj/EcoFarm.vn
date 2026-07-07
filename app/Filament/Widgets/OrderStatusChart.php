<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Tỷ lệ trạng thái đơn hàng';
    
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $pending = Order::where('status', 'pending')->count();
        $processing = Order::where('status', 'processing')->count();
        $shipping = Order::where('status', 'shipping')->count();
        $completed = Order::where('status', 'completed')->count();
        $cancelled = Order::where('status', 'cancelled')->count();

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

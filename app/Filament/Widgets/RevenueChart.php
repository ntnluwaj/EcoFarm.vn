<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Biểu đồ doanh thu hoàn tất (6 tháng qua)';
    
    protected static string $color = 'success';
    
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = 'Tháng ' . $month->format('m/Y');
            
            $revenue = Order::where('status', 'completed')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_amount');
                
            $data[] = (float)$revenue;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Doanh thu (VND)',
                    'data' => $data,
                    'backgroundColor' => 'rgba(46, 125, 50, 0.1)',
                    'borderColor' => '#2e7d32',
                    'borderWidth' => 3,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public ?string $filter = '6months';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hôm nay',
            'week' => '7 ngày qua',
            'month' => '30 ngày qua',
            '6months' => '6 tháng qua',
            'year' => 'Năm nay',
        ];
    }

    public function getHeading(): ?string
    {
        $filters = $this->getFilters();
        $activeFilter = $this->filter;
        
        return 'Biểu đồ doanh thu hoàn tất (' . ($filters[$activeFilter] ?? '6 tháng qua') . ')';
    }
    
    protected static string $color = 'success';
    
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $data = [];
        $labels = [];
        
        if ($activeFilter === 'today') {
            for ($hour = 0; $hour <= 23; $hour += 3) {
                $start = now()->startOfDay()->addHours($hour);
                $end = now()->startOfDay()->addHours($hour + 3);
                $labels[] = $start->format('H:i') . ' - ' . $end->format('H:i');
                
                $revenue = Order::where('status', 'completed')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('total_amount');
                $data[] = (float)$revenue;
            }
        } elseif ($activeFilter === 'week') {
            for ($i = 6; $i >= 0; $i--) {
                $day = now()->subDays($i);
                $labels[] = $day->format('d/m');
                
                $revenue = Order::where('status', 'completed')
                    ->whereDate('created_at', $day->toDateString())
                    ->sum('total_amount');
                $data[] = (float)$revenue;
            }
        } elseif ($activeFilter === 'month') {
            for ($i = 5; $i >= 0; $i--) {
                $start = now()->subDays(($i + 1) * 5)->startOfDay();
                $end = now()->subDays($i * 5)->endOfDay();
                $labels[] = $start->format('d/m') . ' - ' . $end->format('d/m');
                
                $revenue = Order::where('status', 'completed')
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('total_amount');
                $data[] = (float)$revenue;
            }
        } elseif ($activeFilter === 'year') {
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = 'Tháng ' . $i;
                $revenue = Order::where('status', 'completed')
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', now()->year)
                    ->sum('total_amount');
                $data[] = (float)$revenue;
            }
        } else {
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $labels[] = 'Tháng ' . $month->format('m/Y');
                
                $revenue = Order::where('status', 'completed')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->sum('total_amount');
                $data[] = (float)$revenue;
            }
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

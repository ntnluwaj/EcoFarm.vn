<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class CategorySalesChart extends ChartWidget
{
    protected static ?string $heading = 'Tỷ lệ doanh số theo Ngành hàng';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 1;

    public static function canView(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    protected function getData(): array
    {
        $sales = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(order_items.quantity * order_items.unit_price) as total_sales'))
            ->groupBy('categories.name')
            ->get();

        $labels = $sales->pluck('category_name')->toArray();
        $data = $sales->pluck('total_sales')->map(fn($v) => (float)$v)->toArray();

        if (empty($data)) {
            $labels = ['Chưa có doanh số'];
            $data = [0];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Doanh thu (VND)',
                    'data' => $data,
                    'backgroundColor' => [
                        '#10b981', // emerald
                        '#3b82f6', // blue
                        '#f59e0b', // amber
                        '#ef4444', // red
                        '#8b5cf6', // purple
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}

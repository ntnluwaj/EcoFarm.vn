<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Carbon;

class StockReportPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Báo cáo bãi kho';

    protected static ?string $title = 'Báo cáo doanh thu & bãi kho nội bộ';

    protected static bool $shouldRegisterNavigation = false; // Bỏ hiển thị khỏi Sidebar theo yêu cầu

    protected static string $view = 'filament.pages.stock-report';

    public $startDate;
    public $endDate;

    public static function canAccess(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'staff', 'engineer']);
    }

    public function mount()
    {
        $this->startDate = request()->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $this->endDate = request()->input('end_date', Carbon::now()->format('Y-m-d'));
    }

    public function getViewData(): array
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $revenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_amount');

        $totalOrdersCount = Order::whereBetween('created_at', [$start, $end])->count();
        $completedOrdersCount = Order::where('status', 'completed')->whereBetween('created_at', [$start, $end])->count();
        $pendingOrdersCount = Order::where('status', 'pending')->whereBetween('created_at', [$start, $end])->count();
        $processingOrdersCount = Order::where('status', 'processing')->whereBetween('created_at', [$start, $end])->count();
        $shippingOrdersCount = Order::where('status', 'shipping')->whereBetween('created_at', [$start, $end])->count();
        $cancelledOrdersCount = Order::where('status', 'cancelled')->whereBetween('created_at', [$start, $end])->count();

        $avgOrderValue = $completedOrdersCount > 0 ? ($revenue / $completedOrdersCount) : 0;

        $paymentMethodStats = Order::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('payment_method, count(*) as count, sum(total_amount) as total')
            ->groupBy('payment_method')
            ->get();

        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$start, $end])
            ->selectRaw('products.id, products.name, products.unit, products.packaging, sum(order_items.quantity) as total_qty, sum(order_items.quantity * order_items.unit_price) as total_revenue')
            ->groupBy('products.id', 'products.name', 'products.unit', 'products.packaging')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        $recentOrders = Order::with('user')
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 10)
            ->orWhereHas('variants', fn($q) => $q->where('stock', '<=', 10))
            ->take(5)
            ->get();

        return [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'revenue' => $revenue,
            'totalOrdersCount' => $totalOrdersCount,
            'completedOrdersCount' => $completedOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'processingOrdersCount' => $processingOrdersCount,
            'shippingOrdersCount' => $shippingOrdersCount,
            'cancelledOrdersCount' => $cancelledOrdersCount,
            'avgOrderValue' => $avgOrderValue,
            'paymentMethodStats' => $paymentMethodStats,
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
        ];
    }
}

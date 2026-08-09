<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Trang chủ Dashboard';

    protected static string $view = 'filament.pages.dashboard';

    protected function getViewData(): array
    {
        $revenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrdersCount = Order::count();
        $completedOrdersCount = Order::where('status', 'completed')->count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $processingOrdersCount = Order::where('status', 'processing')->count();
        $shippingOrdersCount = Order::where('status', 'shipping')->count();
        $cancelledOrdersCount = Order::where('status', 'cancelled')->count();
        $avgOrderValue = $completedOrdersCount > 0 ? ($revenue / $completedOrdersCount) : 0;

        $customerCount = User::where('role', 'customer')->count();
        $pendingCodAmount = Order::where('payment_method', 'COD')
            ->where('status', 'completed')
            ->where('cod_reconciled', false)
            ->sum('total_amount');

        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'completed')
            ->selectRaw('products.id, products.name, products.unit, products.packaging, sum(order_items.quantity) as total_qty, sum(order_items.quantity * order_items.unit_price) as total_revenue')
            ->groupBy('products.id', 'products.name', 'products.unit', 'products.packaging')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        $recentOrders = Order::with('user')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return [
            'revenue' => $revenue,
            'totalOrdersCount' => $totalOrdersCount,
            'completedOrdersCount' => $completedOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'processingOrdersCount' => $processingOrdersCount,
            'shippingOrdersCount' => $shippingOrdersCount,
            'cancelledOrdersCount' => $cancelledOrdersCount,
            'avgOrderValue' => $avgOrderValue,
            'customerCount' => $customerCount,
            'pendingCodAmount' => $pendingCodAmount,
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders,
        ];
    }
}

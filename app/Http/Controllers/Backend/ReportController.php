<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    /**
     * Báo cáo doanh thu tổng hợp nội bộ bãi kho của Admin (PRD - UC-09)
     */
    public function index(Request $request)
    {
        // 1. Phân tích tham số bộ lọc thời gian (mặc định 30 ngày qua)
        $startDateInput = $request->input('start_date');
        $endDateInput = $request->input('end_date');

        if ($startDateInput) {
            $startDate = Carbon::parse($startDateInput)->startOfDay();
        } else {
            $startDate = Carbon::now()->subDays(30)->startOfDay();
        }

        if ($endDateInput) {
            $endDate = Carbon::parse($endDateInput)->endOfDay();
        } else {
            $endDate = Carbon::now()->endOfDay();
        }

        // 2. Truy vấn số liệu tổng quan (chỉ tính đơn hoàn tất cho doanh thu thực tế)
        $revenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalOrdersCount = Order::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $completedOrdersCount = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $pendingOrdersCount = Order::where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $processingOrdersCount = Order::where('status', 'processing')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $shippingOrdersCount = Order::where('status', 'shipping')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $cancelledOrdersCount = Order::where('status', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $avgOrderValue = $completedOrdersCount > 0 ? ($revenue / $completedOrdersCount) : 0;

        // 3. Phân cơ cấu doanh thu (Bản chỉ bán lẻ B2C)
        $b2bRevenue = 0;
        $b2cRevenue = $revenue;

        // 4. Phân tích phương thức thanh toán
        $paymentMethodStats = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('payment_method, count(*) as count, sum(total_amount) as total')
            ->groupBy('payment_method')
            ->get();

        // 5. Thống kê Top 5 sản phẩm bán chạy nhất đầu vụ
        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('products.id, products.name, products.unit, products.packaging, sum(order_items.quantity) as total_qty, sum(order_items.quantity * order_items.unit_price) as total_revenue')
            ->groupBy('products.id', 'products.name', 'products.unit', 'products.packaging')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        // 6. Lịch sử 10 đơn hàng mới nhất để đối soát trực tiếp
        $recentOrders = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        return view('backend.reports.index', compact(
            'startDate',
            'endDate',
            'revenue',
            'totalOrdersCount',
            'completedOrdersCount',
            'pendingOrdersCount',
            'processingOrdersCount',
            'shippingOrdersCount',
            'cancelledOrdersCount',
            'avgOrderValue',
            'b2bRevenue',
            'b2cRevenue',
            'paymentMethodStats',
            'topProducts',
            'recentOrders'
        ));
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Post;
use App\Models\Contact;
use Illuminate\Support\Carbon;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Trang chủ Dashboard';

    protected static string $view = 'filament.pages.dashboard';

    public function getViewData(): array
    {
        // 1. Thống kê 4 thẻ KPI hàng đầu
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $usersCount = User::count();

        // 2. Thống kê tháng hiện tại
        $currentMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');

        $currentMonthSales = Order::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // 3. Cơ cấu B2C vs B2B & Giá trị trung bình đơn
        $b2cRevenue = Order::where('status', 'completed')
            ->whereHas('user', fn($q) => $q->where('role', 'customer'))
            ->sum('total_amount');

        $b2bRevenue = Order::where('status', 'completed')
            ->whereHas('user', fn($q) => $q->where('role', 'agency'))
            ->sum('total_amount');

        $avgOrderValue = Order::where('status', 'completed')->avg('total_amount') ?? 0;

        // 4. Biểu đồ doanh thu 6 tháng gần nhất (Line Area Chart)
        $chartMonths = [];
        $chartRevenueData = [];
        $chartSalesData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chartMonths[] = 'Thg ' . $date->format('m');

            $rev = Order::where('status', 'completed')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');

            $cnt = Order::where('status', 'completed')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $chartRevenueData[] = round($rev / 1000000, 1); // Đơn vị Triệu đồng
            $chartSalesData[] = $cnt;
        }

        // 5. Thống kê phân tích trạng thái đơn hàng (Doughnut Ring Chart)
        $completedCount = Order::where('status', 'completed')->count();
        $processingCount = Order::whereIn('status', ['pending', 'processing', 'shipping'])->count();
        $cancelledCount = Order::where('status', 'cancelled')->count();
        $totalStatusCount = max(1, $completedCount + $processingCount + $cancelledCount);

        $completedPercent = round(($completedCount / $totalStatusCount) * 100);

        // 6. Nhật ký hoạt động gần nhất hệ thống
        $activities = [];

        $recentOrdersList = Order::with('user')->latest()->take(3)->get();
        foreach ($recentOrdersList as $ord) {
            $activities[] = [
                'time' => $ord->created_at ? $ord->created_at->diffForHumans() : 'Vừa xong',
                'title' => "Đơn hàng mới #{$ord->id}",
                'actor' => $ord->customer_name ?? 'Khách hàng',
                'icon' => 'fa-solid fa-cart-shopping',
                'bg' => 'bg-purple-100 text-purple-600 dark:bg-purple-950 dark:text-purple-400',
            ];
        }

        $recentPostsList = Post::latest()->take(2)->get();
        foreach ($recentPostsList as $p) {
            $activities[] = [
                'time' => $p->created_at ? $p->created_at->diffForHumans() : 'Vừa xong',
                'title' => "Bài viết: " . \Illuminate\Support\Str::limit($p->title, 28),
                'actor' => 'Ban quản trị EcoFarm',
                'icon' => 'fa-solid fa-newspaper',
                'bg' => 'bg-blue-100 text-blue-600 dark:bg-blue-950 dark:text-blue-400',
            ];
        }

        $recentContactsList = Contact::latest()->take(2)->get();
        foreach ($recentContactsList as $c) {
            $activities[] = [
                'time' => $c->created_at ? $c->created_at->diffForHumans() : 'Vừa xong',
                'title' => "Yêu cầu tư vấn mới",
                'actor' => $c->name ?? 'Bà con nông dân',
                'icon' => 'fa-solid fa-phone-volume',
                'bg' => 'bg-rose-100 text-rose-600 dark:bg-rose-950 dark:text-rose-400',
            ];
        }

        // 7. Danh sách 6 đơn hàng mới nhất cho bảng quản lý bên phải
        $latestOrders = Order::with('user')->latest()->take(6)->get();

        return [
            'productsCount' => $productsCount,
            'ordersCount' => $ordersCount,
            'totalRevenue' => $totalRevenue,
            'usersCount' => $usersCount,
            'currentMonthRevenue' => $currentMonthRevenue,
            'currentMonthSales' => $currentMonthSales,
            'b2cRevenue' => $b2cRevenue,
            'b2bRevenue' => $b2bRevenue,
            'avgOrderValue' => $avgOrderValue,
            'chartMonths' => $chartMonths,
            'chartRevenueData' => $chartRevenueData,
            'chartSalesData' => $chartSalesData,
            'completedCount' => $completedCount,
            'processingCount' => $processingCount,
            'cancelledCount' => $cancelledCount,
            'completedPercent' => $completedPercent,
            'activities' => array_slice($activities, 0, 4),
            'latestOrders' => $latestOrders,
        ];
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Contact;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CRMManagementController extends Controller
{
    /**
     * 🌟 1. TRANG TỔNG QUAN (EXECUTIVE DASHBOARD) - KHỚP 100% ẢNH MẪU 2
     */
    public function dashboard()
    {
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->get();
        $totalRevenue = $completedOrders->sum('total_amount');
        
        $pendingCount = Order::where('status', 'pending')->count();
        $processingCount = Order::where('status', 'processing')->count();
        $shippingCount = Order::where('status', 'shipping')->count();
        
        // Lead & Customer counts
        $customerCount = User::whereIn('role', ['customer', 'agency'])->count();
        $agencyCount = User::where('role', 'agency')->count();

        // High priority / hot leads simulation
        $recentOrders = Order::latest()->take(10)->get();

        return view('backend.crm.dashboard', compact(
            'totalOrders',
            'completedOrders',
            'totalRevenue',
            'pendingCount',
            'processingCount',
            'shippingCount',
            'customerCount',
            'agencyCount',
            'recentOrders'
        ));
    }

    /**
     * 🌟 2. TRANG DANH SÁCH KHÁCH HÀNG (CUSTOMER LIST) - KHỚP 100% ẢNH MẪU 1
     */
    public function customers(Request $request)
    {
        $query = User::whereIn('role', ['customer', 'agency']);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('phone', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        $customers = $query->latest()->paginate(15);
        $totalCount = User::whereIn('role', ['customer', 'agency'])->count();
        
        // Orders mapping to customers
        $orders = Order::latest()->take(20)->get();

        return view('backend.crm.customers', compact('customers', 'totalCount', 'orders'));
    }

    /**
     * 🌟 3. TRANG DEAL ĐÃ CHỐT & ĐƠN HÀNG THÀNH CÔNG (DEALS) - KHỚP 100% ẢNH MẪU 3
     */
    public function deals(Request $request)
    {
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->subMonths(6)->startOfDay();
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        $query = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate]);

        $completedDeals = $query->latest()->get();
        $dealCount = $completedDeals->count();
        $totalContractValue = $completedDeals->sum('total_amount');
        $avgDealValue = $dealCount > 0 ? $totalContractValue / $dealCount : 0;
        $totalCommission = $totalContractValue * 0.025; // 2.5% agency commission

        return view('backend.crm.deals', compact(
            'completedDeals',
            'dealCount',
            'totalContractValue',
            'avgDealValue',
            'totalCommission',
            'startDate',
            'endDate'
        ));
    }
}

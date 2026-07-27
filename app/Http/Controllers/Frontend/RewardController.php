<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RewardController extends Controller
{
    /**
     * Hiển thị trang tích lũy điểm thưởng và danh sách quà tặng (vouchers)
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem thông tin tích lũy điểm thưởng!');
        }

        $user = auth()->user();

        // Lấy danh sách các voucher mẫu cho phép đổi bằng điểm
        $vouchers = Voucher::where('is_active', true)
            ->whereNotNull('points_cost')
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->whereColumn('uses', '<', 'max_uses')
            ->orderBy('points_cost', 'asc')
            ->get();

        return view('frontend.rewards.index', compact('user', 'vouchers'));
    }

    /**
     * Xử lý quy đổi điểm tích lũy lấy mã giảm giá cá nhân
     */
    public function redeem(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thực hiện đổi điểm!'
            ], 401);
        }

        $request->validate([
            'voucher_id' => 'required|integer'
        ]);

        $user = auth()->user();
        $voucher = Voucher::find($request->voucher_id);

        if (!$voucher || !$voucher->is_active || is_null($voucher->points_cost)) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá này hiện không khả dụng hoặc không hỗ trợ quy đổi bằng điểm thưởng!'
            ]);
        }

        if ($user->reward_points < $voucher->points_cost) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không đủ điểm thưởng tích lũy! Số điểm cần đổi là ' . $voucher->points_cost . 'đ, hiện tại bạn mới có ' . $user->reward_points . 'đ.'
            ]);
        }

        // Khấu trừ điểm của người dùng
        $user->decrement('reward_points', $voucher->points_cost);

        // Tạo mã giảm giá cá nhân ngẫu nhiên, giới hạn sử dụng 1 lần
        $personalCode = 'REDEEM-' . strtoupper(Str::random(6));
        
        Voucher::create([
            'code' => $personalCode,
            'type' => $voucher->type,
            'value' => $voucher->value,
            'min_order_amount' => $voucher->min_order_amount,
            'max_uses' => 1,
            'uses' => 0,
            'expires_at' => $voucher->expires_at ?? now()->addDays(30), // Mặc định hết hạn sau 30 ngày nếu voucher mẫu không giới hạn thời gian
            'is_active' => true,
            'product_id' => $voucher->product_id,
            'points_cost' => null, // Không cho phép dùng mã này đổi tiếp
            'user_id' => $user->id,
        ]);

        // Ghi nhật ký đổi quà
        $user->pointTransactions()->create([
            'points' => -$voucher->points_cost,
            'transaction_type' => 'redeem',
            'description' => "Đổi điểm lấy mã giảm giá cá nhân {$personalCode}",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đổi điểm tích lũy thành công!',
            'code' => $personalCode,
            'new_points' => $user->reward_points
        ]);
    }
}

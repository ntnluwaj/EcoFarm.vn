<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    /**
     * Nhận callback tự động báo có từ tài khoản ngân hàng (SePay API)
     */
    public function sepayWebhook(Request $request)
    {
        Log::info('SePay Webhook Payload:', $request->all());

        // 1. Lấy dữ liệu giao dịch
        $content = $request->input('content'); // Nội dung chuyển khoản
        $amountIn = floatval($request->input('amountIn', 0)); // Số tiền nhận được
        $referenceCode = $request->input('referenceCode'); // Mã giao dịch ngân hàng

        if (empty($content) || $amountIn <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu chuyển khoản không hợp lệ!'
            ], 400);
        }

        // 2. Tìm mã đơn hàng từ nội dung chuyển khoản (Định dạng: ECF[id] hoặc EcoFarm DH[id])
        if (preg_match('/(?:EcoFarm\s*DH|ECF)\s*0*(\d+)/i', $content, $matches)) {
            $orderId = intval($matches[1]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nội dung chuyển khoản không chứa cú pháp mã đơn hàng EcoFarm!'
            ], 200); // Trả về 200 để tránh SePay gửi lại liên tục
        }

        $formattedId = 'ECF' . str_pad($orderId, 6, '0', STR_PAD_LEFT);

        // 3. Tìm đơn hàng trên CSDL
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy đơn hàng {$formattedId} trên hệ thống!"
            ], 200);
        }

        // 4. Kiểm tra số tiền chuyển khoản (so khớp với tổng tiền đơn hàng)
        // Để tránh sai lệch làm tròn số thập phân, ta so sánh trị tuyệt đối chênh lệch < 1000đ
        if (abs(floatval($order->total_amount) - $amountIn) > 1000) {
            return response()->json([
                'success' => false,
                'message' => "Số tiền thanh toán ({$amountIn}đ) không khớp với tổng tiền đơn hàng {$formattedId} ({$order->total_amount}đ)!"
            ], 200);
        }

        // 5. Cập nhật trạng thái đơn hàng nếu đơn đang chờ thanh toán
        // 5. Cập nhật trạng thái đơn hàng nếu đơn đang chờ thanh toán
        if ($order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'payment_transaction_id' => $referenceCode,
                'status' => 'processing', // Tự động chuyển sang Đang đóng gói
            ]);

            // Bắn thông báo chuông chào mừng cho Admin về biến động dòng tiền
            try {
                $recipients = \App\Models\User::whereIn('role', ['admin', 'staff'])->get();
                \Filament\Notifications\Notification::make()
                    ->title("Thanh toán tự động thành công!")
                    ->body("Đơn hàng {$formattedId} vừa nhận thanh toán số tiền " . number_format($amountIn, 0, ',', '.') . "đ qua VietQR. Hệ thống đã tự động chuyển trạng thái đơn hàng sang Đang đóng gói.")
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->sendToDatabase($recipients);
            } catch (\Exception $e) {
                Log::error("Lỗi khi bắn thông báo Admin qua Filament: " . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => "Xác thực thanh toán đơn hàng {$formattedId} thành công!"
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Đơn hàng {$formattedId} đã được thanh toán trước đó."
        ]);
    }
}

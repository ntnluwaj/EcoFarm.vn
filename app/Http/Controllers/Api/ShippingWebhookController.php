<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShippingWebhookController extends Controller
{
    /**
     * Nhận callback tự động cập nhật trạng thái giao nhận từ đơn vị vận chuyển (GHN API Webhook)
     */
    public function ghnWebhook(Request $request)
    {
        Log::info('GHN Webhook Payload:', $request->all());

        $orderId = $request->input('order_id');
        $trackingCode = $request->input('tracking_code');
        $status = $request->input('status'); // 'shipping' hoặc 'completed'
        $description = $request->input('description', '');

        if (!$orderId || !$status) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin mã đơn hàng hoặc trạng thái cập nhật!'
            ], 400);
        }

        // Tìm đơn hàng trên hệ thống
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy đơn hàng #DH{$orderId} trên hệ thống!"
            ], 200);
        }

        // Cập nhật trạng thái
        if (in_array($status, ['shipping', 'completed'])) {
            // Nếu chuyển sang hoàn thành, cập nhật luôn trạng thái thanh toán nếu là COD
            $updateData = ['status' => $status];
            if ($status === 'completed' && $order->payment_method === 'COD') {
                $updateData['payment_status'] = 'paid';
            }

            $order->update($updateData);

            // Báo cho Admin và Nhân viên biết tình trạng shipper
            try {
                $recipients = \App\Models\User::whereIn('role', ['admin', 'staff'])->get();
                $statusLabel = $status === 'shipping' ? 'Đang vận chuyển' : 'Giao hàng thành công';
                
                \Filament\Notifications\Notification::make()
                    ->title("Cập nhật vận đơn #DH{$order->id} từ ĐVVC")
                    ->body("Shipper báo: {$statusLabel}. Chi tiết: " . ($description ?: 'Cập nhật từ hệ thống ĐVVC.'))
                    ->icon('heroicon-o-truck')
                    ->color('info')
                    ->sendToDatabase($recipients);
            } catch (\Exception $e) {
                Log::error("Lỗi khi bắn thông báo Admin qua Filament: " . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => "Đã cập nhật đơn hàng #DH{$orderId} sang trạng thái {$status} thành công!"
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Trạng thái cập nhật vận đơn không hợp lệ!'
        ], 400);
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SandboxController extends Controller
{
    /**
     * Hiển thị bảng điều khiển Sandbox Giả lập
     */
    public function index()
    {
        // Lấy 15 đơn hàng mới nhất để test
        $orders = Order::with('items.product', 'orderLogs')
            ->orderBy('id', 'desc')
            ->take(15)
            ->get();

        return view('frontend.sandbox.index', compact('orders'));
    }

    /**
     * Giả lập thanh toán VietQR ngân hàng (SePay Callback)
     */
    public function paySimulate(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::findOrFail($orderId);

        // Gửi POST request nội bộ mô phỏng SePay bắn Webhook
        try {
            $apiUrl = url('/api/payment/sepay-webhook');
            
            Log::info("Simulating Bank Webhook request to: {$apiUrl}");

            $response = Http::post($apiUrl, [
                'id' => rand(100000, 999999),
                'gateway' => 'Vietcombank',
                'transactionDate' => now()->format('Y-m-d H:i:s'),
                'amountIn' => floatval($order->total_amount),
                'amountOut' => 0,
                'content' => "EcoFarm DH{$order->id} thanh toan chuyen khoan",
                'transferType' => 'in',
                'referenceCode' => 'FT' . rand(10000000, 99999999),
                'subAccount' => '1029384756',
            ]);

            if ($response->successful()) {
                $resData = $response->json();
                if ($resData['success'] ?? false) {
                    return redirect()->back()->with('success', 'Giả lập chuyển khoản thành công! ' . $resData['message']);
                }
                return redirect()->back()->with('error', 'Giả lập chuyển khoản thất bại từ Webhook: ' . ($resData['message'] ?? 'Lỗi không xác định.'));
            }

            return redirect()->back()->with('error', 'Không thể kết nối đến Webhook cục bộ! Mã lỗi HTTP: ' . $response->status());

        } catch (\Exception $e) {
            Log::error("Lỗi Sandbox paySimulate: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Giả lập cập nhật trạng thái Shipper (GHN Webhook)
     */
    public function shipSimulate(Request $request)
    {
        $orderId = $request->input('order_id');
        $status = $request->input('status'); // 'shipping' hoặc 'completed'
        $order = Order::findOrFail($orderId);

        try {
            $trackingCode = $order->payment_transaction_id;

            // Nếu đơn hàng chưa được đăng ký ĐVVC, tiến hành đăng ký giả lập trước
            if (empty($trackingCode) || !str_starts_with($trackingCode, 'GHN')) {
                $shipRes = ShippingService::createGhnOrder($order);
                if ($shipRes['success']) {
                    $trackingCode = $shipRes['tracking_code'];
                    // Lưu lại mã vận đơn vào đơn hàng làm đối chứng
                    $order->update([
                        'payment_transaction_id' => $trackingCode
                    ]);
                }
            }

            $apiUrl = url('/api/shipping/ghn-webhook');
            Log::info("Simulating GHN Webhook request to: {$apiUrl}");

            $description = $status === 'shipping'
                ? 'Shipper da lay vat tu tu kho trung tam. Xe dang lan banh.'
                : 'Vat tu da duoc shipper ban giao day du cho chu vuon.';

            // Gửi POST request nội bộ mô phỏng GHN bắn Webhook cập nhật
            $response = Http::post($apiUrl, [
                'order_id' => $order->id,
                'tracking_code' => $trackingCode,
                'status' => $status,
                'description' => $description
            ]);

            if ($response->successful()) {
                $resData = $response->json();
                if ($resData['success'] ?? false) {
                    return redirect()->back()->with('success', 'Giả lập ĐVVC thành công! ' . $resData['message']);
                }
                return redirect()->back()->with('error', 'Giả lập ĐVVC thất bại từ Webhook: ' . ($resData['message'] ?? 'Lỗi không xác định.'));
            }

            return redirect()->back()->with('error', 'Không thể kết nối đến Webhook cục bộ! Mã lỗi HTTP: ' . $response->status());

        } catch (\Exception $e) {
            Log::error("Lỗi Sandbox shipSimulate: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}

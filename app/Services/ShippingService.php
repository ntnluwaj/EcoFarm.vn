<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class ShippingService
{
    /**
     * Mô phỏng gửi vận đơn đặt hàng sang Giao Hàng Nhanh (GHN API)
     */
    public static function createGhnOrder(Order $order)
    {
        Log::info("Sending order #DH{$order->id} to GHN API simulator...");

        // Giả lập xử lý trễ mạng 200ms
        usleep(200000);

        // Sinh mã vận đơn ngẫu nhiên chuẩn định dạng GHN
        $trackingCode = 'GHN' . rand(10000000, 99999999) . 'VN';

        Log::info("GHN API simulator returned tracking code: {$trackingCode}");

        return [
            'success' => true,
            'tracking_code' => $trackingCode,
            'fee' => 35000, // Chi phí vận chuyển giả lập
            'expected_delivery_time' => now()->addDays(2)->format('Y-m-d H:i:s')
        ];
    }
}

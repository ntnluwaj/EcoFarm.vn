<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    /**
     * BẮN TIN NHẮN THÔNG BÁO ĐƠN HÀNG MỚI (PRD)
     */
    public static function sendOrderAlert(Order $order): void
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        // 1. Biên soạn nội dung tin nhắn dạng Markdown chuẩn hóa doanh nghiệp
        $orderCode = 'DH' . str_pad($order->id, 8, '0', STR_PAD_LEFT);
        $totalFormatted = number_format($order->total_amount, 0, ',', '.') . 'đ';
        
        $rawAddress = $order->shipping_address;
        $cleanAddress = $rawAddress;
        $vat = 'Không xuất hóa đơn';
        
        if (str_contains($rawAddress, ' [Xuất HĐ: ')) {
            $parts = explode(' [Xuất HĐ: ', $rawAddress);
            $cleanAddress = $parts[0];
            $vatDetails = str_replace(']', '', $parts[1]);
            $vat = "Yêu cầu hóa đơn đỏ ({$vatDetails})";
        }
        
        $message = "🔔 *THÔNG BÁO ĐƠN HÀNG MỚI - ECOFARM*\n";
        $message .= "───────────────────────\n";
        $message .= "📦 *Mã đơn:* `{$orderCode}`\n";
        $message .= "👤 *Khách hàng:* {$order->customer_name}\n";
        $message .= "📞 *Số điện thoại:* `{$order->customer_phone}`\n";
        $message .= "📍 *Bến giao:* {$cleanAddress}\n";
        $message .= "💰 *Tổng tiền:* `{$totalFormatted}`\n";
        $message .= "💳 *Thanh toán:* _" . strtoupper($order->payment_method) . "_\n";
        $message .= "📋 *Thuế đỏ:* {$vat}\n";
        $message .= "───────────────────────\n";
        $message .= "🌾 *DANH SÁCH BỐC XẾP VẬT TƯ:*\n";

        foreach ($order->items as $index => $item) {
            $stt = $index + 1;
            $productName = $item->product->name ?? 'Vật tư';
            $variant = $item->productVariant ? " ({$item->productVariant->capacity})" : "";
            $qty = $item->quantity;
            $price = number_format($item->unit_price, 0, ',', '.') . 'đ';
            $message .= "  {$stt}. {$productName}{$variant} x {$qty} [{$price}]\n";
        }
        
        $message .= "───────────────────────\n";
        $message .= "📅 *Thời gian đặt:* " . date('d/m/Y H:i') . "\n";
        $message .= "🔗 [Xem chi tiết vận đơn ngoài Admin](" . url('/admin/orders/' . $order->id . '/edit') . ")";

        // 2. Kiểm tra nếu chưa cấu hình thì ghi log dự phòng (Fallback Logging)
        if (empty($botToken) || empty($chatId)) {
            $logPath = storage_path('logs/telegram.log');
            $timestamp = date('Y-m-d H:i:s');
            $logContent = "[{$timestamp}] ECOFARM TELEGRAM MOCK ALERT:\n{$message}\n" . str_repeat('=', 50) . "\n\n";
            @file_put_contents($logPath, $logContent, FILE_APPEND);
            
            Log::info("EcoFarm Telegram Alert Fallback Log: Code {$orderCode} created.");
            return;
        }

        // 3. Thực hiện gửi yêu cầu API đến máy chủ Telegram
        try {
            Http::timeout(5)
                ->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'Markdown',
                    'disable_web_page_preview' => true,
                ]);
        } catch (\Exception $e) {
            Log::error("Lỗi gửi thông báo Telegram đơn hàng {$orderCode}: " . $e->getMessage());
        }
    }
}

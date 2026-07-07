<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    // 🌟 THÊM DÒNG NÀY ĐỂ TẮT CỘT updated_at (ĐỒNG BỘ 100% DATABASE SCHEMA PRD)
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'status',
        'cancel_reason',
        'total_amount',
        'payment_method',
        'payment_status',
        'payment_transaction_id',
        'shipping_address',
    ];

    /**
     * TỰ ĐỘNG HÓA LOGIC NGHIỆP VỤ (HỌC PHẦN HỆ THỐNG THÔNG TIN - PRD TIÊU CHÍ AC-03)
     */
    protected static function booted()
    {
        // 1. Tự động ghi nhận Log tiến trình khi đơn hàng được tạo mới hoặc cập nhật trạng thái
        static::saved(function ($order) {
            // Chỉ ghi log nếu trạng thái (status) hoặc tình trạng thanh toán bị thay đổi
            if ($order->wasRecentlyCreated || $order->isDirty('status')) {
                $order->orderLogs()->create([
                    'status' => $order->status,
                    'changed_by' => Auth::id() ?? null, // Ghi nhận ID nhân viên/admin thực hiện tác vụ (bảng order_logs)
                ]);
            }

            // 🌟 THÔNG BÁO CHO KHÁCH HÀNG KHI TRẠNG THÁI ĐƠN HÀNG THAY ĐỔI (PRD)
            if ($order->isDirty('status') && !$order->wasRecentlyCreated) {
                $customer = $order->user;
                if ($customer) {
                    $statusText = match($order->status) {
                        'pending' => 'Chờ duyệt',
                        'processing' => 'Đang đóng gói bốc xếp',
                        'shipping' => 'Đang giao hàng',
                        'completed' => 'Đã giao thành công',
                        'cancelled' => 'Đã hủy',
                        default => $order->status
                    };

                    try {
                        \Filament\Notifications\Notification::make()
                            ->title("Vận đơn #DH{$order->id} cập nhật")
                            ->body("Đơn hàng của bạn đã chuyển sang trạng thái: {$statusText}.")
                            ->icon('heroicon-o-shopping-bag')
                            ->color('success')
                            ->sendToDatabase($customer);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Lỗi thông báo trạng thái đơn hàng tới user: " . $e->getMessage());
                    }
                }
            }

            // 2. LOGIC ĐỐI SOÁT TỒN KHO KHI HỦY ĐƠN HÀNG
            // Nếu đơn hàng chuyển sang trạng thái hủy 'cancelled' từ một trạng thái khác
            if ($order->isDirty('status') && $order->status === 'cancelled' && $order->getOriginal('status') !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product_variant_id) {
                        $variant = $item->productVariant;
                        if ($variant) {
                            $variant->increment('stock', $item->quantity);
                        }
                    } else {
                        $product = $item->product;
                        if ($product) {
                            $product->increment('stock', $item->quantity);
                        }
                    }
                }
            }

            // 3. LOGIC HOÀN TỒN KHO NẾU ĐƠN HÀNG ĐƯỢC PHỤC HỒI TỪ TRẠNG THÁI HỦY
            // Nếu đơn hàng khôi phục từ trạng thái hủy 'cancelled' sang một trạng thái hoạt động khác
            if ($order->isDirty('status') && $order->getOriginal('status') === 'cancelled' && $order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product_variant_id) {
                        $variant = $item->productVariant;
                        if ($variant) {
                            $variant->decrement('stock', $item->quantity);
                        }
                    } else {
                        $product = $item->product;
                        if ($product) {
                            $product->decrement('stock', $item->quantity);
                        }
                    }
                }
            }
        });

        // 4. LOGIC HOÀN TỒN KHO KHI XÓA ĐƠN HÀNG KHỎI HỆ THỐNG (NẾU ĐƠN CHƯA HỦY)
        static::deleting(function ($order) {
            if ($order->status !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product_variant_id) {
                        $variant = $item->productVariant;
                        if ($variant) {
                            $variant->increment('stock', $item->quantity);
                        }
                    } else {
                        $product = $item->product;
                        if ($product) {
                            $product->increment('stock', $item->quantity);
                        }
                    }
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function orderLogs(): HasMany
    {
        return $this->hasMany(OrderLog::class, 'order_id');
    }
}
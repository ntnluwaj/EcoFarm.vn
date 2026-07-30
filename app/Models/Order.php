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
        'customer_email',
        'status',
        'cancel_reason',
        'total_amount',
        'payment_method',
        'payment_status',
        'payment_transaction_id',
        'shipping_address',
        'coupon_code',
        'discount_amount',
        'cod_reconciled',
    ];

    protected $casts = [
        'cod_reconciled' => 'boolean',
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

            // 🌟 TỰ ĐỘNG GỬI EMAIL THÔNG BÁO TIẾN ĐỘ ĐƠN HÀNG (MỚI BỔ SUNG)
            if ($order->wasRecentlyCreated || $order->isDirty('status') || $order->isDirty('payment_status')) {
                if ($order->customer_email) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($order->customer_email)
                            ->send(new \App\Mail\OrderStatusMail($order));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Lỗi gửi Email trạng thái đơn hàng: " . $e->getMessage());
                    }
                }
            }

            // 🌟 THÔNG BÁO CHO KHÁCH HÀNG KHI TRẠNG THÁI ĐƠN HÀNG THAY ĐỔI (PRD)
            if ($order->isDirty('status') && !$order->wasRecentlyCreated) {
                $customer = $order->user;
                if ($customer) {
                    $statusText = match($order->status) {
                        'pending' => 'Chờ duyệt',
                        'processing' => 'Đang đóng gói bốc xếp',
                        'shipping' => 'Đang giao hàng (Đã giao cho đơn vị vận chuyển)',
                        'completed' => 'Đã giao hàng thành công',
                        'cancelled' => 'Đã hủy',
                        default => $order->status
                    };

                    try {
                        $customer->notify(new \App\Notifications\SystemNotification([
                            'title' => "Trạng thái đơn hàng ECF{$order->id} cập nhật",
                            'body' => "Đơn hàng của bạn đã chuyển sang trạng thái: {$statusText}.",
                            'icon' => $order->status === 'shipping' ? 'heroicon-o-truck' : 'heroicon-o-shopping-bag',
                            'color' => $order->status === 'cancelled' ? 'danger' : 'success',
                            'url' => route('cart.history')
                        ]));
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Lỗi thông báo trạng thái đơn hàng tới user: " . $e->getMessage());
                    }

                    // Nếu đơn hoàn thành: Tích điểm và thông báo đổi Voucher
                    if ($order->status === 'completed') {
                        try {
                            $points = floor($order->total_amount / 10000);
                            $customer->notify(new \App\Notifications\SystemNotification([
                                'title' => 'Bạn được cộng điểm thưởng!',
                                'body' => "Đơn hàng ECF{$order->id} hoàn thành giúp bạn tích lũy thêm {$points} điểm thưởng. Tổng điểm hiện tại của bạn đã tăng lên, hãy vào Kho quà tặng đổi Voucher ngay nhé!",
                                'icon' => 'heroicon-o-gift',
                                'color' => 'warning',
                                'url' => route('rewards.index')
                            ]));
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::error("Lỗi thông báo tích điểm thưởng tới user: " . $e->getMessage());
                        }
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

            // 🌟 LOGIC TÍCH ĐIỂM THƯỞNG KHI ĐƠN HÀNG HOÀN THÀNH
            if ($order->isDirty('status')) {
                $customer = $order->user;
                if ($customer) {
                    $points = floor($order->total_amount / 10000);
                    $orderCode = 'ECF' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
                    // Chuyển sang completed: Cộng điểm
                    if ($order->status === 'completed' && $order->getOriginal('status') !== 'completed') {
                        $customer->increment('reward_points', $points);
                        
                        // Ghi nhật ký tích điểm
                        $customer->pointTransactions()->create([
                            'points' => $points,
                            'transaction_type' => 'earn',
                            'description' => "Tích lũy điểm từ đơn hàng hoàn thành {$orderCode}",
                        ]);
                    }
                    // Chuyển từ completed sang trạng thái khác (hủy/đang xử lý): Trừ điểm
                    elseif ($order->getOriginal('status') === 'completed' && $order->status !== 'completed') {
                        $actualDeduct = min($points, $customer->reward_points);
                        $customer->decrement('reward_points', $actualDeduct);

                        // Ghi nhật ký khấu trừ điểm
                        $customer->pointTransactions()->create([
                            'points' => -$actualDeduct,
                            'transaction_type' => 'refund',
                            'description' => "Khấu trừ điểm do đơn hàng {$orderCode} thay đổi trạng thái",
                        ]);
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
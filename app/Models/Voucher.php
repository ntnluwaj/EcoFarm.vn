<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_uses',
        'uses',
        'expires_at',
        'is_active',
        'product_id',
        'points_cost',
        'user_id',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_uses' => 'integer',
        'uses' => 'integer',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'product_id' => 'integer',
        'points_cost' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Quan hệ liên kết tới khách hàng sở hữu mã này (nếu có)
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ liên kết tới sản phẩm nhất định
     */
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Kiểm tra xem mã voucher còn sử dụng được không dựa trên giỏ hàng
     */
    public function isValidForCart($cartItems, $totalAmount, &$errorMessage = ''): bool
    {
        if ($this->user_id && (!auth()->check() || auth()->id() !== $this->user_id)) {
            $errorMessage = 'Mã giảm giá cá nhân này không thuộc quyền sở hữu của bạn!';
            return false;
        }

        if (!$this->is_active) {
            $errorMessage = 'Mã giảm giá này hiện đã bị vô hiệu hóa!';
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            $errorMessage = 'Mã giảm giá này đã hết hạn sử dụng!';
            return false;
        }

        if ($this->uses >= $this->max_uses) {
            $errorMessage = 'Mã giảm giá này đã đạt giới hạn lượt sử dụng!';
            return false;
        }

        // Kiểm tra nếu chỉ áp dụng cho một sản phẩm nhất định
        if ($this->product_id) {
            $targetProduct = null;
            foreach ($cartItems as $item) {
                if ($item['product_id'] == $this->product_id) {
                    $targetProduct = $item;
                    break;
                }
            }

            if (!$targetProduct) {
                $productName = Product::find($this->product_id)->name ?? 'sản phẩm chỉ định';
                $errorMessage = "Mã giảm giá này chỉ áp dụng cho sản phẩm: {$productName}!";
                return false;
            }

            // Tính subtotal của riêng sản phẩm đó
            $productSubtotal = $targetProduct['price'] * $targetProduct['quantity'];
            if ($productSubtotal < $this->min_order_amount) {
                $errorMessage = 'Tổng tiền sản phẩm ' . $targetProduct['name'] . ' chưa đạt mức tối thiểu ' . number_format($this->min_order_amount, 0, ',', '.') . 'đ để sử dụng mã này!';
                return false;
            }
        } else {
            // Áp dụng cho toàn bộ đơn hàng
            if ($totalAmount < $this->min_order_amount) {
                $errorMessage = 'Giá trị đơn hàng chưa đạt mức tối thiểu ' . number_format($this->min_order_amount, 0, ',', '.') . 'đ để sử dụng mã này!';
                return false;
            }
        }

        return true;
    }

    /**
     * Tính toán số tiền được giảm giá dựa trên giỏ hàng
     */
    public function calculateDiscountForCart($cartItems, $totalAmount): float
    {
        if ($this->product_id) {
            $targetProduct = null;
            foreach ($cartItems as $item) {
                if ($item['product_id'] == $this->product_id) {
                    $targetProduct = $item;
                    break;
                }
            }

            if (!$targetProduct) {
                return 0;
            }

            $productSubtotal = floatval($targetProduct['price'] * $targetProduct['quantity']);
            if ($this->type === 'percent') {
                return floatval($productSubtotal * ($this->value / 100));
            }
            return min(floatval($this->value), $productSubtotal);
        }

        // Toàn bộ đơn hàng
        if ($this->type === 'percent') {
            return floatval($totalAmount * ($this->value / 100));
        }
        return min(floatval($this->value), floatval($totalAmount));
    }
}

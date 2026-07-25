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
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_uses' => 'integer',
        'uses' => 'integer',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Kiểm tra xem mã voucher còn sử dụng được không
     */
    public function isValidForAmount($amount): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->uses >= $this->max_uses) {
            return false;
        }

        if ($amount < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    /**
     * Tính toán số tiền được giảm giá
     */
    public function calculateDiscount($amount): float
    {
        if ($this->type === 'percent') {
            return floatval($amount * ($this->value / 100));
        }

        // Loại 'fixed'
        return min(floatval($this->value), floatval($amount));
    }
}

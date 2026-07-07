<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id', 'product_id', 'product_variant_id', 'quantity', 'unit_price', 'price_type'];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productVariant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * TỰ ĐỘNG HÓA LOGIC TỒN KHO & TỔNG TIỀN ĐƠN HÀNG KHI THAY ĐỔI CHI TIẾT SẢN PHẨM (AC-01)
     */
    protected static function booted()
    {
        // 1. Khi thêm mới một sản phẩm vào đơn hàng
        static::created(function ($item) {
            $order = $item->order;
            if ($order) {
                // Cập nhật lại tổng tiền đơn hàng cha
                $order->update([
                    'total_amount' => $order->items()->sum(\DB::raw('quantity * unit_price'))
                ]);

                // Nếu đơn hàng đang hoạt động (không phải cancelled), trừ tồn kho
                if ($order->status !== 'cancelled') {
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

        // 2. Khi chỉnh sửa sản phẩm trong đơn hàng (số lượng / đơn giá)
        static::updated(function ($item) {
            $order = $item->order;
            if ($order) {
                // Cập nhật lại tổng tiền đơn hàng cha
                $order->update([
                    'total_amount' => $order->items()->sum(\DB::raw('quantity * unit_price'))
                ]);

                // Nếu đơn hàng đang hoạt động (không phải cancelled), điều chỉnh tồn kho
                if ($order->status !== 'cancelled' && $item->wasChanged('quantity')) {
                    $diff = $item->quantity - $item->getOriginal('quantity');
                    if ($item->product_variant_id) {
                        $variant = $item->productVariant;
                        if ($variant) {
                            $variant->decrement('stock', $diff);
                        }
                    } else {
                        $product = $item->product;
                        if ($product) {
                            $product->decrement('stock', $diff);
                        }
                    }
                }
            }
        });

        // 3. Khi xóa sản phẩm ra khỏi đơn hàng
        static::deleted(function ($item) {
            $order = $item->order;
            if ($order) {
                // Cập nhật lại tổng tiền đơn hàng cha
                $order->update([
                    'total_amount' => $order->items()->sum(\DB::raw('quantity * unit_price')) ?: 0
                ]);

                // Nếu đơn hàng đang hoạt động (không phải cancelled), trả hàng lại kho
                if ($order->status !== 'cancelled') {
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
}

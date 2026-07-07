<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const UPDATED_AT = null; // Bảng products chỉ dùng created_at trong PRD
    
    protected $fillable = [
        'name', 'slug', 'category_id', 'brand_id', 'price', 
        'unit', 'packaging', 'stock', 
        'description', 'usage_guide', 'status', 
        'images' // 🌟 TÍCH HỢP: Cho phép ghi dữ liệu chuỗi nhiều ảnh
    ];

        protected $casts = [
            'images' => 'array', // 🌟 BẮT BUỘC: Ép kiểu mảng để Filament quản lý đa file
            'status' => 'integer',
            'price' => 'decimal:2',
        ];
    // Sản phẩm thuộc về một danh mục phân loại cụ thể
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Sản phẩm thuộc về một thương hiệu / nhà sản xuất
    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // Một sản phẩm có nhiều loại dung tích/phiên bản khác nhau
    public function variants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    // Một sản phẩm có nhiều lượt đánh giá từ nông dân
    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    // Một sản phẩm có các câu hỏi đáp kỹ thuật canh tác
    public function questions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductQuestion::class, 'product_id');
    }
}

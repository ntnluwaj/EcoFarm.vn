<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false; // Bảng brands không dùng timestamp trong PRD
    protected $fillable = ['name', 'slug', 'description'];

    // Một thương hiệu (như Syngenta, Bayer) có nhiều sản phẩm
    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}

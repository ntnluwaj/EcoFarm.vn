<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false; // Bảng categories không dùng updated_at/created_at trong PRD
    protected $fillable = ['name', 'parent_id', 'slug', 'image_url'];

    // Liên kết ngược về danh mục cha (Nhiều danh mục con thuộc 1 danh mục cha)
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Liên kết xuôi về các danh mục con
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Một danh mục có nhiều sản phẩm vật tư bên trong
    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}

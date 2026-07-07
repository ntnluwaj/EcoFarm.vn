<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
Schema::create('brands', function (Blueprint $table) {
            $table->id(); // Mã định danh duy nhất của thương hiệu / nhà sản xuất [cite: 400]
            $table->string('name', 100); // Tên thương hiệu vật tư (Ví dụ: Syngenta, Bayer, Đầu Trâu) [cite: 400]
            $table->string('slug', 100)->unique(); // Đường dẫn định danh ngắn phục vụ tối ưu hóa SEO [cite: 402]
            $table->text('description')->nullable(); // Bài viết thông tin giới thiệu về năng lực của nhà sản xuất [cite: 402]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};

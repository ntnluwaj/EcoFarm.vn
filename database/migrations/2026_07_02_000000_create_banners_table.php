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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Tiêu đề chính slide banner
            $table->string('subtitle')->nullable(); // Badge phụ đề nổi bật
            $table->string('image_path'); // Đường dẫn lưu trữ ảnh banner upload
            $table->string('link_url')->nullable(); // Liên kết click đến sản phẩm/danh mục
            $table->integer('sort_order')->default(0); // Thứ tự sắp xếp hiển thị slide
            $table->boolean('is_active')->default(true); // Trạng thái hiển thị (1: Hoạt động, 0: Tắt)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};

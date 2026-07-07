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
Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Mã định danh duy nhất của danh mục vật tư 
            $table->string('name', 100); // Tên danh mục phân loại sản phẩm 
            $table->unsignedBigInteger('parent_id')->nullable()->default(null); // ID danh mục cha phục vụ phân cấp đa tầng 
            $table->string('slug', 100)->unique(); // Đường dẫn định danh thân thiện phục vụ cấu hình SEO 
            $table->string('image_url', 255)->nullable(); // Đường dẫn hình ảnh đại diện trực quan của danh mục 
            
            // Khóa ngoại tự liên kết để quản lý cây danh mục đa tầng
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

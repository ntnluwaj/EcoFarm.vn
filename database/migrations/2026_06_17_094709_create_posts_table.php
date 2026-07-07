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
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Mã định danh duy nhất của bài viết hướng dẫn [cite: 464]
            $table->string('title'); // Tiêu đề bài viết kỹ thuật nông nghiệp [cite: 464]
            $table->string('slug')->unique(); // Đường dẫn thân thiện tối ưu hóa SEO bài viết [cite: 464]
            $table->longText('content'); // Nội dung chi tiết bài viết (chứa văn bản, hình ảnh) [cite: 464]
            $table->string('category')->nullable(); // Chuyên mục nội dung (Kỹ thuật canh tác, Lịch mùa vụ, Tin thị trường) [cite: 464]
            $table->string('thumbnail')->nullable(); // Đường dẫn ảnh đại diện tiêu đề hiển thị ngoài trang tin tức [cite: 464]
            $table->timestamp('published_at')->nullable(); // Ngày giờ phê duyệt xuất bản bài viết công khai [cite: 464]
            $table->timestamps(); // Tự động sinh hai cột created_at và updated_at cho hệ thống
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
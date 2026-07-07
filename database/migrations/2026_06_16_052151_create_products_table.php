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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Mã định danh duy nhất của mặt hàng sản phẩm
            $table->string('name', 150); // Tên thương mại của sản phẩm vật tư nông nghiệp
            $table->string('slug', 150)->unique(); // Đường dẫn slug thân thiện phục vụ cấu hình SEO
            $table->unsignedBigInteger('category_id'); // Khóa ngoại liên kết, xác định sản phẩm thuộc danh mục nào
            $table->unsignedBigInteger('brand_id')->nullable(); // Liên kết mã định danh nhà sản xuất (cho phép NULL)
            $table->decimal('price', 15, 2); // Giá bán lẻ niêm yết công khai cho nông dân / khách vãng lai
            $table->string('unit', 20); // Đơn vị tính cơ sở của vật tư (Ví dụ: Chai, Gói, Bao, Can)
            $table->string('packaging', 50); // Quy cách đóng gói thực tế phục vụ vận chuyển (Ví dụ: Thùng 24 chai, Bao 50kg)
            $table->integer('stock')->default(0); // Số lượng sản phẩm vật tư thực tế còn tồn trong kho hàng
            $table->text('description')->nullable(); // Bài viết mô tả chi tiết công dụng, thành phần, hoạt chất sản phẩm
            $table->text('usage_guide')->nullable(); // Hướng dẫn kỹ thuật canh tác, liều lượng pha chế và bón tưới an toàn
            $table->tinyInteger('status')->default(1); // Trạng thái kinh doanh hàng hóa (1: Đang bán, 0: Ngừng kinh doanh)
            
            // 🌟 TÍCH HỢP: Thêm cột lưu trữ mảng danh sách nhiều ảnh mẫu chạy Slide Frontend ngoài bến kho Cần Thơ
            $table->json('images')->nullable(); 

            $table->timestamp('created_at')->useCurrent(); // Ngày giờ thêm sản phẩm lên website (phục vụ lọc hàng mới)

            // Khai báo các ràng buộc khóa ngoại (Foreign Key)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
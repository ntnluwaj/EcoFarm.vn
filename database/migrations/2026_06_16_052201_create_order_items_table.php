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
Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Mã định danh duy nhất dòng chi tiết đơn hàng [cite: 445]
            $table->unsignedBigInteger('order_id'); // Thuộc về mã đơn hàng tổng nào (Hủy đơn tự động xóa chi tiết) [cite: 445]
            $table->unsignedBigInteger('product_id')->nullable(); // Mã sản phẩm được mua (Đặt NULL nếu xóa sản phẩm gốc để giữ toàn vẹn dữ liệu) [cite: 445]
            $table->integer('quantity'); // Số lượng hàng thực tế đặt mua của sản phẩm đó [cite: 445]
            $table->decimal('unit_price', 15, 2); // Giá sản phẩm chốt tại thời điểm mua (Tránh lỗi đổi giá sản phẩm sau này) [cite: 445]
            $table->string('price_type', 20); // Loại giá áp dụng khi mua (retail: giá lẻ niêm yết, wholesale: giá sỉ đại lý) [cite: 445]

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

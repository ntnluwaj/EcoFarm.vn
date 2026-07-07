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
Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Mã định danh duy nhất của đơn hàng [cite: 437]
            $table->unsignedBigInteger('user_id')->nullable(); // Mã tài khoản (để trống NULL nếu khách hàng chọn mua vãng lai) [cite: 437]
            $table->string('customer_name', 100); // Họ và tên người nhận hàng thực tế tại địa điểm giao [cite: 437]
            $table->string('customer_phone', 15); // Số điện thoại liên hệ khi bàn giao hàng vật tư [cite: 437]
            $table->string('status', 30)->default('pending'); // Trạng thái đơn: Chờ xác nhận, Đang xử lý, Đang giao, Hoàn tất, Đã hủy [cite: 439]
            $table->string('cancel_reason', 255)->nullable(); // Trường bắt buộc nhận ghi lý do chi tiết nếu đơn bị hủy [cite: 439]
            $table->decimal('total_amount', 15, 2); // Tổng dòng tiền cuối cùng khách thực tế phải thanh toán cho đơn [cite: 439]
            $table->string('payment_method', 50); // Giải pháp thanh toán lựa chọn (COD, VNPay, VietQR) [cite: 439]
            $table->string('payment_status', 30)->default('unpaid'); // Tình trạng tiền đơn hàng (unpaid: Chưa trả, paid: Đã trả, refunded: Hoàn tiền) [cite: 439, 441]
            $table->string('payment_transaction_id', 100)->nullable(); // Mã giao dịch do hệ thống cổng điện tử phản hồi về khi thanh toán online [cite: 441]
            $table->text('shipping_address'); // Địa chỉ chi tiết nhận hàng của đơn này phục vụ giao vận [cite: 441]
            $table->timestamp('created_at')->useCurrent(); // Ngày giờ người dùng chốt đặt đơn trực tuyến lên hệ thống [cite: 441]

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

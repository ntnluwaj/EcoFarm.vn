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
        Schema::create('order_logs', function (Blueprint $table) {
            $table->id(); // Mã định danh dòng ghi vết lịch sử 
            
            // Khóa ngoại liên kết trực tiếp thuộc về mã đơn hàng tổng nào (Hủy đơn tự động xóa log) 
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); 
            
            // Trạng thái chuyển dịch hệ thống (pending, processing, shipping, completed, cancelled) 
            $table->string('status', 30); 
            
            // Mã định danh cá nhân nhân viên/admin thực hiện tác vụ cập nhật (cho phép NULL nếu hệ thống tự hủy) 
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null'); 
            
            // Ngày giờ chính xác hệ thống tự động ghi nhận sự thay đổi trạng thái 
            $table->timestamp('log_time')->useCurrent(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_logs');
    }
};
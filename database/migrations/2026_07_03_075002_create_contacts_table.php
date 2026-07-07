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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // ID của user nếu đã đăng nhập
            $table->string('name', 100);
            $table->string('phone', 15);
            $table->string('email', 100)->nullable();
            $table->string('subject', 200);
            $table->text('message');
            
            // Xử lý phản hồi từ phía Admin/Kỹ sư
            $table->string('status', 30)->default('pending'); // pending: Chờ phản hồi, replied: Đã phản hồi
            $table->text('reply_content')->nullable();
            $table->unsignedBigInteger('replied_by')->nullable();
            $table->timestamp('replied_at')->nullable();
            
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('replied_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};

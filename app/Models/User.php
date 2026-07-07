<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser; // 🌟 IMPORT CHÍNH XÁC INTERFACE BẢO MẬT CỦA FILAMENT
use Filament\Panel;

class User extends Authenticatable implements FilamentUser // 🌟 THỰC THI CHÍNH XÁC FILAMENTUSER INTERFACE
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Khai báo các trường cho phép chèn dữ liệu hàng loạt vào bảng users.
     * Đã bổ sung 'role' (Phân quyền) và 'phone' (Số điện thoại) theo PRD.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    /**
     * Các thuộc tính sẽ bị ẩn đi khi chuyển dữ liệu về dạng JSON/Array.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ép kiểu dữ liệu tự động khi Laravel tương tác với Database.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    /**
     * THIẾT LẬP MỐI QUAN HỆ BIỂU ĐỒ DỮ LIỆU (RELATIONSHIPS)
     * Một khách hàng có thể có nhiều đơn hàng trong hệ thống lịch sử giao dịch.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * CẬP NHẬT: Cho phép cả Admin và Đại lý đi qua bộ lọc Panel để thực hiện xác thực
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        // Chỉnh chính xác tại đây: Cho phép mọi tài khoản (admin, agency, user) đi qua form đăng nhập
        return true;
    }
}
<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// 1. Cập nhật 500 điểm tích lũy cho tất cả người dùng trong hệ thống để tiện chạy thử nghiệm
\App\Models\User::query()->update(['reward_points' => 500]);
echo "Updated reward points (500 pts) for all users.\n";

// 2. Tạo các voucher mẫu cho phép quy đổi điểm thưởng
\App\Models\Voucher::updateOrCreate(
    ['code' => 'REWARD10'],
    [
        'type' => 'percent',
        'value' => 10,
        'min_order_amount' => 100000,
        'max_uses' => 200,
        'uses' => 0,
        'is_active' => true,
        'points_cost' => 50, // 50 điểm đổi lấy giảm 10%
        'expires_at' => '2027-12-31 00:00:00',
    ]
);

\App\Models\Voucher::updateOrCreate(
    ['code' => 'REWARD50K'],
    [
        'type' => 'fixed',
        'value' => 50000,
        'min_order_amount' => 200000,
        'max_uses' => 200,
        'uses' => 0,
        'is_active' => true,
        'points_cost' => 100, // 100 điểm đổi lấy giảm 50k
        'expires_at' => '2027-12-31 00:00:00',
    ]
);

\App\Models\Voucher::updateOrCreate(
    ['code' => 'REWARD100K'],
    [
        'type' => 'fixed',
        'value' => 100000,
        'min_order_amount' => 350000,
        'max_uses' => 100,
        'uses' => 0,
        'is_active' => true,
        'points_cost' => 180, // 180 điểm đổi lấy giảm 100k
        'expires_at' => '2027-12-31 00:00:00',
    ]
);

echo "Redeemable vouchers seeded successfully!\n";

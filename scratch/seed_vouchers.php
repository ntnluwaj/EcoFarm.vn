<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

\App\Models\Voucher::updateOrCreate(
    ['code' => 'ECF10'],
    [
        'type' => 'percent',
        'value' => 10,
        'min_order_amount' => 100000,
        'max_uses' => 50,
        'is_active' => true,
        'expires_at' => '2027-12-31 00:00:00'
    ]
);

\App\Models\Voucher::updateOrCreate(
    ['code' => 'GIAM50K'],
    [
        'type' => 'fixed',
        'value' => 50000,
        'min_order_amount' => 200000,
        'max_uses' => 100,
        'is_active' => true,
        'expires_at' => '2027-12-31 00:00:00'
    ]
);

echo "Vouchers seeded successfully!\n";

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLog extends Model
{
    use HasFactory;

    protected $table = 'order_logs'; // Tên bảng theo tài liệu PRD [cite: 450]

    public $timestamps = false; // Bảng dùng cột log_time riêng [cite: 450]

    protected $fillable = [
        'order_id',
        'status',
        'changed_by',
        'log_time',
    ];

    protected $casts = [
        'log_time' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($log) {
            $log->log_time = now(); // Ghi nhận thời gian thực tự động [cite: 450]
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
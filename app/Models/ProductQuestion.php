<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductQuestion extends Model
{
    protected $fillable = ['product_id', 'user_id', 'asker_name', 'question', 'answer', 'replied_by', 'replied_at'];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('answer') && !empty($model->answer)) {
                $model->replied_by = auth()->id();
                $model->replied_at = now();

                // 🌟 THÔNG BÁO CHO NGƯỜI HỎI KHI CÓ CÂU TRẢ LỜI CỦA KỸ SƯ
                if ($model->user) {
                    try {
                        \Filament\Notifications\Notification::make()
                            ->title("Kỹ sư phản hồi câu hỏi")
                            ->body("Câu hỏi về vật tư '{$model->product->name}' của bạn đã được giải đáp.")
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->color('primary')
                            ->sendToDatabase($model->user);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Lỗi thông báo trả lời câu hỏi tới user: " . $e->getMessage());
                    }
                }
            }
        });
    }
}

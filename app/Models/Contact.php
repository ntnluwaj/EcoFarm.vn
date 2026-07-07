<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    const UPDATED_AT = null; // Tắt cột updated_at

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'subject',
        'message',
        'status',
        'reply_content',
        'replied_by',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('reply_content') && !empty($model->reply_content)) {
                $model->status = 'replied';
                $model->replied_by = auth()->id();
                $model->replied_at = now();

                // 🌟 Gửi thông báo cho Nhà vườn nếu họ có tài khoản
                if ($model->user) {
                    try {
                        \Filament\Notifications\Notification::make()
                            ->title('EcoFarm đã trả lời liên hệ!')
                            ->body("Ý kiến tư vấn về '{$model->subject}' của bạn đã được kỹ sư nông học phản hồi.")
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->color('primary')
                            ->sendToDatabase($model->user);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error("Lỗi thông báo liên hệ tới user: " . $e->getMessage());
                    }
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}

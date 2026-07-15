<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIChatLog extends Model
{
    protected $table = 'ai_chat_logs';

    protected $fillable = [
        'user_id',
        'session_id',
        'message',
        'response',
        'detected_topic',
        'sentiment',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    protected array $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->data['title'] ?? 'Thông báo',
            'body' => $this->data['body'] ?? '',
            'icon' => $this->data['icon'] ?? 'heroicon-o-bell',
            'color' => $this->data['color'] ?? 'success',
            'url' => $this->data['url'] ?? null,
        ];
    }
}

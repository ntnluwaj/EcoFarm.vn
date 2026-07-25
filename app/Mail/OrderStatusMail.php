<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $formattedId = 'ECF' . str_pad($this->order->id, 6, '0', STR_PAD_LEFT);
        
        $statusText = match($this->order->status) {
            'pending' => 'đang chờ xác nhận',
            'processing' => 'đang được đóng gói bốc xếp',
            'shipping' => 'đang được giao vận',
            'completed' => 'đã hoàn tất',
            'cancelled' => 'đã bị hủy',
            default => $this->order->status
        };

        return new Envelope(
            subject: '🔔 Cập nhật vận đơn ' . $formattedId . ' - ' . mb_convert_case($statusText, MB_CASE_TITLE, "UTF-8"),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'frontend.emails.order_status',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

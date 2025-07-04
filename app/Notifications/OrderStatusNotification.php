<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

   public function via($notifiable)
{
    return ['mail', 'database', 'nexmo', 'slack'];
}
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Order #{$this->order->id} Status Update")
            ->line("Your order status is now: {$this->order->status}");
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
        ];
    }
}

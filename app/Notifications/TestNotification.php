<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TestNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database']; // ✅ include 'mail' here
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Test Notification')
                    ->greeting('Hello!')
                    ->line('This is a test notification sent via email.')
                    ->action('Visit Website', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'This is a test notification.',
            'notified_at' => now(),
        ];
    }
}

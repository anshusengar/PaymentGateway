<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserNotification extends Notification
{
    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail']; // This ensures the notification will be sent via email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->details['subject'])
            ->line($this->details['body'])
            ->action('View', $this->details['url']);
    }

    public function toArray($notifiable)
    {
        return [
            'subject' => $this->details['subject'],
            'body' => $this->details['body'],
            'url' => $this->details['url'],
        ];
    }
}

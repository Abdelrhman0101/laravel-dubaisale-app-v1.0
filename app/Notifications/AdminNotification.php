<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     * 
     * @param array $data Contains title and description in both languages
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Fallback or optional email logic
        return (new MailMessage)
            ->subject($this->data['english']['title'] ?? 'New Notification')
            ->line($this->data['english']['description'] ?? '')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'arabic' => $this->data['arabic'] ?? [],
            'english' => $this->data['english'] ?? [],
            'type' => 'admin_notification',
            'created_at' => now(),
        ];
    }
}

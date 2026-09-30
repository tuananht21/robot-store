<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AdminMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected int $senderId;
    protected string $senderName;
    protected string $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($senderId, $senderName, $message)
    {
        $this->senderId = $senderId;
        $this->senderName = $senderName;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'sender_id' => $this->senderId,
            'sender_name' => $this->senderName,
            'message' => $this->message,
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'sender_id' => $this->senderId,
            'sender_name' => $this->senderName,
            'message' => $this->message,
        ]);
    }
}
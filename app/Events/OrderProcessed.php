<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderProcessed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $status;
    public $message;
    public $userId;

    /**
     * Create a new event instance.
     */
    public function __construct($status, $message, $userId)
    {
        //
        $this->status = $status;
        $this->message = $message;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('orders.' . $this->userId),
        ];
    }

    public function broadcastAs()
    {
        return 'OrderEvent';
    }

    public function broadcastWith(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
        ];
    }
}

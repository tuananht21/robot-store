<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserOrderBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    private $orderId;
    private $status;
    public function __construct($orderId, $status)
    {
        //
        $this->orderId = $orderId;
        $this->status = $status;
    }

    public function broadcastAs()
    {
        return 'UserOrderEvent';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user-order'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'orderId' => $this->orderId,
            'status' => $this->status,
        ];
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusBroadcast implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderId;
    public $status;
    public $message;
    public $orderStatus;
    public $userId;
    public $target;

    /**
     * Create a new event instance.
     */
    public function __construct($orderId, $status, $message, $orderStatus, $userId, $target)
    {
        $this->orderId = $orderId;
        $this->status = $status;
        $this->message = $message;
        $this->orderStatus = $orderStatus;
        $this->userId = $userId;
        $this->target = $target;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        if ($this->target === 'admin') {
            return [
                new PrivateChannel('admin.order-status')
            ];
        }

        return [
            new PrivateChannel('order-status.' . $this->userId)
        ];
    }

    public function broadcastAs()
    {
        return 'OrderStatusEvent';
    }

    public function broadcastWith(): array
    {
        return [
            'orderId' => $this->orderId,
            'status' => $this->status,
            'message' => $this->message,
            'orderStatus' => $this->orderStatus,
            'userId' => $this->userId,
        ];
    }
}

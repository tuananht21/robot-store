<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageBroadcast implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $userFromId;
    public $userToId;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($userFromId, $userToId, $message)
    {
        $this->userFromId = $userFromId;
        $this->userToId = $userToId;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('message.' . $this->userToId),
        ];
    }

    /**
     * Data sent to the frontend.
     */
    public function broadcastWith(): array
    {
        return [
            'userFromID' => $this->userFromId,
            'userToID' => $this->userToId,
            'message' => $this->message,
        ];
    }

    /**
     * Event name received by Laravel Echo.
     */
    public function broadcastAs(): string
    {
        return 'messageEvent';
    }
}
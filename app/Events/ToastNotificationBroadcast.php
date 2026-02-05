<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ToastNotificationBroadcast implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    /**
     * Create a new event instance.
     */
    public function __construct(private $text)
    {
        //
    }

    public function broadcastAs(): string
    {
        return 'notification';
    }


    public function broadcastWith()
    {
        return ['message' => $this->text];
    }


    public function broadcastOn(): array
    {
        return [
            new Channel('toast-notification'),
        ];
    }
}

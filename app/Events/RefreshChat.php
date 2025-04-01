<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RefreshChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const EVENT = 'refresh.chat';

    public function __construct(public string $channel) {}

    public function broadcastOn(): Channel
    {
        return new PresenceChannel($this->channel);
    }

    public function broadcastAs(): string
    {
        return self::EVENT;
    }
}

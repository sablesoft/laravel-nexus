<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class RefreshPlay implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    const EVENT = 'refresh.play';

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

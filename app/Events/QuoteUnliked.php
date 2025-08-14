<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuoteUnliked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $quote_id;

    public int $likes_count;

    public function __construct(int $quote_id, int $likes_count)
    {
        $this->quote_id = $quote_id;
        $this->likes_count = $likes_count;

        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('quote-like'),
        ];
    }
}

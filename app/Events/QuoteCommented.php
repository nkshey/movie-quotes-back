<?php

namespace App\Events;

use App\Http\Resources\CommentResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuoteCommented implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $quote_id;

    public int $comments_count;

    public CommentResource $comment;

    public function __construct(int $quote_id, int $comments_count, CommentResource $comment)
    {
        $this->quote_id = $quote_id;
        $this->comments_count = $comments_count;
        $this->comment = $comment;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('quote-comment'),
        ];
    }
}

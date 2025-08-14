<?php

use App\Broadcasting\CommentChannel;
use App\Broadcasting\LikeChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('quote-like', LikeChannel::class);
Broadcast::channel('quote-comment', CommentChannel::class);

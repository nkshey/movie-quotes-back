<?php

use App\Broadcasting\CommentChannel;
use App\Broadcasting\LikeChannel;
use App\Broadcasting\NotificationChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('quote-like', LikeChannel::class);
Broadcast::channel('quote-comment', CommentChannel::class);
Broadcast::channel('notifications.{userId}', NotificationChannel::class);

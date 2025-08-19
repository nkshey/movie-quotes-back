<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Events\QuoteCommented;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        $comment = Comment::create([
            'user_id'  => $user->id,
            'quote_id' => $data['quote_id'],
            'body'     => $data['body'],
        ]);

        $comment->load(['user', 'quote']);
        $quote = $comment->quote;

        $comments_count = Comment::where('quote_id', $data['quote_id'])->count();

        broadcast(new QuoteCommented(
            $data['quote_id'],
            $comments_count,
            new CommentResource($comment)
        ));

        if ($quote->user_id !== $user->id) {
            Notification::create([
                'user_id'   => $quote->user_id,
                'sender_id' => $user->id,
                'quote_id'  => $quote->id,
                'type'      => 'comment',
                'read'      => false,
            ]);

            broadcast(new NotificationEvent($quote->user_id));
        }

        return response()->json(['message' => 'Commented successfully'], 201);
    }
}

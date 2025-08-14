<?php

namespace App\Http\Controllers;

use App\Events\QuoteCommented;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        $comment = Comment::create([
            'user_id'  => $user->id,
            'quote_id' => $data['quote_id'],
            'body'     => $data['body'],
        ]);

        $comment->load('user');

        $comments_count = Comment::where('quote_id', $data['quote_id'])->count();

        broadcast(new QuoteCommented(
            $data['quote_id'],
            $comments_count,
            new CommentResource($comment)
        ));

        return new CommentResource($comment);
    }
}

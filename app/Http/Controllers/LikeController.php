<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Events\QuoteLiked;
use App\Events\QuoteUnliked;
use App\Http\Requests\StoreLikeRequest;
use App\Models\Like;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        $like = Like::firstOrCreate([
            'user_id'  => $user->id,
            'quote_id' => $data['quote_id'],
        ]);

        $like->load('quote');
        $quote = $like->quote;

        $likes_count = Like::where('quote_id', $data['quote_id'])->count();

        broadcast(new QuoteLiked($data['quote_id'], $likes_count));

        if ($quote->user_id !== $user->id) {
            Notification::create([
                'user_id'   => $quote->user_id,
                'sender_id' => $user->id,
                'quote_id'  => $quote->id,
                'type'      => 'like',
                'read'      => false,
            ]);

            broadcast(new NotificationEvent($quote->user_id));
        }

        return response()->json(['message' => 'Liked successfully']);
    }

    public function destroy(int $quote_id): JsonResponse
    {
        $user = Auth::user();

        Like::where('user_id', $user->id)
            ->where('quote_id', $quote_id)
            ->delete();

        $likes_count = Like::where('quote_id', $quote_id)->count();

        broadcast(new QuoteUnliked($quote_id, $likes_count));

        return response()->json(['message' => 'Unliked successfully']);
    }
}

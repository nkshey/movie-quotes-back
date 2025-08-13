<?php

namespace App\Http\Controllers;

use App\Events\QuoteLiked;
use App\Events\QuoteUnliked;
use App\Http\Requests\StoreLikeRequest;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        Like::firstOrCreate([
            'user_id'  => $user->id,
            'quote_id' => $data['quote_id'],
        ]);

        $likes_count = Like::where('quote_id', $data['quote_id'])->count();

        broadcast(new QuoteLiked($data['quote_id'], $likes_count))->toOthers();

        return response()->json(['message' => 'Liked successfully']);
    }

    public function destroy(int $quote_id): JsonResponse
    {
        $user = Auth::user();

        Like::where('user_id', $user->id)
            ->where('quote_id', $quote_id)
            ->delete();

        $likes_count = Like::where('quote_id', $quote_id)->count();

        broadcast(new QuoteUnliked($quote_id, $likes_count))->toOthers();

        return response()->json(['message' => 'Unliked successfully']);
    }
}

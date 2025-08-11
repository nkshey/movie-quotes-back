<?php

namespace App\Http\Controllers;

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

        return response()->json(['message' => 'Liked successfully']);
    }

    public function destroy(int $quote_id): JsonResponse
    {
        $user = Auth::user();

        Like::where('user_id', $user->id)
            ->where('quote_id', $quote_id)
            ->delete();

        return response()->json(['message' => 'Unliked successfully']);
    }
}

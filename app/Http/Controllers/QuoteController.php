<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class QuoteController extends Controller
{
    public function quotesByMovie(Movie $movie): JsonResponse
    {
        $quotes = Quote::where('movie_id', $movie->id)->get();

        return response()->json(QuoteResource::collection($quotes));
    }

    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        $quote = Quote::create([
            'user_id'  => $user->id,
            'movie_id' => $data['movie_id'],
            'text'     => $data['text'],
        ]);

        if ($request->hasFile('image')) {
            $quote->addMediaFromRequest('image')->toMediaCollection('quotes');
        }

        return response()->json(['message' => 'Quote stored successfully']);
    }

    public function destroy(Quote $quote): JsonResponse
    {
        Gate::authorize('delete', $quote);

        $quote->clearMediaCollection('quotes');
        $quote->delete();

        return response()->json(['message' => 'Quote deleted successfully']);
    }
}

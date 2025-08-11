<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteCollection;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class QuoteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');

        $quotes = QueryBuilder::for(Quote::class)
            ->with(['user', 'movie', 'comments.user', 'likes'])
            ->withCount(['comments', 'likes'])
            ->search($search)
            ->latest()
            ->paginate(9);

        return response()->json(new QuoteCollection($quotes));
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

    public function update(UpdateQuoteRequest $request, Quote $quote): JsonResponse
    {
        Gate::authorize('update', $quote);

        $data = $request->validated();

        $quote->update(['text' => $data['text']]);

        if ($request->hasFile('image')) {
            $quote->clearMediaCollection('quotes');
            $quote->addMediaFromRequest('image')->toMediaCollection('quotes');
        }

        return response()->json(['message' => 'Quote updated successfully']);
    }

    public function destroy(Quote $quote): JsonResponse
    {
        Gate::authorize('delete', $quote);

        $quote->clearMediaCollection('quotes');
        $quote->delete();

        return response()->json(['message' => 'Quote deleted successfully']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieListResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index(): JsonResponse
    {
        $movies = Auth::user()->movies;

        return response()->json(MovieListResource::collection($movies));
    }

    public function show(int $id): JsonResponse
    {
        $movie = Auth::user()->movies()->findOrFail($id);

        return response()->json(new MovieResource($movie));
    }

    public function store(StoreMovieRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        $movie = Movie::create([
            'user_id'     => $user->id,
            'title'       => $data['title'],
            'description' => $data['description'],
            'director'    => $data['director'],
            'year'        => $data['year'],
        ]);

        $movie->genres()->attach($data['genres']);

        if ($request->hasFile('image')) {
            $movie->addMediaFromRequest('image')->toMediaCollection('posters');
        }

        return response()->json(['message' => 'Movie stored successfully']);
    }

    public function update(UpdateMovieRequest $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $movie = $user->movies()->findOrFail($id);
        $data = $request->validated();

        $movie->update([
            'title'       => $data['title'],
            'description' => $data['description'],
            'director'    => $data['director'],
            'year'        => $data['year'],
        ]);

        $movie->genres()->sync($data['genres']);

        if ($request->hasFile('image')) {
            $movie->clearMediaCollection('posters');
            $movie->addMediaFromRequest('image')->toMediaCollection('posters');
        }

        return response()->json(['message' => 'Movie updated successfully']);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = Auth::user();
        $movie = $user->movies()->findOrFail($id);

        $movie->clearMediaCollection('posters');
        $movie->genres()->detach();
        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully']);
    }
}

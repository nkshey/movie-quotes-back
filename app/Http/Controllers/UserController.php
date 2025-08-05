<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json(new UserResource(Auth::user()));
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        if (isset($data['username'])) {
            $user->username = $data['username'];
        }

        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        if ($request->hasFile('avatar')) {
            $user->clearMediaCollection('avatars');
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        $user->save();

        return response()->json(['message' => 'Update successful']);
    }
}

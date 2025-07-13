<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create($data);

        event(new Registered($user));

        return response()->json([
            'status' => 'registration_pending_verification',
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $input = $request->only('login', 'password');
        $remember = $request->boolean('remember');

        $field = filter_var($input['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field     => $input['login'],
            'password' => $input['password'],
        ];

        if (! Auth::attempt($credentials, $remember)) {
            return response()->json(['message' => __('auth.login_invalid')], 401);
        }

        if (! Auth::user()->hasVerifiedEmail()) {
            Auth::logout();

            return response()->json(['message' => __('auth.email_not_verified')], 403);
        }

        $request->session()->regenerate();

        return response()->json(['message' => 'Login successful']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request): string
    {
        $locale = $request->query('locale', 'en');
        session(['locale' => $locale]);

        return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    }

    public function callback(): JsonResponse
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'username'          => $googleUser->name,
            'email'             => $googleUser->email,
            'avatar'            => $googleUser->avatar,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        $locale = session('locale', 'en');

        return response()->json([
            'message' => 'Google authentication successful',
            'locale' => $locale,
        ]);
    }
}

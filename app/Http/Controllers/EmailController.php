<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;

class EmailController extends Controller
{
    public function verify(string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return response()->json(['status' => 'email_already_verified'], 409);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(['status' => 'email_verification_successful'], 200);
    }
}

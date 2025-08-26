<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ValidateResetTokenRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $email = $request->only('email');
        $user = User::whereEmail($email)->first();

        if (! $user->hasVerifiedEmail()) {
            return response()->json(['message' => __('auth.email_not_verified')], 403);
        }

        if ($user->google_id) {
            return response()->json(['message' => __('passwords.google_user_cannot_reset_password')], 403);
        }

        $status = Password::sendResetLink($email);

        if ($status === Password::ResetThrottled) {
            return response()->json(['message' => trans('passwords.throttled', ['seconds' => 60])], 429);
        }

        return response()->json(['status' => 'password_reset_link_sent']);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $request->validated();

        Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function validateResetToken(ValidateResetTokenRequest $request): JsonResponse
    {
        $token = $request->input('token');
        $email = $request->input('email');
        $user = User::whereEmail($email)->first();

        $status = Password::getRepository()->exists($user, $token);

        if (! $status) {
            return response()->json(['status' => 'invalid_password_link_or_expired_token'], 422);
        }

        return response()->json(['message' => 'Reset password validated successfully']);
    }
}

<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements CanResetPassword, HasMedia, MustVerifyEmail
{
    use HasApiTokens, HasFactory, InteractsWithMedia, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail(app()->getLocale()));
    }

    public function sendPasswordResetNotification($token)
    {
        $locale = app()->getLocale();
        $this->notify(new PasswordReset($token, $locale));
    }

    public function getAvatarAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatars') ?: null;
    }

    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
}

<?php

namespace App\Broadcasting;

use App\Models\User;

class NotificationChannel
{
    public function join(User $user, int|string $userId): array|bool
    {
        return (int) $user->id === (int) $userId;
    }
}

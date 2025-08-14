<?php

namespace App\Broadcasting;

use App\Models\User;

class LikeChannel
{
    public function join(User $user): array|bool
    {
        return (bool) $user;
    }
}

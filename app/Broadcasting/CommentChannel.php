<?php

namespace App\Broadcasting;

use App\Models\User;

class CommentChannel
{
    public function join(User $user): array|bool
    {
        return (bool) $user;
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'email'       => $this->email,
            'username'    => $this->username,
            'avatar'      => $this->avatar,
            'google_user' => (bool) $this->google_id,
        ];
    }
}

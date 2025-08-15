<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'quote_id' => $this->quote_id,
            'sender'   => [
                'id'       => $this->sender->id,
                'username' => $this->sender->username,
                'avatar'   => $this->sender->avatar,
            ],
            'type'       => $this->type,
            'read'       => $this->read,
            'created_at' => $this->created_at,
        ];
    }
}

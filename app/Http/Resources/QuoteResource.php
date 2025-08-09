<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'text'           => $this->text,
            'image'          => $this->image,
            'movie'          => new MovieSummaryResource($this->whenLoaded('movie')),
            'user'           => new UserResource($this->whenLoaded('user')),
            'comments'       => CommentResource::collection($this->whenLoaded('comments')),
            'comments_count' => $this->whenCounted('comments'),
            'likes_count'    => $this->whenCounted('likes'),
            'liked_by_user'  => $this->likes->contains('user_id', $request->user()->id),
        ];
    }
}

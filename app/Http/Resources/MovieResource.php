<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'director'    => $this->director,
            'year'        => $this->year,
            'image'       => $this->image,
            'genres'      => $this->genres,
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title.en'       => ['required', 'string'],
            'title.ka'       => ['required', 'string'],
            'description.en' => ['required', 'string'],
            'description.ka' => ['required', 'string'],
            'director.en'    => ['required', 'string'],
            'director.ka'    => ['required', 'string'],
            'year'           => ['required', 'integer'],
            'genres'         => ['required', 'array'],
            'image'          => ['sometimes', 'image', 'max:' . config('validation.image_max_size')],
        ];
    }
}

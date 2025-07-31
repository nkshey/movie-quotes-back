<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
            'image'          => ['required', 'file', 'mimes:jpg,jpeg,png,webp'],
        ];
    }
}

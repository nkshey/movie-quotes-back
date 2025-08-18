<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'text.en'  => ['required', 'string'],
            'text.ka'  => ['required', 'string'],
            'movie_id' => ['required', 'integer', 'exists:movies,id'],
            'image'    => ['sometimes', 'image', 'max:' . config('validation.image_max_size')],
        ];
    }
}

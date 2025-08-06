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
            'image'    => ['sometimes', 'image'],
            'movie_id' => ['required', 'integer', 'exists:movies,id'],
        ];
    }
}

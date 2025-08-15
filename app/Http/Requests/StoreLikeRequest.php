<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLikeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quote_id' => ['required', 'exists:quotes,id'],
        ];
    }

    public function messages()
    {
        return [
            'quote_id.exists' => 'quote_does_not_exist',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'body'     => ['required', 'string'],
            'quote_id' => ['required', 'integer', 'exists:quotes,id'],
        ];
    }


    public function messages(): array
    {
        return [
            'quote_id.exists' => 'quote_does_not_exist',
        ];
    }
}

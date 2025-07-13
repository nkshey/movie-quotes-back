<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login'    => 'required|min:3',
            'password' => 'required',
            'remember' => 'sometimes|boolean',
        ];
    }
}

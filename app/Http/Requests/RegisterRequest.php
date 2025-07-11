<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|lowercase|alpha_num|min:3|max:15|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|lowercase|alpha_num|confirmed|min:8|max:15',
        ];
    }
}

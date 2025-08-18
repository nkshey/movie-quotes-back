<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['sometimes', 'lowercase', 'alpha_num', 'min:3', 'max:15', 'unique:users,username'],
            'password' => ['sometimes', 'lowercase', 'alpha_num', 'confirmed', 'min:8', 'max:15'],
            'avatar'   => ['sometimes', 'image', 'max:' . config('validation.user_avatar_max_size')],
        ];
    }

    public function messages(): array
    {
        return [
            'username.unique' => __('validation.username_unique'),
        ];
    }
}

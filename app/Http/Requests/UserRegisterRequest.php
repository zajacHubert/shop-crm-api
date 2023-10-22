<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|min:4|max:50',
            'last_name' => 'required|min:4|max:50',
            'email' => 'required|email|unique:users|min:4|max:100',
            'password' => 'required|min:4|max:100',
        ];
    }
}

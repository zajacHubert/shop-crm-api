<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'string|min:4|max:50',
            'last_name' => 'string|min:4|max:50',
            'email' => 'email|min:4|max:100',
        ];
    }
}

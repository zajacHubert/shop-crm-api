<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'string|min:4|max:50',
            'description' => 'string|min:4|max:200',
            'price' => 'numeric|between:0.01,99999.99',
            'image' => 'image|mimes:jpeg,png',
            'category_id' => 'uuid|exists:categories,id',
        ];
    }
}

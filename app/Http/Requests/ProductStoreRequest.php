<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'string|required|min:4|max:50',
            'description' => 'string|required|min:4|max:200',
            'price' => 'required|numeric|between:0.01,99999.99',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp',
            'category_id' => 'required|uuid|exists:categories,id',
        ];
    }
}

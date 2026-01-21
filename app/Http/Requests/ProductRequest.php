<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'slug' => [
            'nullable',
            'string',
            'max:255',
            Rule::unique('products', 'slug')->ignore($this->id),
        ],
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'discount_price'    => 'nullable|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'status'            => 'required|integer|in:0,1',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ];
    }
}

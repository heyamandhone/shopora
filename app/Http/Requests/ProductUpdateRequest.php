<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($this->route('product')),
            ],
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($this->route('product')),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'sale_price' => ['nullable', 'numeric'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
        ];
    }
}

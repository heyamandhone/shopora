<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:150',
                'unique:brands,name,' . $this->brand->id,
            ],

            'slug' => [
                'required',
                'string',
                'max:180',
                'unique:brands,slug,' . $this->brand->id,
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'logo' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'boolean',
            ],

            'sort_order' => [
                'nullable',
                'integer',
            ],

            'seo_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'seo_description' => [
                'nullable',
                'string',
            ],
        ];
    }
}

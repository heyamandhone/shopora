<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BrandStoreRequest extends FormRequest
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
                'unique:brands,name',
            ],

            'slug' => [
                'required',
                'string',
                'max:180',
                'unique:brands,slug',
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

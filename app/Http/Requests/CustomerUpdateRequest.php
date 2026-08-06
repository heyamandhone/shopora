<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['nullable', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255', Rule::unique('customers', 'email')->ignore($this->route('customer'))],
            'phone' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:20'],
            'is_active' => ['required', 'boolean'],
            'email_verified_at' => ['nullable', 'date'],
        ];
    }
}

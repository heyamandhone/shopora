<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_number' => ['required', 'string', 'max:100', Rule::unique('orders', 'order_number')->ignore($this->route('order'))],
            'customer_id' => ['required', 'exists:customers,id'],
            'subtotal' => ['required', 'numeric'],
            'discount' => ['nullable', 'numeric'],
            'tax' => ['nullable', 'numeric'],
            'shipping_charge' => ['nullable', 'numeric'],
            'total' => ['required', 'numeric'],
            'status' => ['required', 'in:pending,processing,shipped,delivered,cancelled'],
            'payment_status' => ['required', 'in:pending,paid,failed,refunded'],
            'notes' => ['nullable', 'string'],
        ];
    }
}

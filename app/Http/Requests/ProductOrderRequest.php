<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|integer',
            'currency' => 'required|string|max:10',
            'type' => 'nullable|string|max:20',
            'tax_amount' => 'nullable|numeric',
            'total_amount' => 'required|numeric',
            'user_id' => 'required|integer',
            'billing_email' => 'nullable|string|email|max:320',
            'payment_method' => 'nullable|string|max:100',
            'payment_method_title' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.order_item_name' => 'required|string',
            'items.*.order_item_type' => 'required|string',
        ];
    }
}

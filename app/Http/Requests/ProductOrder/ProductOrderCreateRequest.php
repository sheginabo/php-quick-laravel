<?php

namespace App\Http\Requests\ProductOrder;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductOrderCreateRequest extends FormRequest
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
            'currency' => 'required|string|max:10',
            'type' => 'nullable|string|max:20',
            'tax_amount' => 'nullable|numeric',
            'total_amount' => 'required|numeric',
            'billing_email' => 'nullable|string|email|max:100',
            'payment_method' => 'nullable|string|max:100',
            'payment_method_title' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.order_item_quantity' => 'required|integer|min:1',
            'items.*.order_item_name' => 'required|string',
            'items.*.order_item_type' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'items.*.order_item_quantity' => '產品數量必須大於 0',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'result' => 'failed',
            'detail' => $validator->errors(),
        ], 400));
    }
}

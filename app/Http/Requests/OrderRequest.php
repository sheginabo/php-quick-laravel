<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
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
            'id' => 'required|string',
            'name' => 'required|string|max:255',
            'address.city' => 'required|string',
            'address.district' => 'required|string',
            'address.street' => 'required|string',
            'price' => 'required|numeric',
            'currency' => 'required|in:TWD,USD',
        ];
    }

    public function messages()
    {
        return [
            'currency.in' => 'Currency format is wrong',
            'price.numeric' => 'Price format is wrong',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'result' => 'failed',
            'detail' => $validator->errors(),
        ], 400));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => is_numeric($this->price) ? (integer) $this->price : $this->price,
        ]);
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BnbOrderRequest extends FormRequest
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
            'name' => [
                'required',
                'regex:/^[A-Z][a-z]*(\s[A-Z][a-z]*)*$/',
            ],
            'address.city' => 'required|string',
            'address.district' => 'required|string',
            'address.street' => 'required|string',
            'price' => ['required', 'numeric', 'max:2000'],
            'currency' => ['required', 'in:TWD,USD'],
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages()
    {
        return [
            'name.regex' => 'Name contains non-English characters or is not capitalized',
            'currency.in' => 'Currency format is wrong',
            'price.numeric' => 'Price format is wrong',
            'price.max' => 'Price is over 2000',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'result' => 'failed',
            'detail' => $validator->errors(),
        ], 400));
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => is_numeric($this->price) ? intval($this->price) : $this->price,
        ]);
    }
}

<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => [
                'required',
                'string',
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名稱為必填項',
            'email.required' => '電子郵件為必填項',
            'email.max' => '電子郵件長度太長',
            'password.required' => '密碼為必填項',
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

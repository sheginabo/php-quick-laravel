<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // unique:users checks the email field of the users table
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers()->symbols(), // ['min:8', 'mixed_case', 'numbers', 'symbols']
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名稱為必填項',
            'email.required' => '電子郵件為必填項',
            'email.max' => '電子郵件長度太長',
            'email.unique' => '電子郵件已被使用',
            'password.required' => '密碼為必填項',
            'password.min' => '密碼長度太短',
            'password.mixed' => '密碼必須包含大小寫字母',
            'password.numbers' => '密碼必須包含數字',
            'password.symbols' => '密碼必須包含符號',
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

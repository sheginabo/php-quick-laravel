<?php

namespace App\Services;

use App\Exceptions\Auth\LoginException;
use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public function register(array $input): string
    {
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        return $user->createToken('auth_token')->plainTextToken;
    }

    /**
     * @throws LoginException
     */
    public function login(array $input): string
    {
        $user = User::where('email', $input['email'])->first();

        if (!$user) {
            Log::info('[AuthService_login] User not found');
            throw new LoginException('User not found', 404);
        }

        // Auth::attempt($input) 成功會背後執行 Auth::login($user) 這個方法
        if (!Auth::attempt($input)) {
            Log::info('[AuthService_login] Invalid credentials');
            throw new LoginException('Invalid credentials', 401);
        }

        $user = Auth::user();
        // 刪除該用戶的舊 Token（可選）
        $user->tokens()->delete();

        // 檢查是否已經有有效 Token, plainTextToken 是無法被重新創造的
//        $existingToken = $user->tokens()
//            ->where('name', 'auth_token')
//            ->where('expires_at', '>', Carbon::now())
//            ->first();
//
//
//        if ($existingToken) {
//            return $existingToken->plainTextToken;
//        }

        // 創建新的 Token 並設置有效期（例如 7 天）
        return $user->createToken('auth_token', ['*'], now()->addDays(2))->plainTextToken;
    }
}

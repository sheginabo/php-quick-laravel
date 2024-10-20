<?php

namespace App\Http\Controllers;

use App\Exceptions\Auth\LoginException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Auth\RegisterResource;
use App\Services\AuthService;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $token = $this->authService->register($request->validated());

        return (new RegisterResource($request, $token))->response()->setStatusCode(ResponseAlias::HTTP_CREATED);
    }

    /**
     * @throws LoginException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());

        return (new LoginResource($request, $token))->response()->setStatusCode(ResponseAlias::HTTP_OK);
    }

    public function logout(Request $request): JsonResponse
    {
        // 通過 Illuminate\Http\Request 類來獲取當前已通過身份驗證的用戶, 與直接調用 Auth::user() 的效果是一樣的
        // $request->user()->tokens()->delete(); // 完全登出
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}

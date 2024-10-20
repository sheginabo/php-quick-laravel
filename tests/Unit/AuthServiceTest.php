<?php

namespace Tests\Unit;

use App\Exceptions\Auth\LoginException;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = $this->app->make(AuthService::class);
    }

    public function testRegister()
    {
        $input = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $token = $this->authService->register($input);

        $this->assertNotEmpty($token);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function testLoginSuccess()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $input = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $token = $this->authService->login($input);

        $this->assertNotEmpty($token);
    }

    public function testLoginUserNotFound()
    {
        $this->expectException(LoginException::class);
        $this->expectExceptionMessage('User not found');

        $input = [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ];

        $this->authService->login($input);
    }

    public function testLoginInvalidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->expectException(LoginException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $input = [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ];

        $this->authService->login($input);
    }
}

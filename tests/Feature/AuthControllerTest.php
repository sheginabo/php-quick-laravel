<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        $response = $this->postJson('/api/user/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '@Aa12345678',
            //'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['token']);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function testLoginSuccess()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('@Aa12345678'),
        ]);

        $response = $this->postJson('/api/user/login', [
            'email' => 'test@example.com',
            'password' => '@Aa12345678',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function testLoginUserNotFound()
    {
        $response = $this->postJson('/api/user/login', [
            'email' => 'nonexistent@example.com',
            'password' => '@Aa12345678',
        ]);

        $response->assertStatus(404)
            ->assertJson(['message' => 'User not found']);
    }

    public function testLoginInvalidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('@Aa12345678'),
        ]);

        $response = $this->postJson('/api/user/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid credentials']);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->postJson('/api/user/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully']);
    }
}

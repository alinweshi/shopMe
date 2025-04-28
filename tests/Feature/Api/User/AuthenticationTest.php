<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;


class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function user_can_login_with_valid_credentials()
    {
        // Arrange: Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'), // Hash the password
        ]);

        // Act: Send a login request
        $response = $this->postJson('/api/users/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
        dd($response->json());

        // Assert: Check response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'user',
                'access_token',
            ]);

        // Assert: Ensure the token is created
        $this->assertNotNull($user->tokens);
    }

    public function user_cannot_login_with_invalid_credentials()
    {
        // Arrange: Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Act: Send a login request with wrong password
        $response = $this->postJson('/api/users/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // Assert: Ensure login fails
        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Invalid Credentials',
            ]);
    }

    public function test_user_cannot_login_with_non_existent_email()
    {
        $response = $this->postJson('/api/users/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'error' => 'Invalid Credentials',
            ]);
    }
    public function test_user_cannot_login_with_invalid_format_email()
    {
        $response = $this->postJson('/api/users/login', [
            'email' => 'invalid-email',

            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
    public function test_validation_errors_for_login()
    {
        // Test invalid email format
        $this->postJson('/api/users/login', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

        // Test missing email
        $this->postJson('/api/users/login', [
            'password' => 'password123',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

        // Test missing password
        $this->postJson('/api/users/login', [
            'email' => 'valid@example.com',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }
    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user->createToken('test-token')->plainTextToken,
        ])->postJson('/api/users/logout');

        $response->assertStatus(200) //not  201 because there is no return value 
            ->assertJson([
                'message' => 'logged out',
            ]);
        $response->dumpHeaders();

        $response->dumpSession();

        $response->dump();
        $response->dd();
        $response->ddHeaders();
        $response->ddBody();
        $response->ddJson();
        $response->ddSession();
    }
}

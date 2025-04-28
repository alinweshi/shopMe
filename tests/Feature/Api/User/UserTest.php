<?php

namespace Tests\Feature\Api\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends \Tests\TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::factory()->create(
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'QpP0t@example.com',
                'password' => 'password', // Only include the password field
                'phone' => '+1-979-589-4161',
                'image' => 'uploads/1.jpg',
            ]
        );

        $this->assertModelExists($user);
    }
    public function test_user_can_register()
    {
        $user = User::factory()->create(
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'QpP0t@example.com',
                'password' => 'password', // Only include the password field
                // 'phone' => '+1-979-589-4161',
                // 'image' => 'uploads/1.jpg',
            ]
        );

        $this->assertModelExists($user);
    }
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $this->withoutMiddleware(); // Bypass middleware for test

        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/users/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);


        // $response->dump(); // See full response

        $response->assertStatus(200)
            ->assertJsonStructure(['success', 'user', 'access_token']);
    }
}

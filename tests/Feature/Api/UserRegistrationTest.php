<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationTest extends TestCase
{

    use RefreshDatabase;

    public function test_Api_user_registration()
    {
        $response = $this->postJson('api/users/register', [
            'first_name' => 'ali',
            'last_name' => 'nweshi',
            'email' => 'alinweshi@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User created successfully',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
        ]);
    }
}

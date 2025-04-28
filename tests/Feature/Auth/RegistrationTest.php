<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password@A123',
            'password_confirmation' => 'password@A123',
        ]);

        $response->assertSessionHasNoErrors();

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);
        $this->assertAuthenticatedAs($user);
        $response->assertSessionHas('success', $value = null);

        $response->assertRedirect(route('main'));
    }
    public function test_users_cannot_register_with_invalid_password_format(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['password']);
        $response->assertInvalid([
            'password'
        ]);
    }
    public function test_users_cannot_register_with_invalid_inputs(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test',
            'password' => 'password@123A',
            'password_confirmation' => 'password123A',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $response->assertInvalid([
            'password',
            'email'
        ]);
    }
}

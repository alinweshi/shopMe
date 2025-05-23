<?php

namespace Tests\Feature\Auth;

use Hash;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Vite;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        // Properly mock Vite first
        Vite::shouldReceive('asset')
            ->andReturn('http://localhost:3000/resources/css/app.css');

        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create(
            [
                'first_name' => 'Almas',
                'last_name' => 'Almas',
                'email' => 'TgY7f@example.com',
                'password' => Hash::make('Almas@#$9876543210'),
            ]
        );
        // dd($user);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Almas@#$9876543210',
        ]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirectToRoute('main');
    }
    #[Test]

    public function UserCannotLoginWithWrongPassword(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
    public function test_users_cannot_login_with_invalid_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => 'password',
        ]);
        // $this->assertInvalidCredentials(['email']);
        // $response->assertSessionHasErrors([
        //     'email' => 'Invalid Credentials'
        // ]);
        // $response->assertSessionHasErrors([
        //     'name' => 'The given name was invalid.'
        // ]);
        $response->assertInvalid([
            // 'name' => 'The name field is required.',
            'email'
        ]);
        // $response->assertInvalid(['email' => 'Invalid Credentials']);
        $this->assertGuest();
    }
    public function test_users_cannot_login_with_invalid_password_format(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        // $response->assertSessionHasNoErrors();

        $response->assertSessionHasErrors(['password']);
        $response->assertInvalid([
            // 'email',
            // 'password'
        ]);
    }




    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}

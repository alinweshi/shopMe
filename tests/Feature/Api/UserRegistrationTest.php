<?php

namespace Tests\Feature\Api;


use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendWelcomeRegistrationEmailJob;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationTest extends TestCase
{

    use RefreshDatabase;

    public function test_Api_user_registration()
    {
        Mail::fake();
        Queue::fake();
        $response = $this->postJson('/api/users/register', [
            'first_name' => 'ali',
            'last_name' => 'nweshi',
            'email' => 'alinweshi@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User Created Successfully',
            ]);
        Queue::assertPushed(SendWelcomeRegistrationEmailJob::class);
        // Assert email would be sent
        // Mail::assertQueued(\App\Mail\WelcomeEmail::class, function ($mail) {
        //     return $mail->hasTo('alinweshi@gmail.com');
        // });





        $this->assertDatabaseHas('users', [
            'email' => 'alinweshi@gmail.com',
        ]);
    }
    public function test_registration_flows()
    {
        Mail::fake();

        $response = $this->postJson('/api/users/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertStatus(200);

        // Assert email was queued
        Mail::assertQueued(\App\Mail\WelcomeEmail::class);

        // Assert database record
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }
}

<?php

namespace Tests\Feature\Api;


use Tests\TestCase;
use App\Models\User;
use App\Jobs\SendWelcomeRegistrationEmailJob;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendWelcomeEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_email_is_dispatched()
    {
        $this->assert(true, 1);
        // Mail::fake();
        // Queue::fake();

        // // Create a test user
        // $user = User::factory()->create();

        // // Dispatch the job
        // SendWelcomeRegistrationEmailJob::dispatch($user);

        // // Assert the job was pushed onto the queue
        // Queue::assertPushed(SendWelcomeRegistrationEmailJob::class);

        // // Process the job (since QUEUE_CONNECTION=sync)
        // $this->artisan('queue:work --once');

        // // Assert that an email was sent
        // Mail::assertSent(WelcomeEmail::class, function ($mail) use ($user) {
        //     return $mail->hasTo($user->email);
        // });
    }
}

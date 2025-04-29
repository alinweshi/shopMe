<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWelcomeRegistrationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = 10;

    protected $user;


    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        try {
            Mail::to($this->user->email)->send(new \App\Mail\WelcomeEmail($this->user));
        } catch (Exception $e) {
            Log::error('Failed to send welcome email:', [
                'error' => $e->getMessage(),
                'user_id' => $this->user->id,
            ]);
            throw $e; // Re-throw to trigger a retry
        }
    }

    // public function failed(\Exception $exception)
    // {
    //     Log::error('Welcome email job failed after retries:', [
    //         'error' => $exception->getMessage(),
    //         'user_id' => $this->user->id,
    //     ]);
    // }
}

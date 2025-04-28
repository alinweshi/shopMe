<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSubscriptionExpirationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = 10;
    /**
     * Create a new job instance.
     */
    public $customerId;
    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info('inside SendSubscriptionExpirationMailJob');

        // Fetch the customer by ID
        $customer = Customer::find($this->customerId);
        // dd($customer);

        if (!$customer) {
            logger()->error("Customer with ID {$this->customerId} not found.");
            return;
        }

        // Send the subscription expiration email
        $customer->sendSubscriptionExpirationEmail($customer->subscriptionEndDate());
        // dd($customer->sendSubscriptionExpirationEmail($customer->subscriptionEndDate()));

        info("Subscription expiration email sent to customer: {$customer->email}");
        info("Subscription expiration date: {$customer->subscriptionEndDate}");
    }
}

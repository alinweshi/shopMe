<?php

namespace App\Console\Commands;

use App\Jobs\SendSubscriptionExpirationMailJob;
use App\Models\Customer;
use Illuminate\Console\Command;

class SubscriptionExpiryNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:subscription-expiry-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the subscription of customer expires';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Use the Eloquent model to apply query scopes
        $customers = Customer::select('id', 'first_name', 'last_name', 'email', 'subscription_end_date')
            // ->active() // Apply the active scope
            ->subscriptionEndDate() // Apply the subscriptionEndDate scope
            ->orderBy('first_name', 'asc')
            ->get();

        if ($customers->count() > 0) {
            foreach ($customers as $customer) {
                $this->info("Customer: {$customer->first_name} {$customer->last_name} - {$customer->email}");
                // Dispatch the job to send emails for each customer
                dispatch(new SendSubscriptionExpirationMailJob($customer->id))->onQueue('email');
                $this->info('done');
            }
        } else {
            $this->info('No customers with expiring subscriptions found.');
        }
    }
}

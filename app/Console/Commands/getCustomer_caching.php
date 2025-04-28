<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class getCustomer_caching extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getCustomer:caching';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve and display cached customer data from Redis.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch all customers to get their national IDs
        $customers = Customer::select('national_id')->get();

        if ($customers->isEmpty()) {
            $this->warn('No customers found in the database.');
            return;
        }

        // Iterate through customers and retrieve cached data
        foreach ($customers as $customer) {
            $cachedId = Cache::get('national_id_' . $customer->national_id);

            if ($cachedId) {
                $this->info("National ID: {$customer->national_id}, Cached Customer ID: {$cachedId}");
            } else {
                $this->error("No cached data found for National ID: {$customer->national_id}");
            }
        }
    }
}

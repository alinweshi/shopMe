<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class fillCustomer_caching extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fillCustomer:caching';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill customer data into Redis cache.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customers = Customer::select('id', 'national_id')->get();

        if ($customers->isNotEmpty()) {
            foreach ($customers as $customer) {
                Cache::put('national_id_' . $customer->national_id, $customer->id);
            }
            $this->info('Customers data has been successfully filled into Redis.');
        } else {
            $this->warn('No customers found to cache.');
        }
    }
}

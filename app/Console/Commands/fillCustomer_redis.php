<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class fillCustomer_redis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fillCustomer:redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customers = Customer::select('id', 'national_id')->get();
        // dd($customers);
        if (isset($customers) && !empty($customers)) {
            foreach ($customers as $customer) {
                Redis::set('national_id_' . $customer->national_id, $customer->id);
            }
            $this->info('Customers data has been successfully filled into Redis.');
        }
    }
}

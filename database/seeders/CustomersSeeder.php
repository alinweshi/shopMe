<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the customers table to start fresh
        DB::table('customers')->truncate();

        // Sample data for customers
        $customers = [];

        for ($i = 1; $i <= 20; $i++) {
            $customers[] = [
                'national_id' => '123456789' . $i,
                'first_name' => 'Customer' . $i,
                'last_name' => 'LastName' . $i,
                'email' => 'alinweshi@gmail.com', // Same email for all customers
                'phone' => '123456789' . $i, // Unique phone number for each customer
                'image' => 'customer' . $i . '.jpg',
                'status' => 'inactive', // Set status to inactive for expired subscriptions
                'subscription_end_date' => Carbon::now()->subMonths(rand(1, 12)), // Subscription expired in the past
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert customers into the database
        Customer::insert($customers);
    }
}

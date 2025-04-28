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
?>

<!--

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->Truncate();
        // Sample data for customers
        $customers = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'alinweshi@gmail.com',
                'phone' => '1234567890',
                'image' => 'john.jpg',
                'status' => 'active',
                'subscription_end_date' => now()->addYear(), // Subscription ends in 1 year
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'alinweshi@gmail.com',
                'phone' => '0987654321',
                'image' => 'jane.jpg',
                'status' => 'inactive',
                'subscription_end_date' => now()->subYear(), // Subscription ended 1 year ago
            ],
            [
                'first_name' => 'Alice',
                'last_name' => 'Johnson',
                'email' => 'alinweshi@gmail.com',
                'phone' => '5555555555',
                'image' => 'alice.jpg',
                'status' => 'active',
                'subscription_end_date' => now()->addMonths(6), // Subscription ends in 6 months
            ],
            [
                'first_name' => 'Bob',
                'last_name' => 'Brown',
                'email' => 'alinweshi@gmail.com',
                'phone' => '1111111111',
                'image' => 'bob.jpg',
                'status' => 'active',
                'subscription_end_date' => now()->addMonths(3), // Subscription ends in 3 months
            ],
            [
                'first_name' => 'Charlie',
                'last_name' => 'Davis',
                'email' => 'alinweshi@gmail.com',
                'phone' => '2222222222',
                'image' => 'charlie.jpg',
                'status' => 'inactive',
                'subscription_end_date' => now()->subMonths(2), // Subscription ended 2 months ago
            ],
            [
                'first_name' => 'Eva',
                'last_name' => 'Green',
                'email' => 'alinweshi@gmail.com',
                'phone' => '3333333333',
                'image' => 'eva.jpg',
                'status' => 'active',
                'subscription_end_date' => now()->addMonths(9), // Subscription ends in 9 months
            ],
            [
                'first_name' => 'Frank',
                'last_name' => 'Wilson',
                'email' => 'alinweshi@gmail.com',
                'phone' => '4444444444',
                'image' => 'frank.jpg',
                'status' => 'active',
                'subscription_end_date' => now()->addMonths(12), // Subscription ends in 12 months
            ],
            [
                'first_name' => 'Grace',
                'last_name' => 'Harris',
                'email' => 'alinweshi@gmail.com',
                'phone' => '6666666666',
                'image' => 'grace.jpg',
                'status' => 'inactive',
                'subscription_end_date' => now()->subMonths(6), // Subscription ended 6 months ago
            ],
            [
                'first_name' => 'Henry',
                'last_name' => 'Clark',
                'email' => 'alinweshi@gmail.com',
                'phone' => '7777777777',
                'image' => 'henry.jpg',
                'status' => 'active',
                'subscription_end_date' => now()->addMonths(1), // Subscription ends in 1 month
            ],
            [
                'first_name' => 'Ivy',
                'last_name' => 'Lewis',
                'email' => 'alinweshi@gmail.com',
                'phone' => '8888888888',
                'image' => 'ivy.jpg',
                'status' => 'active',
                'subscription_end_date' => now()->addMonths(2), // Subscription ends in 2 months
            ],
        ];

        // Insert customers into the database
        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
} -->
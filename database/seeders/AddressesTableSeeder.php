<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        // Example addresses for user 1
        Address::create([
            'user_id' => 1,
            'line1' => '123 Main St',
            'line2' => 'Apt 4B',
            'city' => 'New York',
            'state' => 'NY',
            'country' => 'USA',
            'postal_code' => '10001',
            'is_default' => true, // Default shipping address
        ]);

        Address::create([
            'user_id' => 1,
            'line1' => '456 Elm St',
            'line2' => '',
            'city' => 'Brooklyn',
            'state' => 'NY',
            'country' => 'USA',
            'postal_code' => '11201',
            'is_default' => false, // Non-default billing address
        ]);

        // Example addresses for user 2
        Address::create([
            'user_id' => 2,
            'line1' => '789 Maple St',
            'line2' => '',
            'city' => 'San Francisco',
            'state' => 'CA',
            'country' => 'USA',
            'postal_code' => '94107',
            'is_default' => true, // Default address for user 2
        ]);
    }
}

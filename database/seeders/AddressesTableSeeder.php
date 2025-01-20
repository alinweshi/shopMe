<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('addresses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create a range and exclude 76
        // $userIds = array_diff(range(0, 83), [76]);
        $userIds = range(1, 11);

        foreach ($userIds as $userId) {
            // Default address
            Address::create([
                'user_id' => $userId,
                'line1' => "Address Line 1 for User {$userId}",
                'line2' => "Address Line 2 for User {$userId}",
                'city' => 'City' . $userId,
                'state' => 'State' . $userId,
                'country' => 'Country' . $userId,
                'postal_code' => str_pad($userId, 5, '0', STR_PAD_LEFT),
                'is_default' => true,
            ]);

            // Non-default address
            Address::create([
                'user_id' => $userId,
                'line1' => "Alternate Address Line 1 for User {$userId}",
                'line2' => "Alternate Address Line 2 for User {$userId}",
                'city' => 'Alternate City' . $userId,
                'state' => 'Alternate State' . $userId,
                'country' => 'Country' . $userId,
                'postal_code' => str_pad($userId + 1000, 5, '0', STR_PAD_LEFT),
                'is_default' => false,
            ]);
        }
    }
}

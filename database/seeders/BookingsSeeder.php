<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('bookings')->insert([
                "user_id" => rand(1, 10),
                "ticket_id" => rand(1, 10),
                "quantity" => rand(1, 10),
            ]);
        }
    }
}

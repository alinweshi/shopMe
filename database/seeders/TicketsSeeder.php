<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('tickets')->insert([
                "title" => "Ticket " . $i,
                "description" => "Description " . $i,
                "price" => rand(1, 10),
                "date" => now()->subDays($i),
                "stock" => rand(1, 10),
            ]);
        }
    }
}

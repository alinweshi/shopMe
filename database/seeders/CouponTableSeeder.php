<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coupons')->insert([
            [
                'code' => Str::random(10),
                'discount_type' => 'fixed',
                'discount_value' => 10.00,
                'expires_at' => Carbon::now()->addDays(30),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => Str::random(10),
                'discount_type' => 'percentage',
                'discount_value' => 15.00,
                'expires_at' => Carbon::now()->addDays(60),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

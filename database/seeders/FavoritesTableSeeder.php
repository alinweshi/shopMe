<?php

namespace Database\Seeders;

use App\Models\Favorite;
use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    public function run()
    {
        Favorite::create([
            'user_id' => 1,
            'product_id' => 1,
        ]);

        Favorite::create([
            'user_id' => 2,
            'product_id' => 2,
        ]);
    }
}

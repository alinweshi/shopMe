<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    public function run()
    {
        Attribute::create(['name' => 'Color']);
        Attribute::create(['name' => 'Size']);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Common product attributes with consistent naming convention
     * 
     * @var array
     */
    protected array $commonAttributes = [
        'Color',
        'Size',
        'Style',
        'Material',
        'Gender',
        'Brand',
        'Category',
        'Weight',
        'Dimensions',
        'Age Range',
        'Season',
        'Pattern',
        'Sleeve Length',
        'Fit Type',
        'Closure Type',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->commonAttributes as $attribute) {
            Attribute::firstOrCreate(
                ['name' => $attribute],
                ['name' => $attribute]
            );
        }
    }
}

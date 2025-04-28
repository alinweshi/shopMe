<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValuesTableSeeder extends Seeder
{
    protected array $attributeValues = [
        'Color' => [
            'Red',
            'Blue',
            'White',
            'Black',
            'Green',
            'Yellow',
            'Orange',
            'Purple',
            'Pink',
            'Gray'
        ],
        'Size' => [
            'XS',
            'S',
            'M',
            'L',
            'XL',
            'XXL',
            'XXXL'
        ],
        'Style' => [
            'Casual',
            'Formal',
            'Sporty',
            'Bohemian',
            'Vintage',
            'Modern',
            'Classic'
        ],
        'Material' => [
            'Cotton',
            'Polyester',
            'Wool',
            'Silk',
            'Leather',
            'Denim',
            'Linen'
        ],
        'Pattern' => [
            'Solid',
            'Striped',
            'Plaid',
            'Floral',
            'Polka Dot',
            'Geometric',
            'Camouflage'
        ],
        'Fit' => [
            'Slim',
            'Regular',
            'Loose',
            'Tapered',
            'Oversized',
            'Skinny'
        ],
        'Length' => [
            'Short',
            'Medium',
            'Long',
            'Knee-Length',
            'Ankle-Length',
            'Full-Length'
        ],
        'Neckline' => [
            'V-Neck',
            'Round Neck',
            'Square Neck',
            'Collared',
            'Off Shoulder',
            'Boat Neck',
            'Turtleneck'
        ],
        'Sleeve Length' => [
            'Sleeveless',
            'Short Sleeve',
            '3/4 Sleeve',
            'Long Sleeve'
        ],
        'Occasion' => [
            'Everyday',
            'Work',
            'Party',
            'Wedding',
            'Travel',
            'Gym',
            'Beach'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->attributeValues as $attributeName => $values) {
            $attribute = Attribute::where('name', $attributeName)->first();

            if ($attribute) {
                foreach ($values as $value) {
                    AttributeValue::firstOrCreate([
                        'attribute_id' => $attribute->id,
                        'attribute_value' => $value
                    ]);
                }
            }
        }
    }
}
    // public function run()
    // {
        // // Color Values
        // AttributeValue::create(['attribute_id' => 1, 'attribute_value' => 'Red']);
        // AttributeValue::create(['attribute_id' => 1, 'attribute_value' => 'Blue']);
        // AttributeValue::create(['attribute_id' => 1, 'attribute_value' => 'White']);
        // AttributeValue::create(['attribute_id' => 1, 'attribute_value' => 'Black']);
        // AttributeValue::create(['attribute_id' => 1, 'attribute_value' => 'Orange']);

        // // Size Values
        // AttributeValue::create(['attribute_id' => 2, 'attribute_value' => 'Small']);
        // AttributeValue::create(['attribute_id' => 2, 'attribute_value' => 'Medium']);
        // AttributeValue::create(['attribute_id' => 2, 'attribute_value' => 'Large']);
        // AttributeValue::create(['attribute_id' => 2, 'attribute_value' => 'XLarge']);
        // AttributeValue::create(['attribute_id' => 2, 'attribute_value' => 'XXLarge']);
        // AttributeValue::create(['attribute_id' => 2, 'attribute_value' => 'XXXLarge']);

        // // Style Values
        // AttributeValue::create(['attribute_id' => 3, 'attribute_value' => 'Slim']);
        // AttributeValue::create(['attribute_id' => 3, 'attribute_value' => 'Classic']);
        // AttributeValue::create(['attribute_id' => 3, 'attribute_value' => 'Oversize']);
        // AttributeValue::create(['attribute_id' => 3, 'attribute_value' => 'Modern']);

        // // Material Values
        // AttributeValue::create(['attribute_id' => 4, 'attribute_value' => '100% Cotton']);
        // AttributeValue::create(['attribute_id' => 4, 'attribute_value' => '95% Cotton 5% Lycra']);
        // AttributeValue::create(['attribute_id' => 4, 'attribute_value' => 'Leather']);
        // AttributeValue::create(['attribute_id' => 4, 'attribute_value' => 'Wool']);

        // // RAM Values
        // AttributeValue::create(['attribute_id' => 5, 'attribute_value' => '4 GB']);
        // AttributeValue::create(['attribute_id' => 5, 'attribute_value' => '6 GB']);
        // AttributeValue::create(['attribute_id' => 5, 'attribute_value' => '8 GB']);
        // AttributeValue::create(['attribute_id' => 5, 'attribute_value' => '12 GB']);

        // // Storage Values
        // AttributeValue::create(['attribute_id' => 6, 'attribute_value' => '64 GB']);
        // AttributeValue::create(['attribute_id' => 6, 'attribute_value' => '128 GB']);
        // AttributeValue::create(['attribute_id' => 6, 'attribute_value' => '256 GB']);
        // AttributeValue::create(['attribute_id' => 6, 'attribute_value' => '512 GB']);

        // // Battery Life Values
        // AttributeValue::create(['attribute_id' => 7, 'attribute_value' => '8 hours']);
        // AttributeValue::create(['attribute_id' => 7, 'attribute_value' => '12 hours']);
        // AttributeValue::create(['attribute_id' => 7, 'attribute_value' => '24 hours']);

        // // Screen Size Values
        // AttributeValue::create(['attribute_id' => 8, 'attribute_value' => '5.5 inches']);
        // AttributeValue::create(['attribute_id' => 8, 'attribute_value' => '6.1 inches']);
        // AttributeValue::create(['attribute_id' => 8, 'attribute_value' => '6.7 inches']);

        // // Processor Values
        // AttributeValue::create(['attribute_id' => 9, 'attribute_value' => 'Snapdragon 888']);
        // AttributeValue::create(['attribute_id' => 9, 'attribute_value' => 'Apple A15']);
        // AttributeValue::create(['attribute_id' => 9, 'attribute_value' => 'Exynos 2100']);

        // // Organic Values
        // AttributeValue::create(['attribute_id' => 10, 'attribute_value' => 'Yes']);
        // AttributeValue::create(['attribute_id' => 10, 'attribute_value' => 'No']);

        // // Flavor Values
        // AttributeValue::create(['attribute_id' => 11, 'attribute_value' => 'Almond']);
        // AttributeValue::create(['attribute_id' => 11, 'attribute_value' => 'Vanilla']);
        // AttributeValue::create(['attribute_id' => 11, 'attribute_value' => 'Chocolate']);

        // // Weight Values
        // AttributeValue::create(['attribute_id' => 12, 'attribute_value' => '100g']);
        // AttributeValue::create(['attribute_id' => 12, 'attribute_value' => '250g']);
        // AttributeValue::create(['attribute_id' => 12, 'attribute_value' => '500g']);

        // // Sport Type Values
        // AttributeValue::create(['attribute_id' => 13, 'attribute_value' => 'Soccer']);
        // AttributeValue::create(['attribute_id' => 13, 'attribute_value' => 'Basketball']);
        // AttributeValue::create(['attribute_id' => 13, 'attribute_value' => 'Tennis']);

        // // Skin Type Values
        // AttributeValue::create(['attribute_id' => 14, 'attribute_value' => 'Dry']);
        // AttributeValue::create(['attribute_id' => 14, 'attribute_value' => 'Oily']);
        // AttributeValue::create(['attribute_id' => 14, 'attribute_value' => 'Sensitive']);

        // // Scent Values
        // AttributeValue::create(['attribute_id' => 15, 'attribute_value' => 'Floral']);
        // AttributeValue::create(['attribute_id' => 15, 'attribute_value' => 'Citrus']);
        // AttributeValue::create(['attribute_id' => 15, 'attribute_value' => 'Woody']);

        // // Volume Values
        // AttributeValue::create(['attribute_id' => 16, 'attribute_value' => '200 ml']);
        // AttributeValue::create(['attribute_id' => 16, 'attribute_value' => '500 ml']);
//         // AttributeValue::create(['attribute_id' => 16, 'attribute_value' => '1 L']);
//     }
// }

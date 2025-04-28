<?php

namespace Database\Factories;

use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(2),
            'brand' => $this->faker->company(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'final_price' => $this->faker->randomFloat(2, 0, 100),
            'discount_type' => $this->faker->randomElement(['percentage', 'fixed']),
            'discount' => $this->faker->randomFloat(2, 0, 100),
            'category_id' => Category::factory(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}

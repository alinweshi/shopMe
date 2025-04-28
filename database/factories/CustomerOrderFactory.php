<?php

namespace Database\Factories;

use App\Models\CustomerOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerOrder>
 */
class CustomerOrderFactory extends Factory
{
    protected $model = CustomerOrder::class;

    public function definition()
    {
        return [
            'orderNumber' => $this->faker->numberBetween(1000, 9999),
            'orderDate' => $this->faker->dateTimeThisYear(),
            'requiredDate' => $this->faker->dateTimeBetween('now', '+1 month'),
            'shippedDate' => $this->faker->optional(0.7)->dateTimeBetween('now', '+2 weeks'),
            'status' => $this->faker->randomElement(['pending', 'shipped', 'delivered', 'cancelled']),
            'comments' => $this->faker->optional(0.5)->sentence,
            'customerNumber' => $this->faker->numberBetween(1, 100),
        ];
    }
}

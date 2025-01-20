<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Make sure the password is correctly hashed
            'phone' => $this->faker->unique()->phoneNumber(), // Ensure unique phone numbers
            'image' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'is_super' => $this->faker->boolean(),
        ];
    }

}

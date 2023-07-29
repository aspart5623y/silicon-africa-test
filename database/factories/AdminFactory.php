<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        $faker = \Faker\Factory::create();

        return [
            'first_name' => $faker->firstname(),
            'last_name' => $faker->lastname(),
            'phone' => $faker->phoneNumber(),
            'level' => $faker->randomElement(['staff', 'super_admin'])
        ];
    }
}

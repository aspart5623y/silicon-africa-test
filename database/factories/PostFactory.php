<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();

        $users = \App\Models\User::all();
        $user_array = [];

        foreach ($users as $user) {
            array_push($user_array, $user->id);
        }

        $position = array_rand($user_array);

        return [
            'user_id' => $user_array[$position],
            'title' => $faker->paragraph(1),
            'body'=> implode($faker->paragraphs())
        ];
    }
}

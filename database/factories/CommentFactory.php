<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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

        $user_position = array_rand($user_array);


        $posts = \App\Models\Post::all();
        $post_array = [];

        foreach ($posts as $post) {
            array_push($post_array, $post->id);
        }

        $post_position = array_rand($post_array);

        return [
            'user_id' => $user_array[$user_position],
            'post_id' => $post_array[$post_position],
            'comment' => $faker->paragraph(1)
        ];
    }
}

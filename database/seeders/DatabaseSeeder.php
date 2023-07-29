<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Profile::factory()->count(1)->for(
            \App\Models\Admin::factory(), 'profileable'
        )->create([
            "email" => "admin@mail.com",
            "password" => Hash::make('password')
        ]);

        \App\Models\Profile::factory()->count(1)->for(
            \App\Models\User::factory(), 'profileable'
        )->create([
            "email" => "user@mail.com",
            "password" => Hash::make('password')
        ]);

        \App\Models\Post::factory(10)->create();

        \App\Models\Comment::factory(20)->create();
    }
}

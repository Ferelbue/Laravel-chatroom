<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 12; $i++) {
            \App\Models\User::factory()->create([
                'name' => $faker->name,
                'nickName' => $faker->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'is_active' => 'true',
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

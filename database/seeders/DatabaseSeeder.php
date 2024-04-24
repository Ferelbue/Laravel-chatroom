<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Game::factory(20)->create();
        \App\Models\User::factory(40)->create();
        \App\Models\Room::factory(40)->create();
        \App\Models\Chat::factory(40)->create();
        \App\Models\RoomUser::factory(40)->create();
    }
}
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
        $users = \App\Models\User::factory(10)->create();
        $games= \App\Models\Game::factory(5)->create();
        // \App\Models\Room::factory(5)->create();
        $rooms = \App\Models\Room::factory(5)->create()->each(function ($room) use ($users, $games) {
            $room->users()->attach($users->random()->id);
            $room->game_id = $games->random()->id;
            $room->save();
        });
        \App\Models\Chat::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
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
        $games= \App\Models\Game::factory(5)->create();
        $users = \App\Models\User::factory(10)->create();
        $rooms = \App\Models\Room::factory(5)->create()->each(function ($room) use ($users, $games) {
            $room->users()->attach($users->random()->id, ["created_at" => now(), "updated_at" => now()]);
            $room->game_id = $games->random()->id;
            $room->save();
        });
        \App\Models\Chat::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'user',
            'nickname' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
            'role' => 'user'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'nickname' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'role' => 'admin'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'superadmin',
            'nickname' => 'superadmin',
            'email' => 'superadmin@superadmin.com',
            'password' => bcrypt('123456'),
            'role' => 'super_admin'
        ]);
    }
}
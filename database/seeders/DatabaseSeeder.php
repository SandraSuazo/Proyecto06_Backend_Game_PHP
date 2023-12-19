<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GameSeeder::class,
            RoomSeeder::class,
            MessageSeeder::class,
        ]);


        User::factory(100)->create();
        Game::factory(6)->create();
        Room::factory(6)->create();
        Message::factory(20)->create();
    }
}

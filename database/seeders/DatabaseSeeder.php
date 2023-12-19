<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GameSeeder::class
        ]);


        User::factory(100)->create();
        Game::factory(6)->create();

    }
}

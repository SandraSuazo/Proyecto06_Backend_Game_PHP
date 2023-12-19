<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('games')->insert([
            'name' => fake()->company(),
            'category' => 'shooter',
            'user_id' => 1,
        ]);
    }
}

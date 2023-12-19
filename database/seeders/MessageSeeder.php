<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('messages')->insert([
            'message' => Str::random(80),
            'user_id' => 1,
            'room_id' => 1,
        ]);
    }
}

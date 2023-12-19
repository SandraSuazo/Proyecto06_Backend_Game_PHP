<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert(
            [
                [
                    'name' => 'user',
                    'email' => 'user@user.com',
                    'role' => 'user',
                    'password' => bcrypt('Whopper'),
                ],
                [
                    'name' => 'admin',
                    'email' => 'admin@admin.com',
                    'role' => 'admin',
                    'password' => bcrypt('Whopper'),
                ],
                [
                    'name' => 'superAdmin',
                    'email' => 'superadmin@superadmin.com',
                    'role' => 'superAdmin',
                    'password' => bcrypt('Whopper'),
                ]
            ]

        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Mokaddes Hosain',
                'email' => 'mr.mokaddes@gmail.com',
                'password' => bcrypt('12345678'),
                'user_type' => 1,
            ], [
                'name' => 'Test User',
                'email' => 'test@gmail.com',
                'password' => bcrypt('12345678'),
                'user_type' => 0,
            ], [
                'name' => 'Second User',
                'email' => 'test2@gmail.com',
                'password' => bcrypt('12345678'),
                'user_type' => 0,
            ],
        ];

        // create users with data
        foreach ($data as $user) {
            User::create($user);
        }
    }
}

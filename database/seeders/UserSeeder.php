<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $statuses = ['inactive'];

        for ($i = 0; $i < 10; $i++) {
            $createdAt = $faker->dateTimeBetween('-1 year', 'now');
            $updatedAt = $faker->dateTimeBetween($createdAt, 'now');
            DB::table('users')->insert([
                'fname' => $faker->firstName,
                'mname' => strtoupper(substr($faker->firstName, 0, 1)),
                'lname' => $faker->lastName,
                'image' => null,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password123'), // All users will use this password
                'status' => $faker->randomElement($statuses),
                'role' => null,
                'remember_token' => Str::random(10),
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}

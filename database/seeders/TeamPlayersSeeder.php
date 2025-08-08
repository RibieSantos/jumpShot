<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class TeamPlayersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Get all existing team and member IDs
        $teamIds = DB::table('teams')->pluck('id')->toArray();
        $memberIds = DB::table('members')->pluck('id')->toArray();

        // Check if we have enough data
        if (empty($teamIds) || empty($memberIds)) {
            $this->command->warn('No teams or members found. Please seed those tables first.');
            return;
        }

        // Shuffle to ensure randomness and uniqueness
        shuffle($memberIds);

        // Only loop through available unique member IDs
        foreach ($memberIds as $memberId) {
            DB::table('team_players')->insert([
                'team_id' => $faker->randomElement($teamIds),
                'member_id' => $memberId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

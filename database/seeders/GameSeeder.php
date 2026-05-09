<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            'Mobile Legends',
            'Free Fire',
            'PUBG Mobile',
        ];

        foreach ($games as $game) {
            DB::table('games')->insert(['name' => $game]);
        }
    }
}

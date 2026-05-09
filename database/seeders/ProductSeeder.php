<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mobileLegendId = Game::where('name', 'Mobile Legends')->first('id')->id;
        $freeFireId = Game::where('name', 'Free Fire')->first('id')->id;
        $pubgMobileId = Game::where('name', 'PUBG Mobile')->first('id')->id;

        $products = [
            [
                'code' => 'MLBB_5_DM',
                'name' => 'Mobile Legends 5 Diamonds',
                'game_id' => $mobileLegendId,
            ],
            [
                'code' => 'MLBB_WP',
                'name' => 'Mobile Legends Weekly Pass',
                'game_id' => $mobileLegendId,
            ],
            [
                'code' => 'FF_100_DM',
                'name' => 'Free Fire 100 Diamonds',
                'game_id' => $freeFireId,
            ],
            [
                'code' => 'PUBG_60_UC',
                'name' => 'PUBG 60 UC',
                'game_id' => $pubgMobileId,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}

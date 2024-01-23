<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert(
            [
                'filename' => '1_1.jpg',
                'item_id' => 1,
            ],
        );
        DB::table('images')->insert(
            [
                'filename' => '1_2.jpg',
                'item_id' => 1,
            ],
        );
        DB::table('images')->insert(
            [
                'filename' => '2_1.jpg',
                'item_id' => 2,
            ],
        );
        DB::table('images')->insert(
            [
                'filename' => '2_2.jpg',
                'item_id' => 2,
            ],
        );
        DB::table('images')->insert(
            [
                'filename' => '3_1.jpg',
                'item_id' => 3,
            ],
        );
        DB::table('images')->insert(
            [
                'filename' => '3_2.jpg',
                'item_id' => 3,
            ],
        );
    }
}

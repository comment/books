<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert(
            [
                'title' => 'Книги',
                'parent_id' => 0,
            ],
        );
        DB::table('categories')->insert(
            [
                'title' => 'Автомобили',
                'parent_id' => 0,
            ],
        );
        DB::table('categories')->insert(
            [
                'title' => 'Одежда',
                'parent_id' => 0,
            ],
        );
        DB::table('categories')->insert(
            [
                'title' => 'Эзотерика',
                'parent_id' => 1,
            ],
        );
        DB::table('categories')->insert(
            [
                'title' => 'Гадания',
                'parent_id' => 1,
            ],
        );
        DB::table('categories')->insert(
            [
                'title' => 'Ноутбуки',
                'parent_id' => 2,
            ],
        );
    }
}

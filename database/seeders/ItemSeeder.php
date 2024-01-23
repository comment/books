<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert(
            [
                'category_id' => 1,
                'title' => 'Запретные сады Адама',
                'author' => 'Дориан Грэй',
                'year' => 2023,
                'state' => 1,
                'about_state' => 'Нормальное состояние, читать можно!',
                'price' => 120.00,
                'image' => '{"1":"/images/323.jpg","2":"/images/232.jpg","3":"/images/666.jpg"}',
                'note' => 'Отличная книга, всем рекомендую!'
            ],
        );
        DB::table('items')->insert(
            [
                'category_id' => 1,
                'title' => 'Денискины рассказы',
                'author' => 'Вася Пупкин',
                'year' => 2001,
                'state' => 3,
                'about_state' => 'Потрепана слегка!',
                'price' => 88.00,
                'image' => '{"1":"/images/323.jpg"}',
                'note' => 'Полная херь!!'
            ],
        );
        DB::table('items')->insert(
            [
                'category_id' => 1,
                'title' => 'Гарри и змея',
                'author' => 'Маргарет Тетчер',
                'year' => 1998,
                'state' => 2,
                'about_state' => 'Нормальное состояние, читать можно!',
                'price' => 23.50,
                'image' => '{}',
                'note' => 'На разок пойдет!'
            ],
        );
    }
}

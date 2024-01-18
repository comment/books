<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            'title' => 'Harry Potter',
            'author' => 'Sergey Abraztsou',
            'year' => '1988',
            'description' => 'Cool story about magic and love with boys',
        ]);
    }
}

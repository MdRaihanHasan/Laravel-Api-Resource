<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            DB::table('books')->insert([
                'user_id' => rand(1, 10), // Assuming you have 10 users
                'title' => "Book $i",
                'description' => "Description for Book $i",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

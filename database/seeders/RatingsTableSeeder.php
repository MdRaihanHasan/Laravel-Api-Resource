<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingsTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            DB::table('ratings')->insert([
                'user_id' => rand(1, 10), // Assuming you have 10 users
                'book_id' => rand(1, 30), // Assuming you have 30 books
                'rating' => rand(1, 5), // Assuming ratings are between 1 and 5
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

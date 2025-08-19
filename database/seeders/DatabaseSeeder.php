<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            UserSeeder::class,
            MovieSeeder::class,
            QuoteSeeder::class,
            CommentSeeder::class,
            LikeSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}

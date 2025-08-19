<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        if (Genre::count() === 0) {
            $genres = config('genres');

            foreach ($genres as $genre) {
                Genre::create($genre);
            }
        }
    }
}

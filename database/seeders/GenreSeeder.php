<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = config('genres');

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}

<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    public function definition(): array
    {
        $randomUser = User::inRandomOrder()->first() ?? User::factory();

        return [
            'user_id' => $randomUser,
            'year'    => fake()->year(),
            'title'   => [
                'en' => fake()->sentence(),
                'ka' => fake('ka_GE')->sentence(),
            ],
            'description' => [
                'en' => fake()->paragraph(),
                'ka' => fake('ka_GE')->paragraph(),
            ],
            'director' => [
                'en' => fake()->name(),
                'ka' => fake('ka_GE')->name(),
            ],
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Movie $movie) {
            $movie->addMedia(storage_path('app/public/placeholder.png'))
                ->preservingOriginal()
                ->toMediaCollection('posters');
        });
    }
}

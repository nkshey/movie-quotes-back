<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    public function definition(): array
    {
        $randomUser = User::inRandomOrder()->first() ?? User::factory();
        $randomMovie = Movie::inRandomOrder()->first() ?? Movie::factory();

        return [
            'user_id'  => $randomUser,
            'movie_id' => $randomMovie,
            'text'     => [
                'en' => fake()->paragraph(),
                'ka' => fake('ka_GE')->paragraph(),
            ],
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Quote $quote) {
            $quote->addMedia(storage_path('app/public/placeholder.png'))
                ->preservingOriginal()
                ->toMediaCollection('quotes');
        });
    }
}

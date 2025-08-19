<?php

namespace Database\Factories;

use App\FactoryHelpers;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    use FactoryHelpers;

    public function definition(): array
    {
        $randomUser = $this->getRandomUser();
        $randomMovie = $this->getRandomMovie();

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

<?php

namespace Database\Factories;

use App\FactoryHelpers;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    use FactoryHelpers;

    public function definition(): array
    {

        $randomUser = $this->getRandomUser();
        $randomQuote = $this->getRandomQuote();

        return [
            'user_id'  => $randomUser,
            'quote_id' => $randomQuote,
            'body'     => fake()->paragraph(),
        ];
    }
}

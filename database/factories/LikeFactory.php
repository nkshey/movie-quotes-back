<?php

namespace Database\Factories;

use App\FactoryHelpers;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    use FactoryHelpers;

    public function definition(): array
    {
        $randomUser = $this->getRandomUser();
        $randomQuote = $this->getRandomQuote();

        return [
            'user_id'  => $randomUser,
            'quote_id' => $randomQuote,
        ];
    }
}

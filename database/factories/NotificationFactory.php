<?php

namespace Database\Factories;

use App\FactoryHelpers;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    use FactoryHelpers;

    public function definition(): array
    {
        $randomUser = $this->getRandomUser();
        $randomSender = $this->getRandomSender($randomUser->id);
        $randomQuote = $this->getRandomQuote();

        return [
            'user_id'   => $randomUser,
            'sender_id' => $randomSender,
            'quote_id'  => $randomQuote,
            'type'      => fake()->randomElement(['like', 'comment']),
            'read'      => fake()->boolean(),
        ];
    }
}

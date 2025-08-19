<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        $randomUser = User::inRandomOrder()->first() ?? User::factory();
        $randomSender = User::where('id', '!=', $randomUser->id)->inRandomOrder()->first() ?? User::factory();
        $randomQuote = Quote::inRandomOrder()->first() ?? Quote::factory();

        return [
            'user_id'   => $randomUser,
            'sender_id' => $randomSender,
            'quote_id'  => $randomQuote,
            'type'      => fake()->randomElement(['like', 'comment']),
            'read'      => fake()->boolean(),
        ];
    }
}

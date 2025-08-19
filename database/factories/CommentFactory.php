<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        $randomUser = User::inRandomOrder()->first() ?? User::factory();
        $randomQuote = Quote::inRandomOrder()->first() ?? Quote::factory();

        return [
            'user_id'  => $randomUser,
            'quote_id' => $randomQuote,
            'body'     => fake()->paragraph(),
        ];
    }
}

<?php

namespace App;

use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

trait FactoryHelpers
{
    public function getRandomUser(): User|Factory
    {
        return User::inRandomOrder()->first() ?? User::factory();
    }

    public function getRandomQuote(): Quote|Factory
    {
        return Quote::inRandomOrder()->first() ?? Quote::factory();
    }

    public function getRandomMovie(): Movie|Factory
    {
        return Movie::inRandomOrder()->first() ?? Movie::factory();
    }

    public function getRandomSender(int $excludeUserId): User|Factory
    {
        return User::where('id', '!=', $excludeUserId)->inRandomOrder()->first() ?? User::factory();
    }
}

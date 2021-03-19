<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'wkn_number' => $faker->randomNumber(6),
        'ticker_symbol' => $faker->randomNumber(3)
    ];
});

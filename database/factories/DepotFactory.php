<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Depot;
use Faker\Generator as Faker;

$factory->define(Depot::class, function (Faker $faker) {
    return [
        'depot_currency' => $faker->currencyCode,
        'depot_title' => $faker->word
    ];
});

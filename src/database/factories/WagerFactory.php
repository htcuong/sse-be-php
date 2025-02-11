<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Wager;
use Faker\Generator as Faker;

$factory->define(Wager::class, function (Faker $faker) {
    return [
        'id' => 1,
        'total_wager_value' => 100,
        'odds' => 10,
        'selling_percentage' => 50,
        'selling_price' => 51,
        'current_selling_price' => 51,
        'percentage_sold' => null,
        'amount_sold' => null,
        'placed_at' => '2020-09-08 08:49:39'
    ];
});

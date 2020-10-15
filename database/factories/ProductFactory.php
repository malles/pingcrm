<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Product::class, function (Faker $faker) {
    $cost_price = $faker->numberBetween(30, 400);
    return [
        'name' => $faker->word,
        'park_reference' => $faker->word,
        'supplier_reference' => $faker->postcode,
        'cost_price' => $cost_price,
        'selling_price' => $cost_price * (1 + ($faker->numberBetween(5, 60) / 100)),
    ];
});

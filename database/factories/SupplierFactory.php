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

$factory->define(App\Models\Supplier::class, function (Faker $faker) {
    return [
        'name' => $faker->words(3, true),
        'address' => $faker->address,
        'postal_code' => $faker->postcode,
        'city' => $faker->city,
        'country' => $faker->randomElement(['DE', 'NL', 'BE', 'UK',]),
        'contact' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
    ];
});

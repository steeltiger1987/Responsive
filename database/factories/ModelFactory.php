<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});



$factory->define(App\Models\Car::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'model' => $faker->randomLetter,
        'mover_id' => $faker->randomDigit,
        'type' => $faker->randomLetter,
        'loading_capacity' => $faker->randomDigit,
        'year' => $faker->year,
        'photo' => $faker->uuid . $faker->fileExtension
    ];
});

$factory->define(App\Models\Bid::class, function (Faker\Generator $faker) {

    return [
        'mover_id' => factory(App\Models\Mover::class)->create()->id,
        'order_id' => factory(App\Models\Order::class)->create()->id,
        'car_id' => factory(App\Models\Car::class)->create()->id,
        'bid' => $faker->numberBetween(100, 1000),
        'ride_along' => $faker->boolean(),
        'movers' => $faker->randomDigit,
        'spolumoving' => $faker->boolean()
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {

    return [
        'user_id' => factory(App\Models\User::class)->create()->id,
    ];
});


<?php

use Carbon\Carbon;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Profile;
use App\VitalGym\Entities\ActivationToken;

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

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'active'         => $faker->randomElement([true, false, true]),
        'role'           => $faker->randomElement(['admin', 'customer', 'customer']),
        'last_login'     => Carbon::now(),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Profile::class, function (Faker\Generator $faker) {
    return [
        'name'          => $faker->firstName,
        'last_name'       => $faker->lastName,
        'nick_name'      => $faker->name,
        'avatar'         => $faker->imageUrl(250, 250),
        'address'         => $faker->address,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->define(ActivationToken::class, function (Faker\Generator $faker) {
    return [
        'token'   => str_random(128),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

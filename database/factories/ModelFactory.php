<?php

use App\VitalGym\Entities\User;
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
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
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

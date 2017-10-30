<?php

use Carbon\Carbon;
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
        'name'           => $faker->firstName,
        'last_name'      => $faker->lastName,
        'nick_name'      => $faker->name,
        'avatar'         => 'https://s3-us-west-2.amazonaws.com/vitalgym/avatars/default-avatar.jpg',
        'email'          => $faker->unique()->safeEmail,
        'phone'          => $faker->phoneNumber,
        'cell_phone'     => $faker->phoneNumber,
        'address'         => $faker->address,
        'password'       => $password ?: $password = bcrypt('secret'),
        'active'         => $faker->randomElement([true, false, true]),
        'role'           => $faker->randomElement(['admin', 'customer', 'customer']),
        'last_login'     => Carbon::now(),
        'api_token'      => str_random(60),
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

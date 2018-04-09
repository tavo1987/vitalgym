<?php

use Faker\Generator as Faker;
use App\VitalGym\Entities\Membership;

$factory->define(Membership::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['mensual', 'anual', 'semestral']),
        'price' => $faker->numberBetween(1, 500),
    ];
});

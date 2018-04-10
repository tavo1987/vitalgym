<?php

use Faker\Generator as Faker;
use App\VitalGym\Entities\MembershipType;

$factory->define(MembershipType::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['mensual', 'anual', 'semestral']),
        'price' => $faker->numberBetween(1, 500),
    ];
});

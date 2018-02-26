<?php

use App\VitalGym\Entities\MembershipType;
use Faker\Generator as Faker;

$factory->define(MembershipType::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['mensual', 'anual', 'semestral']),
        'price' => $faker->numberBetween(1, 500),
    ];
});

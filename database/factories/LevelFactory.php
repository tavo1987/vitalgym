<?php

use App\VitalGym\Entities\Level;
use Faker\Generator as Faker;

$factory->define(Level::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['principiante', 'medio', 'experto']),
    ];
});

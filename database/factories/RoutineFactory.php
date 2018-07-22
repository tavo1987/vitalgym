<?php

use App\VitalGym\Entities\Level;
use App\VitalGym\Entities\Routine;
use Faker\Generator as Faker;

$factory->define(Routine::class, function (Faker $faker) {
    return [
        'level_id' => function() {
            return factory(Level::class)->create()->id;
        }
    ];
});

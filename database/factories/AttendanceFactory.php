<?php

use App\VitalGym\Entities\Attendance;
use App\VitalGym\Entities\Customer;
use Faker\Generator as Faker;

$factory->define(Attendance::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTime,
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
    ];
});

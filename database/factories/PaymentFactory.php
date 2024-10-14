<?php

use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\User;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'total_price' => $faker->numberBetween(30, 300),
        'membership_quantity' => $faker->numberBetween(1, 5),
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

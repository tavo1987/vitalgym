<?php

use Faker\Generator as Faker;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Customer;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

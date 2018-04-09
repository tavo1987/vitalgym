<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Order;
use App\VitalGym\Entities\MembershipType;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'date_start' => Carbon::now(),
        'date_end' => Carbon::now()->addDays(30),
        'total_days' => 30,
        'membership_type_id' => function () {
            return factory(MembershipType::class)->create()->id;
        },
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
    ];
});

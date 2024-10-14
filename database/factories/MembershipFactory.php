<?php

use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\Plan;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Membership::class, function (Faker $faker) {
    return [
        'date_start' => Carbon::now(),
        'date_end' => Carbon::now()->addDays(30),
        'total_days' => 30,
        'plan_id' => function () {
            return factory(Plan::class)->create()->id;
        },
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
        'payment_id' => function () {
            return factory(Payment::class)->create()->id;
        },
    ];
});

$factory->state(Membership::class, 'expired', [
    'date_end' => today()->toDateString(),
]);

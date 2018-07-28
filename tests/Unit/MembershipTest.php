<?php

namespace tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Carbon;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MembershipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_membership_has_a_customer()
    {
        $membership = factory(Membership::class)->create();

        $this->assertInstanceOf(
            Customer::class, $membership->customer
        );
    }

    /** @test */
    function a_membership_has_a_membershipType()
    {
        $membership = factory(Membership::class)->create();

        $this->assertInstanceOf(
            Plan::class, $membership->plan
        );
    }

    /** @test */
    function a_membership_belongs_to_payment()
    {
        $payment = factory(Payment::class)->create();
        $membership = factory(Membership::class)->create(['payment_id' => $payment->id]);

        $this->assertInstanceOf(
            Payment::class, $membership->payment
        );

        $this->assertEquals($payment->id, $membership->payment->id);
    }
}

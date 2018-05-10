<?php

namespace tests\Unit;

use Tests\TestCase;
use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MembershipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_membership_has_a_customer()
    {
        $membership = factory(Membership::class)->create();

        $this->assertInstanceOf(
            Customer::class, $membership->customer
        );
    }

    /** @test */
    public function a_membership_has_a_membershipType()
    {
        $membership = factory(Membership::class)->create();

        $this->assertInstanceOf(
            MembershipType::class, $membership->membershipType
        );
    }

    /** @test */
    public function a_membership_has_a_payment()
    {
        $membership = factory(Membership::class)->create();
        $payment = factory(Payment::class)->create([
            'membership_id' => $membership->id,
        ]);

        $this->assertInstanceOf(
            Payment::class, $membership->payment
        );

        $this->assertEquals($payment->id, $membership->payment->id);
    }
}

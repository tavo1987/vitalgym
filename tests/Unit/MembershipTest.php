<?php

namespace tests\Unit;

use Tests\TestCase;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;

class MembershipTest extends TestCase
{
    /** @test */
    public function a_membership_has_a_customer()
    {
        $membership = factory(Membership::class)->make();

        $this->assertInstanceOf(
            Customer::class, $membership->customer
        );
    }
}

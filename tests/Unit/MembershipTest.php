<?php

namespace tests\Unit;

use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;
use Tests\TestCase;

class MembershipTest extends TestCase
{
    /** @test */
    function a_membership_has_a_customer()
    {
        $membership = factory(Membership::class)->make();

        $this->assertInstanceOf(
            Customer::class, $membership->customer
        );
    }
}
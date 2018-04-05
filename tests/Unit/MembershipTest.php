<?php

namespace tests\Unit;

use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;

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
    public function a_membership_belongs_to_membershipType(){

        $membership = factory(Membership::class)->create();

        $this->assertInstanceOf(
            MembershipType::class, $membership->membershipType
        );
    }
}

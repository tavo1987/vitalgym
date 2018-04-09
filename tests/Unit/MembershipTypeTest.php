<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\VitalGym\Entities\Membership;

class MembershipTypeTest extends TestCase
{
    /** @test */
    public function can_get_price_in_dollars_with_two_decimals()
    {
        $membership = factory(Membership::class)->make([
           'price' => 461,
        ]);

        $this->assertSame('4.61', $membership->price_in_dollars);
    }
}

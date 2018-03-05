<?php

namespace Tests\Unit;

use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_customer_has_memberships()
    {
        $customer = factory(Customer::class)->make();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $customer->memberships
        );
    }
}

<?php

namespace tests\Unit;

use Tests\TestCase;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Order;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_order_has_a_customer()
    {
        $order = factory(Order::class)->create();

        $this->assertInstanceOf(
            Customer::class, $order->customer
        );
    }

    /** @test */
    public function a_order_has_a_membership()
    {
        $membership = factory(Order::class)->create();

        $this->assertInstanceOf(
            MembershipType::class, $membership->membershipType
        );
    }
}

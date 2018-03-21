<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_customer_has_memberships()
    {
        $customer = factory(Customer::class)->make();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $customer->memberships
        );
    }

    /** @test */
    public function a_customer_has_a_user()
    {
        $customer = factory(Customer::class)->create();

        $this->assertInstanceOf(
            User::class, $customer->user
        );
    }
}

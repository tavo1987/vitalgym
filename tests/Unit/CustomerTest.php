<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    /** @test */
    function a_customer_has_a_user()
    {
        $customer = factory(Customer::class)->create();

        $this->assertInstanceOf(
            User::class, $customer->user
        );
    }

    /** @test */
    function a_customer_load_user_relationship_by_default()
    {
        $user = $this->createNewUser();
        $customer = factory(Customer::class)->create(['user_id' => $user->id]);

        $customer = $customer->fresh();

        $this->assertContains($user->fresh()->toArray(), $customer->toArray());
    }

    /** @test */
    function a_customer_has_many_attendances()
    {
        $customer = factory(Customer::class)->make();

        $this->assertInstanceOf(Collection::class, $customer->attendances);
    }
}

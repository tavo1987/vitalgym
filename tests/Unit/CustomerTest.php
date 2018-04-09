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
    public function a_customer_has_orders()
    {
        $customer = factory(Customer::class)->make();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $customer->orders
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

    /** @test */
    public function a_customer_load_user_relationship_by_default()
    {
        $user = $this->createNewUser();
        $customer = factory(Customer::class)->create(['user_id' => $user->id]);

        $customer = $customer->fresh();

        $this->assertContains($user->fresh()->toArray(), $customer->toArray());
    }
}

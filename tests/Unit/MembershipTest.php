<?php

namespace tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Carbon;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MembershipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_membership_has_a_customer()
    {
        $membership = factory(Membership::class)->create();

        $this->assertInstanceOf(
            Customer::class, $membership->customer
        );
    }

    /** @test */
    function a_membership_has_a_membershipType()
    {
        $membership = factory(Membership::class)->create();

        $this->assertInstanceOf(
            MembershipType::class, $membership->membershipType
        );
    }

    /** @test */
    function a_membership_belongs_to_payment()
    {
        $payment = factory(Payment::class)->create();
        $membership = factory(Membership::class)->create(['payment_id' => $payment->id]);

        $this->assertInstanceOf(
            Payment::class, $membership->payment
        );

        $this->assertEquals($payment->id, $membership->payment->id);
    }

    /** @test */
    function converting_to_an_array()
    {
        $adminUser = $this->createNewUser();
        $user = factory(User::class)->create(['name' => 'Jane', 'last_name' => 'Doe', 'email' => 'jane@example.com']);
        $membershipType = factory(MembershipType::class)->create(['name' => 'Mensual', 'price' => '3000']);
        $customer = factory(Customer::class)->create(['user_id' => $user->id]);
        $dateStart = Carbon::now()->toDateString();
        $dateEnd = Carbon::now()->addMonth(1)->toDateString();

        $payment = factory(Payment::class)->create([
            'total_price' => 6000,
            'membership_quantity' => 2,
            'customer_id' => $customer->id,
            'user_id' => $adminUser->id,
        ]);

        $membership = factory(Membership::class)->create([
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'total_days' => 30,
            'customer_id' => $customer->id,
            'membership_type_id' => $membershipType->id,
            'payment_id' => $payment->id,
        ]);

        $result = $membership->toArray();

        $this->assertEquals([
            'date_start'  => $dateStart,
            'date_end'    => $dateEnd,
            'total_days'  => 30,
            'name'        => 'Mensual',
            'unit_price'  => 3000,
            'created_by' => 'John Doe',
            'total_price' => 6000,
            'membership_quantity' => 2,
            'customer' => [
                'name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane@example.com',
            ],
        ], $result);
    }
}

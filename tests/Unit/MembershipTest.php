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
    public function a_membership_has_a_customer()
    {
        $membership = factory(Membership::class)->create();

        $this->assertInstanceOf(
            Customer::class, $membership->customer
        );
    }

    /** @test */
    public function a_membership_has_a_membershipType()
    {
        $membership = factory(Membership::class)->create();

        $this->assertInstanceOf(
            MembershipType::class, $membership->membershipType
        );
    }

    /** @test */
    public function a_membership_has_a_payment()
    {
        $membership = factory(Membership::class)->create();
        $payment = factory(Payment::class)->create([
            'membership_id' => $membership->id,
        ]);

        $this->assertInstanceOf(
            Payment::class, $membership->payment
        );

        $this->assertEquals($payment->id, $membership->payment->id);
    }

    /** @test */
    public function converting_to_an_array()
    {
        $adminUser = $this->createNewUser();
        $user = factory(User::class)->create(['name' => 'Jane', 'last_name' => 'Doe', 'email' => 'jane@example.com']);
        $membershipType = factory(MembershipType::class)->create(['name' => 'Mensual', 'price' => '3000']);
        $customer = factory(Customer::class)->create(['user_id' => $user->id]);
        $dateStart = Carbon::now()->toDateString();
        $dateEnd = Carbon::now()->addMonth(1)->toDateString();
        $membership = factory(Membership::class)->create([
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'total_days' => 30,
            'customer_id' => $customer->id,
            'membership_type_id' => $membershipType->id,
        ]);

        factory(Payment::class)->create([
            'total_price' => 6000,
            'membership_quantity' => 2,
            'customer_id' => $customer->id,
            'membership_id' => $membership->id,
            'user_id' => $adminUser->id,
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

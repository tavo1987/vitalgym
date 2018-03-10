<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddMembershipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_membership_for_a_new_customer()
    {
        $this->withoutExceptionHandling();

        $user = $this->createNewUser();
        $dateStart = Carbon::parse('01-01-2018');
        $dateEnd = Carbon::parse('31-01-2018');
        $totalDays = $dateStart->diffInDays($dateEnd);

        $membershipType = factory(MembershipType::class)->create(['name' =>'mensual', 'price' => 3000]);
        $customer = factory(Customer::class)->create();

        $response = $this->actingAs($user)->post(route('admin.membership.create'), [
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'total_days' => $totalDays,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'total_payment' => 3000,
            'quantity' => 1,
        ]);

        $membership = Membership::where('customer_id', $customer->id)->get()->last();
        $payment = Payment::where('customer_id', $customer->id)->where('membership_id', $membership->id)->first();

        $response->assertStatus(201);
        $this->assertNotNull($membership);
        $this->assertEquals(30, $membership->total_days);
        $this->assertEquals($dateStart, $membership->date_start);
        $this->assertEquals($dateEnd, $membership->date_end);
        $this->assertEquals($membership->id , $payment->membership_id);
        $this->assertEquals(1, $payment->quantity);
        $this->assertEquals($customer->id, $payment->customer_id);
        $this->assertEquals(3000, $payment->total);
        $this->assertEquals($user->id, $payment->user_id);
    }
}

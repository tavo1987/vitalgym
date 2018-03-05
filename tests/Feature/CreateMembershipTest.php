<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateMembershipTest extends TestCase
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

        $response = $this->actingAs($user)->post(route('membership.create'), [
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'total_days' => $totalDays,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'total_payment' => 3000,
            'quantity' => 1,
        ]);

        $response->assertStatus(201);
        $membership = $customer->memberships()->get()->last();
        $this->assertNotNull($membership);
        //$this->assertEquals(30, $membership->total_days);
        //$this->assertEquals($membership->id, $customer->fresh()->payments()->membership_id);
        //$this->assertEquals(1, $customer->fresh()->payments()->count());
        //$this->assertEquals(3000, $customer->payments()->last()->total);
        //$this->assertEquals($user->id, $membership->payment()->user_id);
    }
}

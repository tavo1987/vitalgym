<?php

namespace Tests\Feature;

use App\Mail\MembershipConfirmationEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\VitalGym\Entities\Payment;
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
        Mail::fake();

        $user = $this->createNewUser();
        $userCustomer = $this->createNewUser(['role' => 'customer', 'email' => 'john@example.com']);

        $dateStart = Carbon::parse('2018-12-01');
        $dateEnd = Carbon::parse('2018-12-31');
        $membershipType = factory(MembershipType::class)->create(['name' =>'mensual', 'price' => 3000]);
        $customer = factory(Customer::class)->create(['user_id' => $userCustomer->id]);

        $response = $this->actingAs($user)->post(route('admin.membership.create'), [
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'quantity' => 1,
        ]);

        $membership = Membership::where('customer_id', $customer->id)->get()->last();
        $payment = Payment::where('customer_id', $customer->id)->where('membership_id', $membership->id)->first();

        $response->assertStatus(201);
        $this->assertNotNull($membership);
        $this->assertEquals(30, $membership->total_days);
        $this->assertEquals($dateStart, $membership->date_start);
        $this->assertEquals($dateEnd, $membership->date_end);
        $this->assertEquals($membership->id, $payment->membership_id);
        $this->assertEquals(1, $payment->membership_quantity);
        $this->assertEquals($customer->id, $payment->customer_id);
        $this->assertEquals(3000, $payment->total_price);
        $this->assertEquals($user->id, $payment->user_id);

        Mail::assertSent(MembershipConfirmationEmail::class, function ($mail) use ($membership) {
            return $mail->hasTo('john@example.com')
                && $mail->membership->id === $membership->id;
        });
    }
}

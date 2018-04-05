<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\Customer;
use Illuminate\Support\Facades\Mail;
use App\Mail\MembershipConfirmationEmail;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AddMembershipTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

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
            'quantity' => 2,
        ]);

        $response->assertStatus(201);
        $membership = $customer->memberships->fresh()->last();
        $this->assertNotNull($membership);
        $payment = Payment::where('customer_id', $customer->id)->where('membership_id', $membership->id)->first();
        $this->assertEquals(30, $membership->total_days);
        $this->assertEquals($dateStart, $membership->date_start);
        $this->assertEquals($dateEnd, $membership->date_end);
        $this->assertEquals($membership->id, $payment->membership_id);
        $this->assertEquals(2, $payment->membership_quantity);
        $this->assertEquals($customer->id, $payment->customer_id);
        $this->assertEquals(6000, $payment->total_price);
        $this->assertEquals($user->id, $payment->user_id);

        Mail::assertSent(MembershipConfirmationEmail::class, function ($mail) use ($membership) {
            return $mail->hasTo('john@example.com')
                && $mail->membership->id === $membership->id;
        });
    }
}

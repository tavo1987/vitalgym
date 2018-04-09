<?php

namespace Tests\Feature;

use App\Mail\MembershipOrderConfirmationEmail;
use Carbon\Carbon;
use Tests\TestCase;
use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\Customer;
use Illuminate\Support\Facades\Mail;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AddMembershipTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /** @test */
    public function create_order_for_a_new_customer()
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
        $order= $customer->orders->fresh()->last();
        $this->assertNotNull($order);
        $payment = Payment::where('customer_id', $customer->id)->where('order_id', $order->id)->first();
        $this->assertEquals(30, $order->total_days);
        $this->assertEquals($dateStart, $order->date_start);
        $this->assertEquals($dateEnd, $order->date_end);
        $this->assertEquals($order->id, $payment->order_id);
        $this->assertEquals(2, $payment->membership_quantity);
        $this->assertEquals($customer->id, $payment->customer_id);
        $this->assertEquals(6000, $payment->total_price);
        $this->assertEquals($user->id, $payment->user_id);

        Mail::assertSent(MembershipOrderConfirmationEmail::class, function ($mail) use ($order) {
            return $mail->hasTo('john@example.com')
                && $mail->order->id === $order->id;
        });
    }
}

<?php

namespace tests\Unit\Mail;

use Tests\TestCase;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Order;
use App\Mail\MembershipOrderConfirmationEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MembershipConfirmationEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_contain_the_customer_name()
    {
        $user = factory(User::class)->create([
           'name' => 'John',
        ]);

        $customer = factory(Customer::class)->create([
            'user_id' => $user->id,
        ]);

        $order = factory(Order::class)->create([
            'customer_id' => $customer->id,
        ]);

        $email = new MembershipOrderConfirmationEmail($order);
        $rendered = $email->render();

        $this->assertContains('John', $rendered);
    }
}

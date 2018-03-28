<?php

namespace tests\Unit\Mail;

use Tests\TestCase;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Membership;
use App\Mail\MembershipConfirmationEmail;

class MembershipConfirmationEmailTest extends TestCase
{
    /** @test */
    public function email_contain_the_customer_name()
    {
        $customer = factory(Customer::class)->make([
            'name' => 'John',
        ]);
        $membership = factory(Membership::class)->make([
            'customer_id' => $customer->id,
        ]);

        $email = new MembershipConfirmationEmail($membership);
        $rendered = $email->render();

        $this->assertContains('John', $rendered);
    }
}

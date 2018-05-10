<?php

namespace tests\Unit;

use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_payment_belongs_to_a_user()
    {
        $payment = factory(Payment::class)->create();

        $this->assertInstanceOf(
        	User::class, $payment->user
        );
    }
}

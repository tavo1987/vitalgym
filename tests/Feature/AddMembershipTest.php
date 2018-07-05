<?php

namespace Tests\Feature;

use App\VitalGym\Entities\Membership;
use Carbon\Carbon;
use Tests\TestCase;
use App\VitalGym\Entities\Customer;
use Illuminate\Support\Facades\Mail;
use App\VitalGym\Entities\MembershipType;
use App\Mail\MembershipOrderConfirmationEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddMembershipTest extends TestCase
{
    use RefreshDatabase;

    private $adminUser;

    public function setUp()
    {
        parent::setUp();
        $this->adminUser = $this->createNewUser();
    }

    private function orderMembership($params = [])
    {
        return $this->actingAs($this->adminUser)->post(route('admin.membership.store'), $params);
    }
    
    /** @test */
    function admins_can_view_the_add_membership_form()
    {
        $this->withoutExceptionHandling();
        $customers = factory(Customer::class)->times(5)->create();
        $membershipTypes = factory(MembershipType::class)->times(3)->create();

        $response = $this->actingAs($this->adminUser)->get(route('admin.membership.create'));

        $response->assertSuccessful();
        $customers->assertEquals($response->data('customers'));
        $membershipTypes->assertEquals($response->data('membershipTypes'));
        $response->assertViewIs('admin.memberships.create');
    }

    /** @test */
    function add_membership_for_a_new_customer()
    {
        $this->withoutExceptionHandling();
        Mail::fake();

        $customerUser = $this->createNewUser([
            'name' =>'John',
            'last_name' => 'Doe',
            'role' => 'customer',
            'email' => 'john@example.com',
        ]);

        $dateStart = Carbon::now()->toDateString();
        $dateEnd = Carbon::now()->addMonth(1)->toDateString();

        $membershipType = factory(MembershipType::class)->create(['name' =>'Mensual', 'price' => 3000]);
        $customer = factory(Customer::class)->create(['user_id' => $customerUser->id]);

        $response = $this->orderMembership([
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $membership = $customer->memberships->fresh()->last();
        $this->assertNotNull($membership);
        $response->assertRedirect(route('memberships.index'));

        $response->assertSessionHas('message');
        $response->assertSessionHas('alert-type', 'success');
        $this->assertEquals(30, $membership->total_days);
        $this->assertEquals($dateStart, $membership->date_start->toDateString());
        $this->assertEquals($dateEnd, $membership->date_end->toDateString());
        $this->assertEquals($membership->id, $membership->payment->membership_id);
        $this->assertEquals(2, $membership->payment->membership_quantity);
        $this->assertEquals($customer->id, $membership->payment->customer_id);
        $this->assertEquals(6000, $membership->payment->total_price);
        $this->assertEquals($this->adminUser->id, $membership->payment->user_id);

        Mail::assertSent(MembershipOrderConfirmationEmail::class, function ($mail) use ($membership) {
            return $mail->hasTo('john@example.com')
                && $mail->membership->id === $membership->id;
        });
    }

    /** @test */
    function date_start_is_required_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();

        $response = $this->orderMembership([
            'date_end' => Carbon::now()->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->status(302);
        $response->assertSessionHasErrors('date_start');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function date_start_must_be_a_valid_date_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();

        $response = $this->orderMembership([
            'date_start' => 'invalid-start-date',
            'date_end' => Carbon::now()->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('date_start');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function date_start_must_be_greater_or_equal_than_the_current_date_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();

        $response = $this->orderMembership([
            'date_start' => '1998-06-05',
            'date_end' => Carbon::now()->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('date_start');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function date_start_must_have_the_following_format_yyyy_mm_dd_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();

        $response = $this->orderMembership([
            'date_start' => Carbon::now()->format('d-m-Y'),
            'date_end' => Carbon::now()->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('date_start');
        $this->assertEquals(0, Membership::count());

    }

    /** @test */
    function date_end_is_required_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();

        $response = $this->orderMembership([
            'date_start' => Carbon::now()->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('date_end');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function date_end_must_be_a_valid_date_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();

        $response = $this->orderMembership([
            'date_start' => Carbon::now()->toDateString(),
            'date_end' => 'invalid-end-date',
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('date_end');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function date_end_must_have_the_following_format_yyyy_mm_dd_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();

        $response = $this->orderMembership([
            'date_start' => Carbon::now()->toDateString(),
            'date_end' => Carbon::now()->format('d-m-Y'),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('date_end');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function the_end_date_must_be_greater_or_equal_than_start_date_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->subDays(10)->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('date_end');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function the_total_days_must_be_integer()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'total_days' => 'invalid-number-days',
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('total_days');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function the_total_days_must_be_required_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('total_days');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function total_days_must_be_at_least_1_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'total_days' => 0,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('total_days');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function membership_type_is_required_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $customer = factory(Customer::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'total_days' => 30,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('membership_type_id');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function membership_type_must_exist_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $customer = factory(Customer::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'total_days' => 30,
            'membership_type_id' => 101,
            'customer_id' => $customer->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('membership_type_id');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function the_customer_is_required_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('customer_id');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function customer_must_exist_to_create_a_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => 1,
            'membership_quantity' => 2,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('customer_id');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function membership_quantity_is_required_to_create_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('membership_quantity');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function membership_quantity_must_be_a_integer_to_create_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 'invalid-membership-quantity',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('membership_quantity');
        $this->assertEquals(0, Membership::count());
    }

    /** @test */
    function membership_quantity_must_be_at_least_1_to_create_membership()
    {
        $this->withExceptionHandling();
        $membershipType = factory(MembershipType::class)->create();
        $customer = factory(Customer::class)->create();
        $date = Carbon::now();

        $response = $this->orderMembership([
            'date_start' => $date->toDateString(),
            'date_end' => $date->addDays(30)->toDateString(),
            'total_days' => 30,
            'membership_type_id' => $membershipType->id,
            'customer_id' => $customer->id,
            'membership_quantity' => 0,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('membership_quantity');
        $this->assertEquals(0, Membership::count());
    }
}

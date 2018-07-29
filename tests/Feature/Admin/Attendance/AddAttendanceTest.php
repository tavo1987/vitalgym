<?php

namespace Tests\Feature\Admin\Attendance;

use App\VitalGym\Entities\Attendance;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAttendanceTest extends TestCase
{
    use RefreshDatabase;

    private $customer;
    private $date;

    private function  validParams($overrides = [])
    {
        $this->customer = factory(Customer::class)->create();
        $this->date = now()->parse('2017-11-23');
        return array_merge([
            'date' => $this->date->format('Y-m-d H:i:s'),
            'customer_id' => $this->customer->id
        ], $overrides);
    }

   /** @test */
   function an_admin_can_view_the_form_to_create_a_new_attendance()
   {
       $this->withoutExceptionHandling();
       $adminUser = factory(User::class)->states('admin', 'active')->create();
       factory(Customer::class)->times(4)->create();

       $response = $this->be($adminUser)->get(route('admin.attendances.create'));

       $response->assertSuccessFul();
       $expectedCustomers = Customer::orderByDesc('id')->paginate();
       $response->assertViewIs('admin.attendances.create');
       $response->assertViewHas('customers', $expectedCustomers);
   }

   /** @test */
   function an_admin_can_create_an_attendance()
   {
       $this->withoutExceptionHandling();
       $adminUser = factory(User::class)->states('admin', 'active')->create();

       $response = $this->be($adminUser)->post(route('admin.attendances.store'), $this->validParams());

       $response->assertRedirect(route('admin.attendances.index'));
       tap(Attendance::first(), function ($attendance) {
           $this->assertEquals('2017-11-23', $attendance->date->toDateString());
           $this->assertEquals($this->customer->id, $attendance->customer_id);
       });
       $response->assertSessionHas('alert-type', 'success');
       $response->assertSessionHas('message');
   }

   /** @test */
   function date_is_required()
   {
       $adminUser = factory(User::class)->states('admin', 'active')->create();

       $response = $this->be($adminUser)->from(route('admin.attendances.create'))->post(route('admin.attendances.store'), $this->validParams([
           'date' => '',
       ]));

        $response->assertRedirect(route('admin.attendances.create'));
        $response->assertSessionHasErrors('date');
        $this->assertEquals(0, Attendance::count());
   }

    /** @test */
    function date_must_be_a_valid_date()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.attendances.create'))->post(route('admin.attendances.store'), $this->validParams([
            'date' => 'invalid-date',
        ]));

        $response->assertRedirect(route('admin.attendances.create'));
        $response->assertSessionHasErrors('date');
        $this->assertEquals(0, Attendance::count());
    }

    /** @test */
    function date_must_have_a_valid_format()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.attendances.create'))->post(route('admin.attendances.store'), $this->validParams([
            'date' => '2018-12-31',
        ]));

        $response->assertRedirect(route('admin.attendances.create'));
        $response->assertSessionHasErrors('date');
        $this->assertEquals(0, Attendance::count());
    }

    /** @test */
    function date_must_be_less_than_today()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.attendances.create'))->post(route('admin.attendances.store'), $this->validParams([
            'date' => now()->addDays(2)->format('Y-m-d H:i:s'),
        ]));

        $response->assertRedirect(route('admin.attendances.create'));
        $response->assertSessionHasErrors('date');
        $this->assertEquals(0, Attendance::count());
    }

    /** @test */
    function customer_id_is_required()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.attendances.create'))->post(route('admin.attendances.store'), $this->validParams([
            'customer_id' => '',
        ]));

        $response->assertRedirect(route('admin.attendances.create'));
        $response->assertSessionHasErrors('customer_id');
        $this->assertEquals(0, Attendance::count());
    }

    /** @test */
    function customer_id_must_be_exist()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.attendances.create'))->post(route('admin.attendances.store'), $this->validParams([
            'customer_id' => '9999',
        ]));

        $response->assertRedirect(route('admin.attendances.create'));
        $response->assertSessionHasErrors('customer_id');
        $this->assertEquals(0, Attendance::count());
    }
}

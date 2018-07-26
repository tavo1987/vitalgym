<?php

namespace Tests\Feature\Admin;

use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAttendanceTest extends TestCase
{
    use RefreshDatabase;

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
}

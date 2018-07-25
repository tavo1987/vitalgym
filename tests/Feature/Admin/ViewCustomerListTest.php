<?php

namespace Tests\Feature;

use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCustomerListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_the_list_of_customers()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(User::class)->states('admin', 'active')->create();
        factory(Customer::class)->times(5)->create();

        $response = $this->be($adminUser)->get(route('admin.customers.index'));

        $response->assertSuccessful();
        $expectedCustomers = Customer::with('user')->paginate();
        $response->assertViewIs('admin.customers.index');
        $response->assertViewHas('customers', $expectedCustomers);
    }
}

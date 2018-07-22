<?php

namespace Tests\Feature\Admin;

use App\VitalGym\Entities\Level;
use App\VitalGym\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_the_form_to_create_a_customer()
    {
        $this->withoutExceptionHandling();

        $adminUser = factory(User::class)->states('admin', 'active')->create();
        $levels = factory(Level::class)->times(3)->create();

        $response = $this->be($adminUser)->get(route('admin.customers.create'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.customers.create');
        $levels->assertEquals($response->data('levels'));
    }

}

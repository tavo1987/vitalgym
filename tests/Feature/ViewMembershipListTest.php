<?php

namespace Tests\Feature;

use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\User;
use Faker\Provider\Payment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewMembershipListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_the_membership_list()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $memberships = factory(Membership::class)->times(10)->create();

        $response = $this->be($adminUser)->get(route('admin.memberships.index'));

        $response->assertSuccessful();
        $memberships->assertEquals($response->data('memberships'));
    }
}

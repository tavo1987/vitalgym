<?php

namespace Tests\Feature;

use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewMembershipListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_the_list_of_memberships()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(User::class)->states('admin', 'active')->create();
        factory(Membership::class)->times(5)->create();

        $response = $this->be($adminUser)->get(route('admin.memberships.index'));

        $response->assertSuccessful();
        $expectedMemberships = Membership::with('customer', 'plan')->paginate();
        $response->assertViewIs('admin.memberships.index');
        $response->assertViewHas('memberships', $expectedMemberships);
    }
}

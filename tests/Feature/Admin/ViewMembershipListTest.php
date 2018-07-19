<?php

namespace Tests\Feature;

use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\Plan;
use App\VitalGym\Entities\User;
use illuminate\Pagination\LengthAwarePaginator;
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
        $memberships = factory(Membership::class)->times(10)->create();

        $response = $this->be($adminUser)->get(route('admin.memberships.index'));

        $response->assertSuccessful();
        $response->assertViewHas('memberships');
        $response->assertViewIs('admin.memberships.index');
        $response->data('memberships')->assertEquals($memberships);

        $this->assertInstanceOf(LengthAwarePaginator::class, $response->data('memberships'));
    }
}

<?php

namespace Tests\Feature;

use App\VitalGym\Entities\User;
use Tests\TestCase;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewMembershipTypesListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_the_membership_types_list()
    {
        $userAdmin = factory(User::class)->states('admin', 'active')->create();

        $membershipsTypes =  factory(MembershipType::class)->times(3)->create();

        $response = $this->be($userAdmin)->get(route('admin.membership-types'));

        $response->assertSuccessful();
        $membershipsTypes->assertEquals($response->data('membershipTypes'));
    }
}

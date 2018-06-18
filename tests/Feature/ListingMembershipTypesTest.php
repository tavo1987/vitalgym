<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListingMembershipTypesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function listing_membership_types()
    {
        $user = $this->createNewUser();

        $membershipsTypes =  factory(MembershipType::class)->times(3)->create();

        $response = $this->actingAs($user)->get(route('admin.membership-types'));

        $response->assertSuccessful();
        $membershipsTypes->assertEquals($response->data('membershipTypes'));
    }
}

<?php

namespace Tests\Feature;

use App\VitalGym\Entities\User;
use Tests\TestCase;
use App\VitalGym\Entities\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewPlansListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admin_can_view_plans_list_page()
    {
        $this->withoutExceptionHandling();

        $userAdmin = factory(User::class)->states('admin', 'active')->create();

        $membershipsTypes =  factory(Plan::class)->times(3)->create();

        $response = $this->be($userAdmin)->get(route('admin.plans.index'));

        $response->assertSuccessful();
        $membershipsTypes->assertEquals($response->data('plans'));
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_active_user_can_visit_the_home_page_and_view_his_basic_profile_data()
    {
        $this->withoutExceptionHandling();
        $user = $this->createNewUser();

        $response = $this->actingAs($user)
            ->get('/');

        $response->isOk();
        $response->assertSee($user->full_name);
        $response->assertSee($user->avatar);
    }
}

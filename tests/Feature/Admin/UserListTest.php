<?php

namespace Tests\Feature\Admin;

use App\VitalGym\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_admin_can_view_the_users_list()
    {
        $this->withoutExceptionHandling();

        $userAdmin = factory(User::class)->states('admin', 'active')->create();
        $users = factory(User::class)->times(10)->create();

        $response = $this->be($userAdmin)->get(route('admin.users.index'));

        $response->assertViewHas('users');
    }
}

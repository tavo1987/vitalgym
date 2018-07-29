<?php

namespace Tests\Feature;

use App\VitalGym\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   function an_admin_can_view_the_page_to_edit_his_profile()
   {
       $this->withoutExceptionHandling();
       $adminUser = factory(User::class)->states('admin', 'active')->create();

       $response = $this->be($adminUser)->get(route('admin.admin-profile.edit'));

       $response->assertSuccessFul();
       $this->assertTrue($response->data('user')->is($adminUser));
   }
}

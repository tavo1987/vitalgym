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

        //Arrange
        //Administrador
        $userAdmin = factory(User::class)->states('admin', 'active')->create();
        //Crear usuarios
        $users = factory(User::class)->times(10)->create();


        //Act
        //Visitar la url listar usuarios
        $response = $this->be($userAdmin)->get(route('admin.users.index'));

        //Assertions
        //Successful
        $response->assertSuccessful();
        //Afirmar que paso a la vista los usuarios
        $users->assertEquals($response->data('users'));
    }
}

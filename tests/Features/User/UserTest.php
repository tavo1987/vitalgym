<?php

namespace Tests\Features\User;

use BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_user_list()
    {
        $user = $this->createNewUser();

        $this->actingAs($user)
            ->visit(route('users.index'));

        $this->seeText('Lista de Usuarios')
            ->seeText('tavo198718@gmail.com')
            ->seeText('activo')
            ->seeText('admin')
            ->seeText('last login');
    }
}

<?php

namespace tests\Unit\User;

use Tests\TestCase;
use App\VitalGym\Entities\User;
use App\VitalGym\Services\User\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function makeService()
    {
        return app(UserService::class);
    }

    /** @test **/
    public function it_can_list_all_users()
    {
        $service = $this->makeService();
        factory(User::class, 10)->create();

        $newUsers = $service->paginateusers();

        $this->assertInstanceOf(LengthAwarePaginator::class, $newUsers);
        $this->assertEquals(10, $newUsers->count());
    }

    /** @test **/
    public function it_can_create_new_user_with_profile()
    {
        $service = $this->makeService();
        $user = (object) [
            'name'      => 'Edwin',
            'last_name' => 'Ramírez',
            'nick_name' => 'tavo',
            'avatar'    => 'https://s3-us-west-2.amazonaws.com/vitalgym/avatars/default-avatar.jpg',
            'address'   => 'Fake address',
            'email'     => 'tavo198718@gmail.com',
            'password'  => bcrypt('secret'),
            'role'      => 'admin',
            'active'    => 1,
        ];

        $service->create($user);

        $this->assertDatabaseHas('users', [
            'email'     => 'tavo198718@gmail.com',
            'role'      => 'admin',
            'active'    => 1,
        ]);

        $this->assertDatabaseHas('profiles', [
            'name'      => 'Edwin',
            'last_name' => 'Ramírez',
            'nick_name' => 'tavo',
            'avatar'    => 'https://s3-us-west-2.amazonaws.com/vitalgym/avatars/default-avatar.jpg',
            'address'   => 'Fake address',
        ]);

        $this->getStatus(200);
    }
}

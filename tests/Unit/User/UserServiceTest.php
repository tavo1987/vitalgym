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

    public function test_it_can_list_all_users()
    {
        $service = $this->makeService();
        factory(User::class, 10)->create();

        $newUsers = $service->paginateusers();

        $this->assertInstanceOf(LengthAwarePaginator::class, $newUsers);
        $this->assertEquals(10, $newUsers->count());
    }
}

<?php

namespace tests\Unit\User;

use App\VitalGym\Entities\User;
use App\VitalGym\Services\User\UserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

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

        $newUsers = $service->paginateusers();

        $this->assertInstanceOf(LengthAwarePaginator::class, $newUsers);
    }
}
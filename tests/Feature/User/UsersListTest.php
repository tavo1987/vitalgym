<?php

namespace Tests\Features\User;

use Tests\TestCase;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Profile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersListTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function list_users()
    {
        $user = $this->createNewUser();

        $otherUser = $this->createNewUser([
            'email'     => 'john@gmail.com',
            'password' => bcrypt('secret'),
            'active'   => true,
            'role' => 'admin',
            'last_login' => '2017-08-20 04:15:00',
        ]);

        factory(Profile::class)->create([
            'name' => 'John',
            'last_name' => 'Doe',
            'nick_name' => 'doe',
            'avatar' => 'default-avatar.jpg',
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('users.index'));

        $response->assertStatus(200)
            ->assertSeeText('Usuarios');
    }

    /** @test **/
    public function the_users_are_paginated_and_sorted_by_id_in_descending_order()
    {
        $user = $this->createNewUser();

        factory(User::class, 20)
            ->create()
            ->each(function ($user) {
                factory(Profile::class)->create([
               'user_id' => $user->id,
            ]);
            });

        $response = $this->actingAs($user)->json('GET', '/api/v1/users');

        $users = User::with('profile')->orderBy('id', 'DESC')->get()->take(15)->toArray();

        $response->assertStatus(200)
            ->assertJson([
                'current_page'  => 1,
                'total'         => 21,
                'per_page'      => 15,
                'last_page'     => 2,
                'next_page_url' => config('app.url').'/api/v1/users?page=2',
                'prev_page_url' => null,
                'from'          => 1,
                'to'            => 15,
                'data'          => $users,
            ]);
    }
}

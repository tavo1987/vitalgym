<?php

namespace Tests\Features\User;

use App\VitalGym\Entities\User;
use Carbon\Carbon;
use Tests\TestCase;
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
            ->assertSeeText('Usuarios')
            ->assertSeeText($otherUser->profile->name)
            ->assertSeeText($otherUser->profile->last_name)
            ->assertSeeText($otherUser->profile->nick_name)
            ->assertSee($otherUser->profile->avatar)
            ->assertSeeText($otherUser->email)
            ->assertSeeText($otherUser->email)
            ->assertSeeText($otherUser->email)
            ->assertSeeText($otherUser->role)
            ->assertSeeText('activo');
    }

    /** @test **/
    public function the_users_are_paginated()
    {
        $this->withoutExceptionHandling();
        $user = $this->createNewUser(['created_at' => Carbon::now()->subDays(2)]);

        factory(User::class, 20)
            ->create()
            ->each(function ($user) {
            factory(Profile::class)->create([
               'user_id' => $user->id
            ]);
        });

        $response = $this->actingAs($user)->json('GET', route('users.index'));

        $response->assertStatus(200);
            /*->assertJson([
                'current_page'=> 1,
                'total' => 21,
                'per_page' => 15,
                "last_page" => 2,
                "next_page_url" => config('app.url').'/admin/users?page=2',
                "prev_page_url" => null,
                "from" => 1,
                "to" => 2,
            ]);*/
    }

}

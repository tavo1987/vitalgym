<?php

namespace Tests\Integration\User;

use App\VitalGym\Entities\Profile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_list_users()
    {
        $this->disableExceptionHandling();

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
            'user_id' => $otherUser->id
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
}

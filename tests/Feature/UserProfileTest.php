<?php

namespace Tests\Feature;

use App\VitalGym\Entities\User;
use Tests\TestCase;
use Storage;
use Hash;
use Illuminate\Http\Testing\File;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    private $file;

    public function setUp()
    {
        parent::setUp();

        Storage::fake('public');
        $this->file = File::image('john.jpg', 160, 160);
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'ci' => '0926687856',
            'avatar' => $this->file,
            'phone' => '2695755',
            'cell_phone' => '0123456789',
            'address' => 'Fake address',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ], $overrides);
    }

    /** @test */
    function an_admin_can_view_the_page_to_edit_his_profile()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->get(route('admin.profile.edit'));

        $response->assertSuccessFul();
        $this->assertTrue($response->data('user')->is($adminUser));
    }

   /** @test */
   function an_admin_can_edit_his_profile()
   {
       $this->withoutExceptionHandling();

       $adminUser = factory(User::class)->states('customer', 'active')->create([
           'name' => 'John',
           'last_name' => 'Doe',
           'email' => 'john@example.com',
           'avatar' => $this->file,
           'phone' => '2695755',
           'cell_phone' => '0123456789',
           'address' => 'Fake address',
           'password' => 'secret',
       ]);

       $newImage = File::image('new-avatar.jpg', 160, 160);

       $response = $this->be($adminUser)->from(route('admin.profile.edit'))->patch(route('admin.profile.update'), [
           'name' => 'Jane',
           'last_name' => 'Eyre',
           'email' => 'jane@example.com',
           'avatar' => $newImage,
           'phone' => '02261666',
           'cell_phone' => '0968679735',
           'address' => 'New address',
           'password' => 'laravel',
           'password_confirmation' => 'laravel',
       ]);

       $response->assertRedirect(route('admin.profile.edit'));
       tap(User::first(), function ( $user ) use ( $newImage ){
           $this->assertEquals('Jane', $user->name);
           $this->assertEquals('Eyre', $user->last_name);
           $this->assertEquals('jane@example.com', $user->email);
           $this->assertNotNull($user->avatar);
           Storage::disk('public')->assertExists($user->avatar);
           $this->assertFileEquals($newImage->getPathname(), Storage::disk('public')->path($user->avatar));
           $this->assertEquals('02261666', $user->phone);
           $this->assertEquals('0968679735', $user->cell_phone);
           $this->assertEquals('New address', $user->address);
           $this->assertTrue(Hash::check('laravel', $user->password));
       });
       $response->assertSessionHas('alert-type', 'success');
       $response->assertSessionHas('message');
   }

}

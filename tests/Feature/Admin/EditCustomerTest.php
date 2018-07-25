<?php

namespace Tests\Feature\Admin;

use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Level;
use App\VitalGym\Entities\Routine;
use App\VitalGym\Entities\User;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditCustomerTest extends TestCase
{
    use RefreshDatabase;

    private $file;
    private $routine;
    private $level;

    public function setUp()
    {
        parent::setUp();

        Storage::fake('public');
        $this->file = File::image('john.jpg', 160, 160);
    }

    private function validParams($overrides = [])
    {
        $this->level = factory(Level::class)->create();
        $this->routine = factory(Routine::class)->create(['level_id' => $this->level->id]);

        return array_merge([
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'ci' => '0926687856',
            'avatar' => $this->file,
            'phone' => '2695755',
            'cell_phone' => '0123456789',
            'address' => 'Fake address',
            'birthdate' => '1987-12-09',
            'gender' => 'masculino',
            'medical_observations' => 'Problemas del corazón',
            'routine_id' => $this->routine->id,
            'level_id' => $this->level->id,
        ], $overrides);
    }

    /** @test */
    function an_admin_can_view_the_form_to_edit_a_customer()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(User::class)->states('admin', 'active')->create();
        $levels = factory(Level::class)->times(3)->create();
        $routine = factory(Routine::class)->create(['level_id' => $levels->first()->id]);
        $customer = factory(Customer::class)->create(['level_id' => $levels->first()->id, 'routine_id' => $routine->id]);

        $response = $this->be($adminUser)->get(route('admin.customers.edit', $customer));

        $response->assertSuccessful();
        $response->assertViewIs('admin.customers.edit');
        $this->assertTrue($response->data('customer')->is($customer));
        $this->assertTrue($response->data('routine')->is($routine));
        $this->assertTrue($response->data('level')->is($levels->first()));
        $levels->assertEquals($response->data('levels'));
    }

    /** @test */
    function an_admin_can_edit_a_customer()
    {
        $userAdmin = factory(User::class)->states('admin', 'active')->create();

        $levels = factory(Level::class)->times(3)->create();
        $routine = factory(Routine::class)->create(['level_id' => $levels->first()->id]);
        $newRoutine = factory(Routine::class)->create(['level_id' => $levels->last()->id]);
        $user = factory(User::class)->states('customer', 'active')->create([
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'avatar' => $this->file,
            'phone' => '2695755',
            'cell_phone' => '0123456789',
            'address' => 'Fake address',
            'password' => 'secret',
        ]);

        $customer = factory(Customer::class)->create([
            'ci' => '0926687856',
            'birthdate' => '1987-12-09',
            'gender' => 'masculino',
            'medical_observations' => 'Problemas del corazón',
            'level_id' => $levels->first()->id,
            'routine_id' => $routine->id,
            'user_id' =>$user->id
        ]);
        $newImage = File::image('new-avatar.jpg', 160, 160);

        $response = $this->be($userAdmin)->patch(route('admin.customers.update', $customer), [
            'name' => 'Jane',
            'last_name' => 'Eyre',
            'email' => 'jane@example.com',
            'avatar' => $newImage,
            'phone' => '02261666',
            'cell_phone' => '0968679735',
            'address' => 'New address',
            'password' => 'laravel',
            'ci' => '1723468565',
            'birthdate' => '1988-12-09',
            'gender' => 'femenino',
            'medical_observations' => 'Problemas respiratorios',
            'routine_id' => $newRoutine->id,
            'level_id' => $levels->last()->id,
        ]);

        $response->assertRedirect(route('admin.customers.index'));
        $customer = Customer::first();
        $this->assertEquals('Jane', $customer->user->name);
        $this->assertEquals('Eyre', $customer->user->last_name);
        $this->assertEquals('jane@example.com', $customer->user->email);
        $this->assertNotNull($customer->avatar);
        Storage::disk('public')->assertExists($customer->avatar);
        $this->assertFileEquals($newImage->getPathname(), Storage::disk('public')->path($customer->avatar));
        $this->assertEquals('02261666', $customer->user->phone);
        $this->assertEquals('0968679735', $customer->user->cell_phone);
        $this->assertEquals('New address', $customer->user->address);
        $this->assertTrue(Hash::check('laravel', $customer->user->password));
        $this->assertEquals('1723468565', $customer->ci);
        $this->assertEquals('1988-12-09', $customer->birthdate->toDateString());
        $this->assertEquals('femenino', $customer->gender);
        $this->assertEquals('Problemas respiratorios', $customer->medical_observations);
        $this->assertEquals($newRoutine->id, $customer->routine_id);
        $this->assertEquals($levels->last()->id, $customer->level_id);
        $this->assertEquals('Problemas respiratorios', $customer->medical_observations);
        $response->assertSessionHas('alert-type', 'success');
        $response->assertSessionHas('message');
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Mail\CustomerWelcomeEmail;
use App\VitalGym\Entities\ActivationToken;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\Level;
use App\VitalGym\Entities\Routine;
use App\VitalGym\Entities\User;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCustomerTest extends TestCase
{
    use RefreshDatabase;

    private $file;
    private $routine;
    private $level;
    private $user;

    public function setUp()
    {
        parent::setUp();

        Mail::fake();
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
    function an_admin_can_view_the_form_to_create_a_customer()
    {
        $this->withoutExceptionHandling();

        $adminUser = factory(User::class)->states('admin', 'active')->create();
        $levels = factory(Level::class)->times(3)->create();

        $response = $this->be($adminUser)->get(route('admin.customers.create'));

        $response->assertSuccessful();
        $response->assertViewIs('admin.customers.create');
        $levels->assertEquals($response->data('levels'));
    }
    
    /** @test */
    function an_admin_can_create_a_new_customer()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->post(route('admin.customers.store'), $this->validParams());

        $response->assertRedirect(route('admin.customers.index'));
        $customer = Customer::first();
        $this->assertEquals('John', $customer->name);
        $this->assertEquals('Doe', $customer->last_name);
        $this->assertNotNull($customer->avatar);
        Storage::disk('public')->assertExists($customer->avatar);
        $this->assertFileEquals($this->file->getPathname(), Storage::disk('public')->path($customer->avatar));
        $this->assertEquals('john@example.com', $customer->email);
        $this->assertEquals('0926687856', $customer->ci);
        $this->assertEquals('2695755', $customer->user->phone);
        $this->assertEquals('0123456789', $customer->user->cell_phone);
        $this->assertEquals('Fake address', $customer->user->address);
        $this->assertEquals('customer', $customer->user->role);
        $this->assertFalse((boolean) $customer->user->active);
        $this->assertEquals('1987-12-09', $customer->birthdate->toDateString());
        $this->assertEquals('masculino', $customer->gender);
        $this->assertEquals('Problemas del corazón', $customer->medical_observations);
        $this->assertEquals($this->routine->id, $customer->routine->id);
        $this->assertEquals($this->level->id, $customer->level->id);
        $this->assertTrue( (boolean) $customer->has('user') );
        $this->assertEquals(1, Customer::count());
        $response->assertSessionHas('alert-type', 'success');
        $response->assertSessionHas('message');

        $this->assertInstanceOf(ActivationToken::class,  $customer->user->token);

        Mail::assertQueued(CustomerWelcomeEmail::class, function ( $mail ) use ( $customer ) {
           return $mail->hasTo('john@example.com')
                  && $mail->customer->id = $customer->id;
        });
    }
}

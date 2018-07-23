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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddCustomerTest extends TestCase
{
    use RefreshDatabase;

    private $file;
    private $routine;
    private $level;

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
    
    /** @test */
    function name_is_required()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'name' => ''
        ]));

        $response->assertRedirect(route('admin.customers.create'));
        $response->assertSessionHasErrors('name');
        $this->assertEquals(0, Customer::count());
        Mail::assertNotQueued(CustomerWelcomeEmail::class);
    }

    /** @test */
    function name_must_have_a_maximum_of_80_characters()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'name' => str_random(81)
        ]));

        $response->assertRedirect(route('admin.customers.create'));
        $response->assertSessionHasErrors('name');
        $this->assertEquals(0, Customer::count());
        Mail::assertNotQueued(CustomerWelcomeEmail::class);
    }

    /** @test */
    function last_name_is_required()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'last_name' => ''
        ]));

        $response->assertRedirect(route('admin.customers.create'));
        $response->assertSessionHasErrors('last_name');
        $this->assertEquals(0, Customer::count());
        Mail::assertNotQueued(CustomerWelcomeEmail::class);
    }

    /** @test */
    function last_name_must_have_a_maximum_of_100_characters()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'last_name' => str_random(101)
        ]));

        $response->assertRedirect(route('admin.customers.create'));
        $response->assertSessionHasErrors('last_name');
        $this->assertEquals(0, Customer::count());
        Mail::assertNotQueued(CustomerWelcomeEmail::class);
    }

    /** @test */
    function email_is_required()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'email' => ''
        ]));

        $response->assertRedirect(route('admin.customers.create'));
        $response->assertSessionHasErrors('email');
        $this->assertEquals(0, Customer::count());
        Mail::assertNotQueued(CustomerWelcomeEmail::class);
    }

    /** @test */
    function email_must_be_a_valid_email()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'email' => 'invalid-email'
        ]));

        $response->assertRedirect(route('admin.customers.create'));
        $response->assertSessionHasErrors('email');
        $this->assertEquals(0, Customer::count());
        Mail::assertNotQueued(CustomerWelcomeEmail::class);
    }

    /** @test */
    function ci_is_optional()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(User::class)->states('admin', 'active')->create();
        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'ci' => ''
        ]));

        $response->assertRedirect(route('admin.customers.index'));

        $this->assertEquals(1, Customer::count());
        $response->assertSessionHas('alert-type', 'success');
        $response->assertSessionHas('message');
    }

    /** @test */
    function ci_must_be_a_valid_ci()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'ci' => '123456'
        ]));

        $response->assertRedirect(route('admin.customers.create'));
        $response->assertSessionHasErrors('ci');
        $this->assertEquals(0, Customer::count());
        Mail::assertNotQueued(CustomerWelcomeEmail::class);
    }

    /** @test */
    function avatar_is_optional()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(User::class)->states('admin', 'active')->create();
        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'avatar' => ''
        ]));

        $response->assertRedirect(route('admin.customers.index'));

        $this->assertEquals(1, Customer::count());
        $response->assertSessionHas('alert-type', 'success');
        $response->assertSessionHas('message');
    }

    /** @test */
    function avatar_must_be_an_image()
    {
        $adminUser = factory(User::class)->states('admin', 'active')->create();

        $response = $this->be($adminUser)->from(route('admin.customers.create'))->post(route('admin.customers.store'), $this->validParams([
            'avatar' =>  File::create('not-a-image.pdf')
        ]));

        $response->assertRedirect(route('admin.customers.create'));
        //$response->assertSessionHasErrors('avatar');
        $this->assertEquals(0, Customer::count());
        Mail::assertNotQueued(CustomerWelcomeEmail::class);
    }
}

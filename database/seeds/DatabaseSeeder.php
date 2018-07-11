<?php

use App\VitalGym\Entities\User;
use Illuminate\Database\Seeder;
use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\MembershipType;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin User
        factory(User::class)->states('admin', 'active')->create([
            'name' => 'John Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
        ]);

        //Customers
        factory(Customer::class)->times(50)->create();

        //Membership types
        factory(MembershipType::class)->create(['name' => 'mensual', 'price' => 3000]);
        factory(MembershipType::class)->create(['name' => 'trimestral', 'price' => 8000]);
        factory(MembershipType::class)->create(['name' => 'Semestral', 'price' => 16000]);
        factory(MembershipType::class)->create(['name' => 'mensual', 'price' => 32000]);
    }
}

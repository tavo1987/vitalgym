<?php

namespace App\Http\Controllers\Admin;

use App\VitalGym\Entities\Customer;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Level;
use App\Mail\CustomerWelcomeEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CreateCustomerFormRequest;

class CustomerController extends Controller
{
    public function create()
    {
        $levels = Level::all();

        return view('admin.customers.create', compact('levels'));
    }

    public function edit($customerId)
    {
        $customer = Customer::with('routine', 'level')->findOrFail($customerId);
        $routine = $customer->routine;
        $level = $customer->level;
        $levels = Level::all();
        return view('admin.customers.edit', compact('customer', 'levels', 'level', 'routine'));
    }

    public function store(CreateCustomerFormRequest $request)
    {
        $user = User::createWithActivationToken([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'avatar' => $request->hasFile('avatar') ? $request->file('avatar')->store('avatars', 'public') : 'avatars/default-avatar',
            'email' => $request->email,
            'phone' => $request->phone,
            'cell_phone' => $request->cell_phone,
            'address' => $request->address,
            'role' => 'customer',
        ]);

        $customer = $user->customer()->create([
            'ci' => $request->ci,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'medical_observations' => $request->medical_observations,
            'routine_id' => $request->routine_id,
            'level_id' => $request->level_id,
        ]);

        Mail::to($customer->email)->send(new CustomerWelcomeEmail($customer));

        return redirect()->route('admin.customers.index')
                         ->with(['alert-type' => 'success', 'message' => 'cliente creado con éxito']);
    }

    public function update(Request $request, $customerId)
    {
        $customer = Customer::with('user')->findOrFail($customerId);

        $user = $customer->user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'avatar' => $request->hasFile('avatar') ? $request->file('avatar')->store('avatars', 'public') : 'avatars/default-avatar',
            'email' => $request->email,
            'phone' => $request->phone,
            'cell_phone' => $request->cell_phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
        ]);

        $customer->update([
            'ci' => $request->ci,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'medical_observations' => $request->medical_observations,
            'routine_id' => $request->routine_id,
            'level_id' => $request->level_id,
        ]);

        return redirect()->route('admin.customers.index')
                         ->with(['alert-type' => 'success', 'message' => 'cliente actualizado con éxito']);
    }
}

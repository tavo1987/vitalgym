<?php

namespace App\Http\Controllers\Admin;

use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Level;
use App\Mail\CustomerWelcomeEmail;
use App\VitalGym\Entities\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CreateCustomerFormRequest;
use App\Http\Requests\UpdateCustomerFormRequest;

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

    public function show($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        return view('admin.customers.show', compact('customer'));
    }

    public function store(CreateCustomerFormRequest $request)
    {
        $user = User::createWithActivationToken($request->userRequestParams());
        $user->customer()->create($request->customerRequestParams());
        Mail::to($user->email)->send(new CustomerWelcomeEmail($user->customer));

        return redirect()->route('admin.customers.index')
                         ->with(['alert-type' => 'success', 'message' => 'cliente creado con éxito']);
    }

    public function update(UpdateCustomerFormRequest $request, $customerId)
    {
        $customer = Customer::with('user')->findOrFail($customerId);

        $customer->update($request->customerRequestParams());
        $customer->user->update($request->userRequestParams());

        return redirect()->route('admin.customers.index')
                         ->with(['alert-type' => 'success', 'message' => 'cliente actualizado con éxito']);
    }
}

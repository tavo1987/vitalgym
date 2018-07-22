<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Level;
use App\VitalGym\Entities\Customer;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function create()
    {
        $levels = Level::all();

        return view('admin.customers.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'avatar' => $request->hasFile('avatar') ? $request->file('avatar')->store('avatars', 'public') : 'default-avatar',
            'email' => $request->email,
            'phone' => $request->phone,
            'cell_phone' => $request->cell_phone,
            'address' => $request->address,
            'role' => 'customer',
            'active' => (bool) $request->active,
        ]);

        Customer::create([
            'ci' => $request->ci,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'medical_observations' => $request->medical_observations,
            'routine_id' => $request->routine_id,
            'level_id' => $request->level_id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.customers.index')
                         ->with(['alert-type' => 'success', 'message' => 'cliente creado con éxito']);
    }
}

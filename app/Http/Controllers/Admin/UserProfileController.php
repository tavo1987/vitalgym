<?php

namespace App\Http\Controllers\Admin;

use App\VitalGym\Entities\User;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        return view('admin.profile', compact('user'));
    }

    public function update()
    {
        $userRequestData = collect([
            'name' => request()->get('name'),
            'last_name' => request()->get('last_name'),
            'avatar' => request()->hasFile('avatar') ? request()->file('avatar')->store('avatars', 'public') : auth()->user()->avatar,
            'email' => request()->get('email'),
            'phone' => request()->get('phone'),
            'cell_phone' => request()->get('cell_phone'),
            'address' => request()->get('address'),
        ]);

        if (request()->has('password')) {
            $userRequestData = $userRequestData->merge([
                'password' => bcrypt(request()->get('password')),
            ]);
        }

        auth()->user()->update($userRequestData->toArray());

        return redirect()->route('admin.profile.edit')->with(['message' => 'Perfil Actualizado con éxito', 'alert-type' => 'success']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use function view;
use function redirect;
use App\VitalGym\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserFormRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereRole('admin')
                     ->whereNotIn('id', [auth()->user()->id])
                     ->orderByDesc('id')
                     ->paginate();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(CreateUserFormRequest $request)
    {
        User::createWithActivationToken($request->userParams());

        return redirect()->route('admin.users.index')->with(['message' => 'Usuario creado con éxito', 'alert-type' => 'success']);
    }
}

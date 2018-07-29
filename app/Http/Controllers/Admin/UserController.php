<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateUserFormRequest;
use App\VitalGym\Entities\User;
use App\Http\Controllers\Controller;
use function redirect;
use function view;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNotIn('id', [auth()->user()->id])->orderByDesc('id')->paginate();

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

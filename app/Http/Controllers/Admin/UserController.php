<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\VitalGym\Entities\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNotIn('id', [auth()->user()->id])->get();

        return view('admin.users.index', compact('users'));
    }
}

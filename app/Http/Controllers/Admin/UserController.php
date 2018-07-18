<?php

namespace App\Http\Controllers\Admin;

use App\VitalGym\Entities\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNotIn('id', [auth()->user()->id])->paginate();

        return view('admin.users.index', compact('users'));
    }
}

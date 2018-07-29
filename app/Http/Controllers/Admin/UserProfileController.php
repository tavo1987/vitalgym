<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        return view('admin.profile', compact('user'));
    }
}

<?php

namespace App\Http\Controllers;

use App\VitalGym\Entities\Membership;

class MembershipTypeController extends Controller
{
    public function index()
    {
        $membershipTypes = Membership::all();

        return view('admin.membership-type.index', compact('membershipTypes'));
    }
}

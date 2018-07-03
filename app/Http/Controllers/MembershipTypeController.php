<?php

namespace App\Http\Controllers;

use App\VitalGym\Entities\MembershipType;

class MembershipTypeController extends Controller
{
    public function index()
    {
        $membershipTypes = MembershipType::all();

        return view('admin.membership-types.index', compact('membershipTypes'));
    }
}

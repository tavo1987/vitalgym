<?php

namespace App\Http\Controllers;

use App\VitalGym\Entities\Customer;

class MembershipController extends Controller
{
    public function store()
    {
        $customer = Customer::findOrFail(request('customer_id'));

        $customer->memberships()->create([
            'date_start' => request('date_start'),
            'date_end' => request('date_start'),
            'total_days' => request('total_days'),
            'membership_type_id' => request('membership_type_id'),
        ]);

        return response()->json([], 201);
    }
}

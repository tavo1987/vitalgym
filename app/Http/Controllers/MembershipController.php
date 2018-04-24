<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipFormRequest;
use Illuminate\Support\Facades\Mail;
use App\VitalGym\Entities\Membership;
use App\Mail\MembershipOrderConfirmationEmail;

class MembershipController extends Controller
{
    public function store(MembershipFormRequest $request)
    {
        $membership = Membership::create([
            'date_start' => $request->get('date_start'),
            'date_end' => $request->get('date_end'),
            'total_days' => $request->get('total_days'),
            'membership_type_id' => $request->get('membership_type_id'),
            'customer_id' => $request->get('customer_id'),
        ]);

        $membership->payments()->create([
            'customer_id' => $request->get('customer_id'),
            'total_price' => $membership->membershipType->price * $request->get('quantity'),
            'membership_quantity' => $request->get('quantity'),
            'user_id' => auth()->user()->id,
        ]);

        Mail::to($membership->customer->email)->send(new MembershipOrderConfirmationEmail($membership));

        return response()->json([], 201);
    }
}

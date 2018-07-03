<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\VitalGym\Entities\Membership;
use App\Mail\MembershipOrderConfirmationEmail;
use App\Http\Requests\CreateMembershipFormRequest;

class MembershipController extends Controller
{
    public function create()
    {
        return view('admin.memberships.create');
    }

    public function store(CreateMembershipFormRequest $request)
    {
        $membership = Membership::create([
            'date_start' => $request->get('date_start'),
            'date_end' => $request->get('date_end'),
            'total_days' => $request->get('total_days'),
            'membership_type_id' => $request->get('membership_type_id'),
            'customer_id' => $request->get('customer_id'),
        ]);

        $membership->payment()->create([
            'customer_id' => $request->get('customer_id'),
            'total_price' => $membership->membershipType->price * $request->get('membership_quantity'),
            'membership_quantity' => $request->get('membership_quantity'),
            'user_id' => auth()->user()->id,
        ]);

        Mail::to($membership->customer->email)->send(new MembershipOrderConfirmationEmail($membership));

        return redirect()->route('memberships.index')->with(['message' => 'Membresía guardada con éxito', 'alert-type' => 'success']);
    }
}

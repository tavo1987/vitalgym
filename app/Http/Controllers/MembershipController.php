<?php

namespace App\Http\Controllers;

use App\VitalGym\Entities\Payment;
use App\VitalGym\Entities\Customer;
use Illuminate\Support\Facades\Mail;
use App\VitalGym\Entities\Membership;
use App\VitalGym\Entities\MembershipType;
use App\Mail\MembershipOrderConfirmationEmail;
use App\Http\Requests\CreateMembershipFormRequest;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::all();

        return view('admin.memberships.index', compact('memberships'));
    }

    public function create($membershipTypeId)
    {
        $membershipType = MembershipType::findOrFail($membershipTypeId);
        $customers = Customer::all();

        return view('admin.memberships.create', compact('customers', 'membershipType'));
    }

    public function store(CreateMembershipFormRequest $request)
    {
        $membershipType = MembershipType::find($request->get('membership_type_id'));
        $payment = Payment::create([
            'customer_id' => $request->get('customer_id'),
            'total_price' => $membershipType->price * $request->get('membership_quantity'),
            'membership_quantity' => $request->get('membership_quantity'),
            'user_id' => auth()->user()->id,
        ]);

        $membership = $payment->membership()->create([
            'date_start' => $request->get('date_start'),
            'date_end' => $request->get('date_end'),
            'total_days' => $request->get('total_days'),
            'membership_type_id' => $membershipType->id,
            'customer_id' => $payment->customer_id,
        ]);

        Mail::to($membership->customer->email)->send(new MembershipOrderConfirmationEmail($membership));

        return redirect()->route('memberships.index')->with(['message' => 'Membresía guardada con éxito', 'alert-type' => 'success']);
    }
}
